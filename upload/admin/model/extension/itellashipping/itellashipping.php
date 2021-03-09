<?php

require_once(DIR_SYSTEM . 'library/itella_lib/itella-api/vendor/autoload.php');

use Mijora\Itella\ItellaException;
use Mijora\Itella\Helper as ItellaHelper;
use Mijora\Itella\Shipment\Party;
use Mijora\Itella\Shipment\GoodsItem;
use Mijora\Itella\Shipment\AdditionalService;
use Mijora\Itella\Shipment\Shipment;
use Mijora\Itella\Pdf\PDFMerge;
use Mijora\Itella\Pdf\Manifest;

class ModelExtensionItellashippingItellaShipping extends Model
{

  private $_locations = array();

  public function install()
  {

    $sql = array(
      'itella_order' => 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'itella_order` (
        `id_order` int(10) unsigned NOT NULL,
        `is_oversized` tinyint(1) NOT NULL DEFAULT 0,
        `is_call_before_delivery` tinyint(1) NOT NULL DEFAULT 0,
        `is_fragile` tinyint(1) NOT NULL DEFAULT 0,
        `packs` int(10) unsigned NOT NULL DEFAULT 1,
        `is_cod` tinyint(1) NOT NULL DEFAULT 0,
        `weight` decimal(10,2) DEFAULT NULL,
        `volume` decimal(10,2) DEFAULT NULL,
        `cod_amount` decimal(10,2) DEFAULT NULL,
        `is_pickup` tinyint(1) NOT NULL DEFAULT 0,
        `id_pickup_point` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
        `label_number` text COLLATE utf8_unicode_ci NULL,
        `error` text COLLATE utf8_unicode_ci DEFAULT NULL,
        `id_itella_manifest` int(10) unsigned DEFAULT NULL,
        `comment` text COLLATE utf8_unicode_ci DEFAULT NULL,
        PRIMARY KEY (`id_order`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;',

      // 'itella_store' => 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'itella_store` (
      //   `id_itella_store` INT(10) unsigned NOT NULL AUTO_INCREMENT,
      //   `title` varchar(255) NOT NULL,
      //   `postcode` varchar(255) NOT NULL,
      //   `city` varchar(255) NOT NULL,
      //   `phone` varchar(255) NOT NULL,
      //   `country_code` varchar(255) NOT NULL,
      //   `address` varchar(255) NOT NULL,
      //   `pick_start` varchar(255) NOT NULL,
      //   `pick_finish` varchar(255) NOT NULL,
      //   `id_shop` int(11) NOT NULL,
      //   `is_default` tinyint(1) NOT NULL DEFAULT "0",
      //   `active` tinyint(1) NOT NULL DEFAULT "1",
      //   PRIMARY KEY (`id_itella_store`)
      // ) ENGINE=InnoDB DEFAULT CHARSET=utf8;',

      'itella_manifest' => 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'itella_manifest` (
        `id_itella_manifest` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `id_shop` int(10) unsigned DEFAULT NULL,
        `date_add` datetime NOT NULL,
        PRIMARY KEY (`id_itella_manifest`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
    );

    foreach ($sql as $query) {
      try {
        $this->db->query($query);
      } catch (Exception $e) {
      }
    }

    $this->addItellaStatus('itella_status_id', 'Generated Itella Label');
    $this->addItellaStatus('itella_error_id', 'Itella Error');

    $this->copyModificationXML();
  }

  public function copyModificationXML()
  {
    $xml_file = DIR_SYSTEM . 'library/itella_lib/itella_base.ocmod.xml';

    if (version_compare(VERSION, '3.0.0', '>=')) {
      $xml_file = DIR_SYSTEM . 'library/itella_lib/itella_base_oc3.ocmod.xml';
    }

    $target = DIR_SYSTEM . 'itella_base.ocmod.xml';
    if (is_file($target)) {
      unlink($target);
    }

    copy($xml_file, $target);
  }

  public function removeModificationXML()
  {
    $target = DIR_SYSTEM . 'itella_base.ocmod.xml';
    if (is_file($target)) {
      unlink($target);
    }
  }

  public function addItellaStatus($key, $name)
  {
    $query = $this->db->query("SELECT order_status_id FROM " . DB_PREFIX . "order_status WHERE name = '" . $name . "'")->row;
    if (isset($query['order_status_id'])) {
      $this->updateItellaStatusId($key, $query['order_status_id']);
      return true;
    }

    $this->load->model('localisation/order_status');
    $this->load->model('localisation/language');

    $languages = $this->model_localisation_language->getLanguages();
    $itella_status = array();
    foreach ($languages as $lng) {
      $itella_status['order_status'][$lng['language_id']] = array('name' => $name);
    }
    $status_id = false;
    if ($itella_status) {
      $status_id = $this->model_localisation_order_status->addOrderStatus($itella_status);
    }
    if ($status_id) {
      $this->updateItellaStatusId($key, $status_id);
      return true;
    }
    return false;
  }

  public function updateItellaStatusId($key, $id)
  {
    $this->load->model('setting/setting');
    $this->model_setting_setting->editSetting($key, array($key => $id));
  }

  public function uninstall()
  {
    $sql = array(
      'DROP TABLE IF EXISTS `' . DB_PREFIX . 'itella_order`',
      // 'DROP TABLE IF EXISTS `' . DB_PREFIX . 'itella_store`',
      'DROP TABLE IF EXISTS `' . DB_PREFIX . 'itella_manifest`'
    );

    foreach ($sql as $query) {
      try {
        $this->db->query($query);
      } catch (Exception $e) {
      }
    }

    $this->removeModificationXML();
  }

  public function loadFormLng()
  {
    $this->load->language('extension/shipping/itellashipping');
    $itella_lng = array( // itella language strings for order_info_form.tpl
      'title',
      'packets_total',
      'weight',
      'cod', 'no', 'yes', 'cod_amount',
      'carrier', 'courier', 'pickup',
      'pickup_point',
      'extra', 'oversized', 'call_before_delivery', 'fragile', 'multi',
      'comment',
      'print', 'save', 'generate',
      'loading', 'attention', 'prefix'
    );
    $translation = array();
    foreach ($itella_lng as $key) {
      $translation[$key] = $this->language->get('itella_lng_' . $key);
    }
    return $translation;
  }

  public function getOrder($id_order)
  {
    return $this->db->query("
      SELECT * FROM " . DB_PREFIX . "itella_order WHERE id_order = '" . $this->db->escape((int) $id_order) . "' LIMIT 1;
    ")->row;
  }

  public function loadOrder($id_order)
  {
    $order_data = $this->getOrder($id_order);
    $oc_order = $this->getOCOrder($id_order);
    $new_data = false;
    if (!$order_data) {
      $order_data = $this->saveOrderData($oc_order, true);
      $new_data = true;
    }
    // check that pickup point is the same
    // if ($order_data['is_pickup'] && $oc_order['shipping_code'] != 'itellashipping.pickup_' . $order_data['id_pickup_point']) {
    //   $pupCode = explode('_', $oc_order['shipping_code'])[];
    //   $this->updatePickupPointId($order_data['id_order'], )
    // }
    return ['data' => $order_data, 'oc_order' => $oc_order, 'new_order' => $new_data]; //($result ? $result : false);
  }

  public function saveItellaError($id_order, $error_msg)
  {
    $this->db->query("UPDATE `" . DB_PREFIX . "itella_order` SET `error`='" . $this->db->escape($error_msg) . "' WHERE id_order=" . (int) $id_order);
    $this->updateOrderStatus($id_order, $this->config->get('itella_error_id'));
  }

  private function getOCOrder($id_order)
  {
    $this->load->model('sale/order');
    $order = $this->model_sale_order->getOrder((int) $id_order);

    return $order;
  }

  /**
   * Adds order information to itella_order table
   * 
   * @var array $oc_order Opencart order information from getOCOrder()
   * @var bool $return if there is a need to get added information set this to true
   */
  private function saveOrderData($oc_order, $return = false)
  {
    $this->load->language('extension/shipping/itellashipping');
    if (!$oc_order) {
      return array('error' => $this->language->get('itella_bad_order_id'));
    }

    $method = explode('.', $oc_order['shipping_code']);
    if ($method[0] != 'itellashipping') {
      return array('error' => $this->language->get('itella_not_itella'));
    }

    if (false) { // placeholder where to check terminal ID
      return array('error' => $this->language->get('itella_bad_terminal'));
    }

    $id_order = $oc_order['order_id'];

    $is_cod = 0;
    // TODO: maybe need to convert to EUR?
    $cod_amount = $oc_order['total'];
    $cod_enabled = $this->config->get('itellashipping_cod_status');
    if ($cod_enabled) {
      $cod_options = json_decode($this->config->get('itellashipping_cod_options'));
      if (in_array($oc_order['payment_code'], $cod_options)) {
        $is_cod = 1;
      }
    }
    $is_pickup = 0;
    $id_pickup_point = '0';
    if ($method[1] != 'courier') { // extract pickup point id from shipping code if its not courier
      $is_pickup = 1;
      $id_pickup_point = explode('_', $method[1])[1];
    }

    $result = $this->db->query("
      INSERT INTO `" . DB_PREFIX . "itella_order` (id_order, is_cod, cod_amount, is_pickup, id_pickup_point) 
      VALUES ($id_order, $is_cod, $cod_amount, $is_pickup, '$id_pickup_point');
    ");

    if (!$result) {
      return array('error' => $this->language->get('itella_insert_failed'));
    }

    if ($return) {
      return $this->getOrder($oc_order['order_id']);
    }

    return true;
  }

  public function updateOrderData($id_order, $data)
  {
    $values = array();
    foreach ($data as $key => $value) {
      $values[] = "$key = '$value'";
    }
    if ($values && (int) $id_order > 0) {
      $sql = "UPDATE `" . DB_PREFIX . "itella_order` SET " . implode(', ', $values) . " WHERE id_order = " . $id_order;
      $this->db->query($sql);
    }
    return [$id_order, $data, $sql];
  }

  public function updateOCShippingCode($id_order, $code, $label)
  {
    if (!$label) {
      $label = $code;
    }

    $this->db->query("UPDATE `" . DB_PREFIX . "order` SET shipping_method = '" . $label . "', shipping_code = '" . $code . "', date_modified = NOW() WHERE order_id = '" . (int) $id_order . "'");
    $this->db->query("UPDATE `" . DB_PREFIX . "order_total` SET title = '" . $label . "' WHERE order_id = '" . (int) $id_order . "' AND `code` = 'shipping'");
  }

  public function updateOrderStatus($order_id, $order_status_id, $comment = '')
  {
    $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int) $order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int) $order_id . "'");
    $this->db->query("INSERT INTO `" . DB_PREFIX . "order_history` SET `order_id` = '" . (int) $order_id . "', `order_status_id` = '" . (int) $order_status_id . "', `notify` = '0', `comment` = '" . $this->db->escape($comment) . "', `date_added` = NOW()");
  }

  private function getContractNumber($product_code, $receiver_country)
  {
    if ((int) $product_code === Shipment::PRODUCT_COURIER) {
      $contract_gls = $this->config->get('itellashipping_api_contract_' . $product_code . '_gls');
      $baltics = ['LT', 'LV', 'EE', 'FI'];
      // either sender or receiver is from GLS country and GLS contract is set
      if (!empty($contract_gls)
          && (!in_array($this->config->get('itellashipping_sender_country'), $baltics) || !in_array($receiver_country, $baltics))
      ) {
        return $contract_gls;
      }
    }

    // return default contract by product code
    return $this->config->get('itellashipping_api_contract_' . $product_code);
  }

  public function generateLabel($id_order)
  {
    $order_data = $this->getOrder($id_order);
    $oc_order = $this->getOCOrder($id_order);
    if (!$order_data) {
      $order_data = $this->saveOrderData($oc_order, true);
      if (isset($order_data['error']))
        return $order_data;
    }
    // from this point on we should have correct data
    //return $oc_order;
    try {
      // Determine product code
      $product_code = Shipment::PRODUCT_COURIER;
      if ($order_data['is_pickup'] == 1) {
        $product_code = Shipment::PRODUCT_PICKUP;
      }

      $contract_number = $this->getContractNumber($product_code, $oc_order['shipping_iso_code_2']);

      // Create and configure sender
      $sender = new Party(Party::ROLE_SENDER);
      $sender
        ->setContract($contract_number)
        ->setName1($this->config->get('itellashipping_sender_name'))
        ->setStreet1($this->config->get('itellashipping_sender_street'))
        ->setPostCode($this->config->get('itellashipping_sender_postcode'))
        ->setCity($this->config->get('itellashipping_sender_city'))
        ->setCountryCode($this->config->get('itellashipping_sender_country'))
        ->setContactMobile($this->config->get('itellashipping_sender_phone'))
        ->setContactEmail($this->config->get('itellashipping_sender_email'));

      // Create and configure receiver
      $receiver = new Party(Party::ROLE_RECEIVER);
      $receiver
        ->setName1($oc_order['shipping_firstname'] . ' ' . $oc_order['shipping_lastname'])
        ->setStreet1($oc_order['shipping_address_1'])
        ->setStreet2($oc_order['shipping_address_2'])
        ->setPostCode($oc_order['shipping_postcode'])
        ->setCity($oc_order['shipping_city'])
        ->setCountryCode($oc_order['shipping_iso_code_2'])
        ->setContactMobile($oc_order['telephone'])
        ->setContactEmail($oc_order['email']);

      $items = array();
      $weight = (int) $order_data['packs'] > 1 ? (float) $order_data['weight'] / $order_data['packs'] : (float) $order_data['weight'];
      for ($total = 0; $total < (int) $order_data['packs']; $total++) {
        $item = new GoodsItem();
        $item
          ->setGrossWeight($weight) // kg
          //->setVolume(0.1) // m3
        ;
        $items[] = $item;
      }

      // Create manualy assigned additional services (multiparcel and pickup point services auto created by lib)
      $extra = array();
      if (!$order_data['is_pickup'] && $order_data['is_cod']) {
        $extra[] = new AdditionalService(AdditionalService::COD, array(
          'amount' => $order_data['cod_amount'],
          'account' => $this->config->get('itellashipping_iban'),
          'reference' => ItellaHelper::generateCODReference($id_order),
          'codbic' => $this->config->get('itellashipping_bic')
        ));
      }
      if (!$order_data['is_pickup'] && $order_data['is_fragile']) {
        $extra[] = new AdditionalService(AdditionalService::FRAGILE);
      }
      if (!$order_data['is_pickup'] && $order_data['is_oversized']) {
        $extra[] = new AdditionalService(AdditionalService::OVERSIZED);
      }
      if (!$order_data['is_pickup'] && $order_data['is_call_before_delivery']) {
        $extra[] = new AdditionalService(AdditionalService::CALL_BEFORE_DELIVERY);
      }

      // Create shipment object
      $shipment = new Shipment(
        $this->config->get('itellashipping_api_user_' . $product_code),
        $this->config->get('itellashipping_api_pass_' . $product_code)
      );
      $shipment
        ->setProductCode($product_code) // should always be set first
        ->setShipmentNumber($id_order) // shipment number 
        //->setShipmentDateTime(date('c')) // when package will be ready (just use current time)
        ->setSenderParty($sender) // Sender class object
        ->setReceiverParty($receiver) // Receiver class object
        ->addAdditionalServices($extra) // set additional services
        ->addGoodsItems($items);
      
      // add comment if it is set
      if (isset($order_data['comment']) && !empty($order_data['comment'])) {
        $shipment->setComment($order_data['comment']);
      }

      if ($product_code == Shipment::PRODUCT_PICKUP) {
        $shipment->setPickupPoint($order_data['id_pickup_point']);
      }

      // Register shipment
      $tracking_number = $shipment->registerShipment();
      // update itella_order with tracking nunmber
      $this->db->query("UPDATE `" . DB_PREFIX . "itella_order` SET `label_number`='" . $tracking_number . "', `error`='' WHERE id_order=" . (int) $id_order);
      $this->updateOrderStatus($id_order, $this->config->get('itella_status_id'), $tracking_number);

      $this->load->language('extension/shipping/itellashipping');

      return array('success' => $this->language->get('lng_register_success'), 'tracking_number' => $tracking_number);
    } catch (ItellaException $e) {
      $this->saveItellaError($id_order, $e->getMessage());
      return array('error' => $e->getMessage());
    } catch (\Exception $e) {
      $this->saveItellaError($id_order, $e->getMessage());
      return array('error' => $e->getMessage());
    }
  }

  public function getLabel($id_order)
  {
    $this->load->language('extension/shipping/itellashipping');

    $order_data = $this->getOrder($id_order);
    if (!$order_data) {
      return array('error' => $this->language->get('itella_not_itella'));
    }

    if (!$order_data['label_number']) {
      return array('error' => $this->language->get('error_no_label'));
    }

    $product_code = ItellaHelper::getProductIdFromTrackNum($order_data['label_number']);

    try {
      $shipment = new Shipment(
        $this->config->get('itellashipping_api_user_' . $product_code),
        $this->config->get('itellashipping_api_pass_' . $product_code)
      );
      return $shipment->downloadLabels($order_data['label_number']);
    } catch (ItellaException $e) {
      return array('error' => $e->getMessage());
    } catch (\Exception $e) {
      return array('error' => $e->getMessage());
    }
  }

  public function filterOrderIdArr($arr)
  {
    return array_unique(array_map('intval', $arr), SORT_NUMERIC);
  }

  private function loadMultipleOrders($ids)
  {
    $id_orders = $this->filterOrderIdArr($ids);

    $skipped = array();
    $ids = array();
    $data = array();

    if (empty($id_orders)) {
      return array('ids' => $ids, 'data' => $data, 'skipped' => $skipped);
    }

    $sql_result = $this->db->query("SELECT * FROM " . DB_PREFIX . "itella_order WHERE id_order IN (" . implode(',', $id_orders) . ")")->rows;
    foreach ($sql_result as $order_data) {
      if (!$order_data['label_number']) {
        $skipped[] = $order_data['id_order'];
        continue;
      }

      if ($order_data['error']) {
        $skipped[] = $order_data['id_order'];
        continue;
      }

      $ids[] = $order_data['id_order'];
      $data[] = $order_data;
    }

    return array('ids' => $ids, 'data' => $data, 'skipped' => $skipped);
  }

  public function getLabels($id_orders)
  {
    $this->load->language('extension/shipping/itellashipping');

    $orders = $this->loadMultipleOrders($id_orders);

    if (empty($orders['data'])) {
      return array('error' => $this->language->get('error_itella_empty'));
    }

    try {
      // sort tracking numbers by product code
      $track = array();
      foreach ($orders['data'] as $order) {
        $product_code = ItellaHelper::getProductIdFromTrackNum($order['label_number']);
        if (!ItellaHelper::keyExists($product_code, $track)) {
          $track[$product_code] = array();
        }
        $track[$product_code][] = $order['label_number'];
      }

      // download labels
      $temp_name = 'itella_label_' . time();
      $temp_files = array();
      foreach ($track as $key => $tr_numbers) {
        if (!$tr_numbers) {
          continue;
        }
        $shipment = new Shipment(
          $this->config->get('itellashipping_api_user_' . $key),
          $this->config->get('itellashipping_api_pass_' . $key)
        );

        $result = base64_decode($shipment->downloadLabels($tr_numbers));

        if ($result) { // check if its not empty and save temporary for merging
          $pdf_path = DIR_DOWNLOAD . $temp_name . '-' . $key . '.pdf';
          file_put_contents($pdf_path, $result);
          $temp_files[] = $pdf_path;
        }
      }

      // merge downloaded labels
      $merger = new PDFMerge();
      $merger->setFiles($temp_files); // pass array of paths to pdf files
      $merger->merge();

      // remove downloaded labels ()
      foreach ($temp_files as $file) {
        if (is_file($file)) {
          unlink($file);
        }
      }
      /**
       * Second param:
       * I: send the file inline to the browser (default).
       * D: send to the browser and force a file download with the name given by name.
       * F: save to a local server file with the name given by name.
       * S: return the document as a string (name is ignored).
       * FI: equivalent to F + I option
       * FD: equivalent to F + D option
       * E: return the document as base64 mime multi-part email attachment (RFC 2045)
       */
      return base64_encode($merger->Output('itella_labels.pdf', 'S'));
    } catch (ItellaException $e) {
      return array('error' => $e->getMessage());
    } catch (\Exception $e) {
      return array('error' => $e->getMessage());
    }
  }

  public function registerManifest($id_orders)
  {
    $this->load->language('extension/shipping/itellashipping');

    $orders = $this->loadMultipleOrders($id_orders);

    if (empty($orders['ids'])) {
      return array('error' => $this->language->get('error_itella_empty'));
    }

    $this->db->query("INSERT INTO `" . DB_PREFIX . "itella_manifest` SET `date_add` = NOW()");
    $id_manifest = $this->db->getLastId();
    $this->db->query("UPDATE `" . DB_PREFIX . "itella_order` SET id_itella_manifest = " . (int) $id_manifest . " WHERE id_order IN (" . implode(',', $orders['ids']) . ")");
    return array(
      'success' => $this->language->get('lng_manifest_gen_success') . ' ' . count($orders['ids']),
      'skipped' => implode(',', $orders['skipped'])
    );
  }

  public function getManifest($id_manifest)
  {
    $this->load->language('extension/shipping/itellashipping');

    $manifest = $this->db->query("
      SELECT * FROM `" . DB_PREFIX . "itella_manifest` WHERE id_itella_manifest = '" . (int) $id_manifest . "' LIMIT 1;
    ")->row;

    $orders = $this->db->query("
      SELECT * FROM `" . DB_PREFIX . "itella_order` WHERE id_itella_manifest = '" . (int) $id_manifest . "';
    ")->rows;

    if (!$orders || !$manifest) {
      return array('error' => 'Bad manifest ID or no orders associated with this manifest');
    }

    $timestamp = strtotime($manifest['date_add']);
    $pdf = new Manifest($timestamp);
    $pdf
      ->setStrings(array(
        'sender_address'          => $this->language->get('manifest_sender_address'),
        'nr'                      => $this->language->get('manifest_nr'),
        'track_num'               => $this->language->get('manifest_track_num'),
        'date'                    => $this->language->get('manifest_date'),
        'amount'                  => $this->language->get('manifest_amount'),
        'weight'                  => $this->language->get('manifest_weight'),
        'delivery_address'        => $this->language->get('manifest_delivery_address'),
        'courier'                 => $this->language->get('manifest_courier'),
        'sender'                  => $this->language->get('manifest_sender'),
        'name_lastname_signature' => $this->language->get('manifest_signature'),
      ))
      ->setSenderName($this->config->get('itellashipping_sender_name'))
      ->setSenderAddress($this->config->get('itellashipping_sender_street'))
      ->setSenderPostCode($this->config->get('itellashipping_sender_postcode'))
      ->setSenderCity($this->config->get('itellashipping_sender_city'))
      ->setSenderCountry($this->config->get('itellashipping_sender_country'));

    foreach ($orders as $order) {
      $item = [array(
        'track_num' => implode(' ', explode(',', $order['label_number'])),
        'amount' => $order['packs'],
        'weight' => $order['weight'],
        'delivery_address' => $this->generateDeliveryAddress($order)
      )];
      $pdf->addItem($item);
    }

    return $pdf->setToString(true)->setBase64(true)->printManifest('manifest.pdf');
  }

  public function getItems($id_manifest)
  {
    $orders = $this->db->query("
      SELECT * FROM `" . DB_PREFIX . "itella_order` WHERE id_itella_manifest = '" . (int) $id_manifest . "';
    ")->rows;

    if (!$orders) {
      return array('error' => 'No orders associated with this manifest');
    }

    $items = array();
    foreach ($orders as $order) {
      $items[] = array(
        'tracking_number' => implode(' ', explode(',', $order['label_number'])),
        'amount' => $order['packs'],
        'weight' => $order['weight'],
        'delivery_address' => $this->generateDeliveryAddress($order)
      );
    }

    return $items;
  }

  private function generateDeliveryAddress($order)
  {
    $oc_order = $this->getOCOrder($order['id_order']);

    switch ($order['is_pickup']) {
      case '1':
        $loc = $this->getLocationInfo($order['id_pickup_point'], $oc_order['shipping_iso_code_2']);
        $result = $oc_order['shipping_firstname'] . ' ' . $oc_order['shipping_lastname'] . ',<br/>';
        $address = $loc['address'];
        $result .= 'Pickup point:' . '<br/>' . $loc['labelName'] . '<br/>'
          . $address['streetName'] . ' '
          . $address['streetNumber'] . ', '
          . $address['postalCode'] . ' '
          . (empty($address['postalCodeName']) ? $address['municipality'] : $address['postalCodeName']) . ', '
          . $loc['countryCode'];
        return $result;
        break;

      default:
        // By default assume its a courier so address will be delivery address
        return $oc_order['shipping_firstname'] . ' ' . $oc_order['shipping_lastname'] . ', '
          . implode(', ', array($oc_order['shipping_address_1'], $oc_order['shipping_address_2'])) . '<br/>'
          . $oc_order['shipping_postcode'] . ' ' . $oc_order['shipping_city'] . ', ' . $oc_order['shipping_iso_code_2'];
        break;
    }
  }

  public function getLocationInfo($pup_code, $country = false)
  {
    $country = preg_replace("/[^A-Z0-9\.]/", "", strtoupper($country));

    // check if we dont have it in memory
    if (isset($this->_locations[$country])) {
      $locations = $this->_locations[$country];
    }

    // if it wasnt loaded from memory, load from file and store in memory
    if (!isset($locations)) {
      $path = DIR_DOWNLOAD . "itellashipping/locations_" . $country . ".json";
      $locations = array();
      if (is_file($path)) {
        $locations = json_decode(file_get_contents($path), true);
        $this->_locations[$country] = $locations;
      }
    }

    foreach ($locations as $loc) {
      if ($loc['pupCode'] == $pup_code) {
        return $loc;
      }
    }
    return false;
  }
}
