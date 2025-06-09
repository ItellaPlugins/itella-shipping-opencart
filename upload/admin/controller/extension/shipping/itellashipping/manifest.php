<?php
require_once(DIR_SYSTEM . 'library/itella_lib/itella-api/vendor/autoload.php');

use Mijora\Itella\CallCourier;

class ControllerExtensionShippingItellashippingManifest extends Controller
{

  private $success;

  public function index()
  {
    $this->load->language('extension/shipping/itellashipping');

    $this->document->setTitle($this->language->get('browser_tab_manifest'));

    $data['error_warning'] = '';
    $tab = 'all';

    if (isset($this->request->get['page'])) {
      $page = $this->request->get['page'];
    } else {
      $page = 1;
    }

    $url = '';

    if (isset($this->request->get['page'])) {
      $url .= '&page=' . $this->request->get['page'];
    }

    $this->handleJSONRequest();

    if (isset($this->request->get['tab'])) {
      if (in_array($this->request->get['tab'], array('all', 'manifest'))) {
        $url .= '&tab=' . $this->request->get['tab'];
        $tab = $this->request->get['tab'];
        $this->handleTabActions($tab);
      }
    }

    $filter = $this->getFilterData();
    $data = array_merge($data, $filter);
    $data['filter'] = isset($this->session->data['itella_filter']);

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    $data['breadcrumbs'] = array();
    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/dashboard', $this->getUserToken(), true),
    );
    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_manifest'),
      'href' => $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken(), true),
    );

    // Load translations
    // Tabs
    foreach (array('all', 'manifest') as $key) {
      $data['tab_' . $key] = $this->language->get('tab_' . $key);
    }
    // Buttons
    foreach (array(
      'label', 'print', 'view', 'gen_label',
      'call_courier', 'mass_generate', 'mass_print',
      'generate_manifest', 'mass_manifest', 'filter', 'reset',
      'show', 'resend_email'
    ) as $key) {
      $data['btn_' . $key] = $this->language->get('btn_' . $key);
    }
    // Errors
    foreach (array('itella_error') as $key) {
      $data['error_' . $key] = $this->language->get('error_' . $key);
    }
    // Loading
    $data['lng_loading'] = $this->language->get('itella_lng_loading');
    // Other
    foreach (array(
      'id', 'customer', 'tracking_nr',
      'status', 'date_added', 'date_modified',
      'actions', 'total_orders', 'no_manifest', 'no_orders',
      'mass_action_notice', 'missing', 'label_caution',
      'no_order_selected',
      'modal_order_title', 'modal_title', 'modal_message', 'modal_name', 'modal_address',
      'modal_phone', 'modal_manifest_id', 'modal_btn_call', 'modal_btn_cancel'
    ) as $key) {
      $data['lng_' . $key] = $this->language->get('lng_' . $key);
    }

    $data['active_tab'] = $tab;

    // handle pages for tabs (if not selected tab reset to first page)
    $all_page = ($tab == 'all' ? $page : 1);
    $manifest_page = ($tab == 'manifest' ? $page : 1);

    $this->load->model('extension/itellashipping/manifest');
    $manifest = $this->model_extension_itellashipping_manifest;

    $results = $manifest->getOrders($all_page, $filter);
    $data['tracking_email_status'] = (bool) $this->config->get('itellashipping_tracking_email_status');
    $data['orders'] = array();
    foreach ($results as $result) {
      $actions = array();
      if ($result['label_number']) {
        $actions['resend_email'] = $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=all&resend_email&id_order=' . $result['order_id'], true);
        $actions['label'] = $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=all&print&id_order=' . $result['order_id'], true);
        $actions['generate_manifest'] = $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=manifest&generate&id_order=' . $result['order_id'], true);
      } else {
        $actions['gen_label'] = $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=all&gen_label&id_order=' . $result['order_id'], true);
      }
      $data['orders'][] = array(
        'order_id'      => $result['order_id'],
        'customer'      => $result['customer'],
        'label_number'  => $result['label_number'],
        'order_status'  => $result['order_status'] ? $result['order_status'] : $this->language->get('text_missing'),
        'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
        'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
        'view'          => $this->url->link('sale/order/info', $this->getUserToken() . '&order_id=' . $result['order_id'] . $url, true),
        'actions'       => $actions,
        'itella_error'  => $result['itella_error']
      );
    }
    $data['form_btn'] = array(
      'filter'            => $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=all&filter', true),
      'filter_reset'      => $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=all&filter_reset', true),
      'mass_label_gen'    => $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=all&mass_gen', true),
      'mass_label_print'  => $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=all&mass_print', true),
      'mass_manifest_gen' => $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=manifest&mass_gen', true),
    );
    $order_total = $manifest->getOrdersCount($filter);
    $data['order_total'] = $order_total;

    $pagination = new Pagination();
    $pagination->total = $order_total;
    $pagination->page = $page;
    $pagination->limit = $this->config->get('config_limit_admin');
    $pagination->url = $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=all&page={page}', true);
    $data['pagination'] = $pagination->render();

    $results = $manifest->getManifests($manifest_page);
    $data['manifests'] = array();
    foreach ($results as $result) {
      $data['manifests'][] = array(
        'id_itella_manifest'  => $result['id_itella_manifest'],
        'order_total'         => $result['order_total'],
        'date_added'          => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
        'show_orders'         => $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&ajaxManifestOrders&id_manifest=' . $result['id_itella_manifest'], true),
        'print'               => $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=manifest&print&id_manifest=' . $result['id_itella_manifest'], true),
        'call_courier'        => $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=manifest&call&id_manifest=' . $result['id_itella_manifest'], true)
      );
    }
    $manifest_total = $manifest->getManifestsCount();
    $data['manifest_total'] = $manifest_total;
    $data['manifest_view_order'] = $this->url->link('sale/order/info', $this->getUserToken() . '&order_id=', true);

    $manifest_pagination = new Pagination();
    $manifest_pagination->total = $manifest_total;
    $manifest_pagination->page = $page;
    $manifest_pagination->limit = $this->config->get('config_limit_admin');
    $manifest_pagination->url = $this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=manifest&page={page}', true);
    $data['manifest_pagination'] = $manifest_pagination->render();

    $data['call_info'] = array(
      'name' => $this->config->get('itellashipping_sender_name'),
      'address' => $this->getSenderAddress(),
      'contact_phone' => $this->config->get('itellashipping_sender_phone'),
      'message' => $this->config->get('itellashipping_advanced_call_message')
    );

    $this->load->model('localisation/order_status');
    $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

    if (isset($this->session->data['success'])) {
      $this->success[] = $this->session->data['success'];

      unset($this->session->data['success']);
    }

    if (isset($this->session->data['itella_error'])) {
      $data['error_warning'] = $this->session->data['itella_error'];

      unset($this->session->data['itella_error']);
    }

    if ($this->success) {
      $data['success'] = implode(', ', $this->success);
    } else {
      $data['success'] = false;
    }

    $this->response->setOutput($this->load->view('extension/itellashipping/manifest', $data));
  }

  private function handleTabActions($tab = 'all')
  {
    $redirect = false;
    switch ($tab) {
      case 'all':
        if (isset($this->request->get['filter'])) {
          $this->saveFilter();
        }
        if (isset($this->request->get['filter_reset'])) {
          $this->resetFilter();
        }
        if (isset($this->request->get['gen_label']) && isset($this->request->get['id_order'])) {
          $result = $this->generateLabel((int) $this->request->get['id_order']);
          if (isset($result['error'])) {
            $this->session->data['itella_error'] = $result['error'];
          }
          if (isset($result['success'])) {
            $this->session->data['success'] = $result['success'];
          }
          $redirect = true;
        }
        if (isset($this->request->get['mass_gen']) && isset($this->request->post['order_ids'])) {
          $result = $this->generateLabels($this->request->post['order_ids']);
          if (isset($result['error'])) {
            if (is_array($result['error'])) {
              $errors = array('<ul>');
              foreach ($result['error'] as $error) {
                $errors[] = "<li>$error</li>";
              }
              $errors[] = '</ul';
            } else {
              $errors = array($result['error']);
            }
            $this->session->data['itella_error'] = 'Found errors: <br>' . implode(" \n", $errors);
          }
          if (isset($result['success'])) {
            $this->session->data['success'] = $result['success'];
          }
          $redirect = true;
        }
        if (isset($this->request->get['print']) && isset($this->request->get['id_order'])) {
          $result = $this->printLabel((int) $this->request->get['id_order']);
          if (isset($result['error'])) {
            $this->session->data['itella_error'] = $result['error'];
          }
          $redirect = true;
        }
        if (isset($this->request->get['resend_email']) && isset($this->request->get['id_order'])) {
          $result = $this->resendEmail((int) $this->request->get['id_order']);
          if (isset($result['success'])) {
            $this->session->data['success'] = $result['success'];
          }

          if (isset($result['error'])) {
            $this->session->data['itella_error'] = $result['error'];
          }

          $redirect = true;
        }
        if (isset($this->request->get['mass_print']) && isset($this->request->post['order_ids'])) {
          $result = $this->printLabels($this->request->post['order_ids']);
          //$result = array('error' => implode(', ', $this->request->post['order_ids']));
          if (isset($result['error'])) {
            $this->session->data['itella_error'] = $result['error'];
          }
          $redirect = true;
        }
        break;
      case 'manifest':
        if ((isset($this->request->get['generate']) || isset($this->request->get['mass_gen'])) &&
          (isset($this->request->get['id_order']) || isset($this->request->post['order_ids']))
        ) {
          if (isset($this->request->get['id_order'])) {
            $id_orders = array((int) $this->request->get['id_order']);
          }

          if (isset($this->request->post['order_ids'])) {
            $id_orders = $this->request->post['order_ids'];
          }

          $result = $this->generateManifest($id_orders);
          if (isset($result['error'])) {
            $this->session->data['itella_error'] = $result['error'];
            $tab = 'all'; // if error leave order tab as active
          }
          if (isset($result['success'])) {
            $this->session->data['success'] = $result['success'];
          }
          $redirect = true;
        }

        if (isset($this->request->get['call']) && isset($this->request->get['id_manifest'])) {
          $result = $this->callCourier((int) $this->request->get['id_manifest'], array(
            'message' => (isset($this->request->get['call_message'])) ? $this->request->get['call_message'] : '',
            'date' => (isset($this->request->get['call_date'])) ? $this->request->get['call_date'] : '',
            'time_from' => (isset($this->request->get['call_time_from'])) ? $this->request->get['call_time_from'] : '',
            'time_to' => (isset($this->request->get['call_time_to'])) ? $this->request->get['call_time_to'] : ''
          ));
          if (isset($result['error'])) {
            $this->session->data['itella_error'] = $result['error'];
          }
          if (isset($result['success'])) {
            $this->session->data['success'] = $result['success'];
          }
          $redirect = true;
        }

        if (isset($this->request->get['print']) && isset($this->request->get['id_manifest'])) {
          $result = $this->printManifest((int) $this->request->get['id_manifest']);
          if (isset($result['error'])) {
            $this->session->data['itella_error'] = $result['error'];
          }
          $redirect = true;
        }
        break;
    }

    if ($redirect) {
      $this->response->redirect($this->url->link('extension/shipping/itellashipping/manifest', $this->getUserToken() . '&tab=' . $tab, true));
    }
  }

  private function handleJSONRequest()
  {
    $json = false;
    try {
      if (isset($this->request->get['ajaxManifestOrders']) && isset($this->request->get['id_manifest'])) {
        $this->load->model('extension/itellashipping/manifest');
        $data = $this->model_extension_itellashipping_manifest->getManifestOrders((int) $this->request->get['id_manifest']);
        $json = array(
          'success' => true,
          'data' => $data
        );
      }
    } catch (\Exception $e) {
      $json = array(
        'error' => $e->getMessage()
      );
    }
    if ($json) {
      $this->sendJSONResponse($json);
    }
  }

  private function sendJSONResponse($json)
  {
    echo json_encode($json);
    exit();
  }

  private function getFilterData()
  {
    $filter = array(
      'filter_order_id' => null,
      'filter_customer' => null,
      'filter_order_status' => null,
      'filter_tracking' => null,
      'filter_date_added' => null,
      'filter_date_modified' => null,
    );

    if (isset($this->session->data['itella_filter'])) {
      $filter = array_merge($filter, $this->session->data['itella_filter']);
    }

    return $filter;
  }

  private function saveFilter()
  {
    $filter = array(
      'filter_order_id' => null,
      'filter_customer' => null,
      'filter_order_status' => null,
      'filter_tracking' => null,
      'filter_date_added' => null,
      'filter_date_modified' => null,
    );
    if (isset($this->request->post['filter_order_id'])) {
      $filter['filter_order_id'] = $this->request->post['filter_order_id'];
    }

    if (isset($this->request->post['filter_customer'])) {
      $filter['filter_customer'] = $this->request->post['filter_customer'];
    }

    if (isset($this->request->post['filter_order_status'])) {
      $filter['filter_order_status'] = $this->request->post['filter_order_status'];
    }

    if (isset($this->request->post['filter_tracking'])) {
      $filter['filter_tracking'] = $this->request->post['filter_tracking'];
    }

    if (isset($this->request->post['filter_date_added'])) {
      $filter['filter_date_added'] = $this->request->post['filter_date_added'];
    }

    if (isset($this->request->post['filter_date_modified'])) {
      $filter['filter_date_modified'] = $this->request->post['filter_date_modified'];
    }

    $filter = array_filter($filter);

    if ($filter) {
      $this->session->data['itella_filter'] = $filter;
    } else {
      $this->resetFilter();
    }
  }

  private function resetFilter()
  {
    unset($this->session->data['itella_filter']);
  }

  private function generateLabel($id_order)
  {
    $this->load->model('extension/itellashipping/itellashipping');
    $order = $this->model_extension_itellashipping_itellashipping;
    return $order->generateLabel($id_order);
  }

  private function generateLabels($id_orders)
  {
    $this->load->language('extension/shipping/itellashipping');

    $this->load->model('extension/itellashipping/itellashipping');
    $order = $this->model_extension_itellashipping_itellashipping;

    $id_orders = $order->filterOrderIdArr($id_orders);

    if (empty($id_orders)) {
      return array('error' => $this->language->get('error_itella_empty'));
    }

    $errors = array();
    $success = array();
    foreach ($id_orders as $id_order) {
      $result = $order->generateLabel($id_order);
      if (isset($result['error'])) {
        $errors[] = $id_order . ': ' . $result['error'];
      }

      if (isset($result['success'])) {
        $success[] = $id_order;
      }
    }

    $final_result = array();

    if ($errors) {
      $final_result['error'] = $errors;
    }

    if ($success) {
      $final_result['success'] = $this->language->get('lng_total_registered') . ' ' . count($success);
    }

    return $final_result;
  }

  private function generateManifest($id_orders)
  {
    $this->load->model('extension/itellashipping/itellashipping');
    $order = $this->model_extension_itellashipping_itellashipping;
    return $order->registerManifest($id_orders);
  }

  private function resendEmail($id_order)
  {
    $this->load->model('extension/itellashipping/itellashipping');
    $order = $this->model_extension_itellashipping_itellashipping;
    return $order->sendTrackingUrl($id_order);
  }

  private function printLabel($id_order)
  {
    $this->load->model('extension/itellashipping/itellashipping');
    $order = $this->model_extension_itellashipping_itellashipping;
    $pdf = $order->getLabel($id_order);
    $pdf = base64_decode($pdf);
    if ($pdf) { // check if its not empty
      $filename = 'itella_' . $id_order;
      $path = DIR_DOWNLOAD  . $filename . '.pdf';
      file_put_contents($path, $pdf);
      // make sure there is nothing before headers
      if (ob_get_level()) ob_end_clean();
      header("Content-Type: application/pdf");
      header("Content-Transfer-Encoding: binary");
      header('Content-Disposition: attachment; filename="itella_' . $id_order . '.pdf"');
      // disable caching on client and proxies, if the download content vary
      header("Expires: 0");
      header("Cache-Control: no-cache, must-revalidate");
      header("Pragma: no-cache");
      readfile($path);
      //return array('success' => $id_order . ': ' . $this->language->get('itella_label_downloaded'));
    } else {
      return array('error' => $id_order . ': ' . $this->language->get('error_empty_label'));
    }
  }

  private function printLabels($id_orders)
  {
    $this->load->model('extension/itellashipping/itellashipping');
    $order = $this->model_extension_itellashipping_itellashipping;
    $pdf = $order->getLabels($id_orders);

    $pdf = base64_decode($pdf);
    if ($pdf) { // check if its not empty
      $filename = 'itella_' . time();
      $path = DIR_DOWNLOAD  . $filename . '.pdf';
      file_put_contents($path, $pdf);
      // make sure there is nothing before headers
      if (ob_get_level()) ob_end_clean();
      header("Content-Type: application/pdf");
      header("Content-Transfer-Encoding: binary");
      header('Content-Disposition: attachment; filename="itella_labels.pdf"');
      // disable caching on client and proxies, if the download content vary
      header("Expires: 0");
      header("Cache-Control: no-cache, must-revalidate");
      header("Pragma: no-cache");
      readfile($path);
      //return array('success' => $id_order . ': ' . $this->language->get('itella_label_downloaded'));
    } else {
      return array('error' => $this->language->get('error_empty_label'));
    }
  }

  private function printManifest($id_manifest)
  {
    $this->load->model('extension/itellashipping/itellashipping');
    $order = $this->model_extension_itellashipping_itellashipping;
    $pdf = $order->getManifest($id_manifest);

    if (isset($pdf['error'])) {
      return $pdf;
    }

    $pdf = base64_decode($pdf);
    $filename = 'itella_manifest_' . time();
    $path = DIR_DOWNLOAD  . $filename . '.pdf';
    file_put_contents($path, $pdf);
    // make sure there is nothing before headers
    if (ob_get_level()) ob_end_clean();
    header("Content-Type: application/pdf");
    header("Content-Transfer-Encoding: binary");
    header('Content-Disposition: attachment; filename="itella_manifest.pdf"');
    // disable caching on client and proxies, if the download content vary
    header("Expires: 0");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    readfile($path);
  }

  private function callCourier($id_manifest, $params = array())
  {
    $this->load->language('extension/shipping/itellashipping');

    $this->load->model('extension/itellashipping/itellashipping');
    $order = $this->model_extension_itellashipping_itellashipping;
    
    $default_params = array(
      'message'   => '',
      'date'      => date('Y-m-d', strtotime('+1 day')),
      'time_from' => '08:00',
      'time_to'   => '17:00'
    );
    $params = array_merge($default_params, array_filter($params, fn($v) => $v !== ''));

    $pdf = $order->getManifest($id_manifest);
    if (isset($pdf['error'])) {
      return $pdf;
    }

    $decoded_pdf = base64_decode($pdf);
    $manifest_file = DIR_DOWNLOAD  . 'manifest.pdf';
    file_put_contents($manifest_file, $decoded_pdf);
    if (!is_file($manifest_file)) {
      return ['error' => 'Failed to save manifest in storage directory'];
    }

    $items = $order->getItems($id_manifest);
    if (isset($items['error'])) {
      return $items;
    }

    $username = $this->config->get('itellashipping_api_user_2317');
    $password = $this->config->get('itellashipping_api_pass_2317');
    if (empty($username)) {
      $username = $this->config->get('itellashipping_api_user_2711');
      $password = $this->config->get('itellashipping_api_pass_2711');
    }
    $sender_code = $this->config->get('itellashipping_sender_code');

    $send_to = $this->config->get('itellashipping_advanced_email_' . strtoupper($this->config->get('itellashipping_sender_country')));

    $errors = array();
    $success = array();

    try {
      $caller = new CallCourier($send_to);
      $caller
        ->setUsername($username)
        ->setPassword($password)
        ->setSenderEmail($this->config->get('itellashipping_sender_email'))
        ->setSubject($this->config->get('itellashipping_advanced_email_subject'))
        ->setPickUpAddress(array(
          'sender' => $this->config->get('itellashipping_sender_name'),
          'address_1' => $this->config->get('itellashipping_sender_street'),
          'postcode' => $this->config->get('itellashipping_sender_postcode'),
          'city' => $this->config->get('itellashipping_sender_city'),
          'country' => $this->config->get('itellashipping_sender_country'),
          'contact_phone' => $this->config->get('itellashipping_sender_phone'),
        ))
        ->setPickUpParams(array(
          'date' => $params['date'],
          'time_from' => $params['time_from'],
          'time_to' => $params['time_to'],
          'info_general' => $params['message'],
          'id_sender' => $sender_code,
        ))
        ->setAttachment($pdf)
        ->setItems($items)
        ->disableMethod('email');

      $result_api = $caller->callCourier();
      if (!empty($result_api['errors'])) {
        $errors = array_merge($errors, $result_api['errors']);
      }
      if (!empty($result_api['success'])) {
        $success = array_merge($success, $result_api['success']);
      }
    } catch (\Exception $e) {
      $errors[] = $e->getMessage();
      return array('error' => $this->language->get('lng_call_failed') . ' ' . $e->getMessage());
    }

    try {
      if (!$send_to) {
        throw new \Exception($this->language->get('lng_courier_email_missing'));
      }

      if (version_compare(VERSION, '3.0.0', '>=')) {
        $mail = new Mail($this->config->get('config_mail_engine'));
      } else { // OC 2.3
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
      }

      $mail->parameter = $this->config->get('config_mail_parameter');
      $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
      $mail->smtp_username = $this->config->get('config_mail_smtp_username');
      $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
      $mail->smtp_port = $this->config->get('config_mail_smtp_port');
      $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

      $mail->setTo($send_to);
      $mail->setFrom($this->config->get('itellashipping_sender_email'));
      $mail->setSender(html_entity_decode($this->config->get('itellashipping_sender_name'), ENT_QUOTES, 'UTF-8'));
      $subject = $this->config->get('itellashipping_advanced_email_subject');
      $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
      $mail->addAttachment($manifest_file);
      $mail->setHtml($caller->buildMailBody());
      $mail->send();

      $success[] = $this->language->get('lng_call_mail_success');
    } catch (\Exception $e) {
      $errors[] = $e->getMessage();
    }

    $return = array();
    if (!empty($errors)) {
      $return['error'] = '<b>' . $this->language->get('lng_call_failed') . '</b><br/>— ' . implode('<br/>— ', $errors);
    }
    if (!empty($success)) {
      $return['success'] = '<b>' . $this->language->get('lng_call_success') . '</b> ' . $this->getSenderAddress() . '.<br/>— ' . implode('<br/>— ', $success);
    }
    return $return;
  }

  private function getSenderAddress()
  {
    return $this->config->get('itellashipping_sender_street') . ', ' . $this->config->get('itellashipping_sender_postcode')
      . ' ' . $this->config->get('itellashipping_sender_city') . ', ' . $this->config->get('itellashipping_sender_country');
  }

  protected function getUserToken()
  {
    if (version_compare(VERSION, '3.0.0', '>=')) {
      return 'user_token=' . $this->session->data['user_token'];
    }
    return 'token=' . $this->session->data['token'];
  }
}
