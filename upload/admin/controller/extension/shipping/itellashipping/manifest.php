<?php
require_once(DIR_SYSTEM . 'library/itella_lib/itella-api/vendor/autoload.php');

use Mijora\Itella\CallCourier;

class ControllerExtensionShippingItellashippingManifest extends Controller
{

  private $success;

  public function index()
  {
    $this->load->language('extension/shipping/itellashipping');

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
      'text' => 'Home', //$this->language->get('text_home'),
      'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
    );
    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_manifest'),
      'href' => $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'], true),
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
      'show'
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
    $data['orders'] = array();
    foreach ($results as $result) {
      $actions = array();
      if ($result['label_number']) {
        $actions['label'] = $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&tab=all&print&id_order=' . $result['order_id'], true);
        $actions['generate_manifest'] = $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&tab=manifest&generate&id_order=' . $result['order_id'], true);
      } else {
        $actions['gen_label'] = $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&tab=all&gen_label&id_order=' . $result['order_id'], true);
      }
      $data['orders'][] = array(
        'order_id'      => $result['order_id'],
        'customer'      => $result['customer'],
        'label_number'  => $result['label_number'],
        'order_status'  => $result['order_status'] ? $result['order_status'] : $this->language->get('text_missing'),
        'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
        'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
        'view'          => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true),
        'actions'       => $actions,
        'itella_error'  => $result['itella_error']
      );
    }
    $data['form_btn'] = array(
      'filter'            => $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&tab=all&filter', true),
      'filter_reset'      => $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&tab=all&filter_reset', true),
      'mass_label_gen'    => $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&tab=all&mass_gen', true),
      'mass_label_print'  => $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&tab=all&mass_print', true),
      'mass_manifest_gen' => $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&tab=manifest&mass_gen', true),
    );
    $order_total = $manifest->getOrdersCount($filter);
    $data['order_total'] = $order_total;

    $pagination = new Pagination();
    $pagination->total = $order_total;
    $pagination->page = $page;
    $pagination->limit = $this->config->get('config_limit_admin');
    $pagination->url = $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&tab=all&page={page}', true);
    $data['pagination'] = $pagination->render();

    $results = $manifest->getManifests($manifest_page);
    $data['manifests'] = array();
    foreach ($results as $result) {
      $data['manifests'][] = array(
        'id_itella_manifest'  => $result['id_itella_manifest'],
        'order_total'         => $result['order_total'],
        'date_added'          => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
        'show_orders'         => $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&ajaxManifestOrders&id_manifest=' . $result['id_itella_manifest'], true),
        'print'               => $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&tab=manifest&print&id_manifest=' . $result['id_itella_manifest'], true),
        'call_courier'        => $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&tab=manifest&call&id_manifest=' . $result['id_itella_manifest'], true)
      );
    }
    $manifest_total = $manifest->getManifestsCount();
    $data['manifest_total'] = $manifest_total;
    $data['manifest_view_order'] = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=', true);

    $manifest_pagination = new Pagination();
    $manifest_pagination->total = $manifest_total;
    $manifest_pagination->page = $page;
    $manifest_pagination->limit = $this->config->get('config_limit_admin');
    $manifest_pagination->url = $this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&tab=manifest&page={page}', true);
    $data['manifest_pagination'] = $manifest_pagination->render();

    $data['call_info'] = array(
      'name' => $this->config->get('itellashipping_sender_name'),
      'address' => $this->getSenderAddress(),
      'contact_phone' => $this->config->get('itellashipping_sender_phone')
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
          $result = $this->callCourier((int) $this->request->get['id_manifest']);
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
      $this->response->redirect($this->url->link('extension/shipping/itellashipping/manifest', 'token=' . $this->session->data['token'] . '&tab=' . $tab, true));
    }
  }

  private function handleJSONRequest()
  {
    $json = false;
    try {
      if(isset($this->request->get['ajaxManifestOrders']) && isset($this->request->get['id_manifest'])) {
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

  private function callCourier($id_manifest)
  {
    $this->load->language('extension/shipping/itellashipping');

    $this->load->model('extension/itellashipping/itellashipping');
    $order = $this->model_extension_itellashipping_itellashipping;
    $pdf = $order->getManifest($id_manifest);

    if (isset($pdf['error'])) {
      return $pdf;
    }

    try {
      $send_to = $this->config->get('itellashipping_advanced_email_' . strtoupper($this->config->get('itellashipping_sender_country')));
      if (!$send_to) {
        throw new \Exception($this->language->get('lng_courier_email_missing'));
      }
      $store_address = $this->getSenderAddress();
      $mailer = new CallCourier($send_to);
      $result = $mailer
        ->setSenderEmail($this->config->get('itellashipping_sender_email'))
        ->setSubject($this->config->get('itellashipping_advanced_email_subject'))
        ->setPickUpAddress(array(
          'sender' => $this->config->get('itellashipping_sender_name'),
          'address' => $store_address,
          //'pickup_time' => $storeObj->pick_start . ' - ' . $storeObj->pick_finish,
          'contact_phone' => $this->config->get('itellashipping_sender_phone'),
        ))
        ->setAttachment($pdf, true)
        ->callCourier();
      return array('success' => $this->language->get('lng_call_success') . ' ' . $store_address);
    } catch (\Exception $th) {
      return array('error' => $this->language->get('lng_call_failed') . ' ' . $th->getMessage());
    }
  }

  private function getSenderAddress()
  {
    return $this->config->get('itellashipping_sender_street') . ', ' . $this->config->get('itellashipping_sender_postcode')
      . ' ' . $this->config->get('itellashipping_sender_city') . ', ' . $this->config->get('itellashipping_sender_country');
  }
}
