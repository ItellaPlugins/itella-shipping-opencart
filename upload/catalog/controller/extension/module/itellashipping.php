<?php
/*
 * Class for automatic updates
 * public access
 *
 */
class ControllerExtensionModuleItellaShipping extends Controller
{
  private $error;

  public function index()
  {
    //$this->fetchUpdates();
    return 'succes';
  }

  public function ajax()
  {
    switch ($_GET['action']) {
      case 'getTerminals':
        $this->ajaxGetTerminals();
        break;
      case 'getQuote':
        $this->getTerminalsAsQuote();
        break;
      case 'save':
        $this->ajaxSave();
        break;
      case 'updateLocations':
        $secret = $this->config->get('itellashipping_cron_secret');
        if (isset($this->request->get['secret']) && $secret && $secret == $this->request->get['secret']) {
          $this->updateLocations();
        } else {
          echo json_encode(['warning' => 'Restricted']);
          exit();
        }
        break;

      default:
        echo json_encode(['warning' => 'Restricted']);
        break;
    }
    exit();
  }

  protected function updateLocations()
  {
    require_once(DIR_SYSTEM . 'library/itella_lib/itella-api/vendor/autoload.php');
    $loc = new \Mijora\Itella\Locations\PickupPoints('https://delivery.plugins.itella.com/api/locations');
    $dir = DIR_DOWNLOAD . "itellashipping/";
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }
    foreach (array('LT', 'LV', 'EE', 'FI') as $country) {
      $itellaLoc = $loc->getLocationsByCountry($country);
      if ($itellaLoc) {
        $loc->saveLocationsToJSONFile($dir . 'locations_' . $country . '.json', json_encode($itellaLoc));
        echo $country . ' done with: ' . count($itellaLoc) . '<br>';
      } else {
        echo '<br>Got error for ' . $country . ' leaving old locations file<br>';
      }
    }
    // update timestamp
    $this->updateTimestamp();
    echo 'Locations updated';
    exit();
  }

  protected function ajaxSave()
  {
    // just in case limit length to 30 max
    if (isset($_POST['itella_pickup_point']) && strlen($_POST['itella_pickup_point']) <= 30) {
      $this->session->data['itella_selected_point'] = htmlspecialchars($_POST['itella_pickup_point']);
      echo 'OK';
    } else {
      echo 'BAD REQUEST';
    }
    exit();
  }

  protected function getTerminalsAsQuote()
  {
    $this->load->model('extension/shipping/itellashipping');

    $quote = $this->model_extension_shipping_itellashipping->getQuote([
      'country_id' => '123',
      'iso_code_2' => 'LT',
      'zone_id' => '0'
    ]);

    echo json_encode($quote);
    exit();
  }

  protected function ajaxGetTerminals()
  {
    //echo json_encode('Ajax called');
    $country_code = 'LT';
    $current_method = false;
    $country_info = false;

    // admin order_info
    if (isset($_POST['country_id'])) {
      $this->load->model('localisation/country');
      $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);
    }

    if (isset($_POST['order_info']) && $country_info) {
      echo json_encode(array(
        'terminals' => $this->loadTerminals(array('country_code' => $country_info['iso_code_2'])),
      ));
      exit();
    }

    // front checkout case
    if (isset($this->session->data)) {
      if (isset($this->session->data['shipping_address'])) {
        $country_code = $this->session->data['shipping_address']['iso_code_2'];
      } 
      if (isset($this->session->data['itella_selected_point'])) {
        $current_method = $this->session->data['itella_selected_point'];
      }
    }

    echo json_encode(array(
      //'data' => $this->session->data,
      'country_info' => $country_info,
      'request' => $this->request->post,
      'terminals' => $this->loadAndFilterTerminals(array('country_code' => $country_code)),
      'country_code' => $country_code,
      'current_method' => $current_method
    ));
    exit();
  }

  public function loadTerminals($params)
  {
    $path = DIR_DOWNLOAD . "itellashipping/locations_" . strtoupper($params['country_code']) . ".json";
    if (!file_exists($path)) {
      return false;
    }
    $locations = file_get_contents($path);
    return $locations;
  }

  public function loadAndFilterTerminals($params)
  {
    $locations_json = $this->loadTerminals($params);
    if (!$locations_json) {
      return false;
    }

    $locations = json_decode($locations_json);
    if (!is_array($locations)) {
      return false;
    }

    $exclude_outdoors = $this->config->get('itellashipping_locations_exclude_outdoors');

    $remove_locations = array();
    foreach ($locations as $key => $location) {
      if (!property_exists($location, 'capabilities')) {
        continue;
      }
      foreach ($location->capabilities as $capability) {
        if ($exclude_outdoors && $capability->name == 'outdoors' && $capability->value == 'OUTDOORS') {
          $remove_locations[] = $key;
          break;
        }
      }
    }
    foreach ($remove_locations as $key) {
      unset($locations[$key]);
    }

    return json_encode($locations);
  }

  /**
   * Updates itellashipping_last_update setting with new timestamp.
   * Workaround for not being able to use editSetting outside admin.
   */
  protected function updateTimestamp()
  {
    $store_id = 0;
    $this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int) $store_id . "' AND `code` = 'itellashipping' AND `key` = 'itellashipping_last_update'");
    $this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET store_id = '" . (int) $store_id . "', `code` = 'itellashipping', `key` = 'itellashipping_last_update', `value` = '" . time() . "'");
  }



  private function addHttps($url)
  {
    if (empty($_SERVER['HTTPS'])) {
      return $url;
    } elseif ($_SERVER['HTTPS'] == "on") {
      return str_replace('http://', 'https://', $url);
    } else {
      return $url;
    }
  }
}
