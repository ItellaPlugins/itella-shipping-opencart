<?php
class ControllerExtensionShippingItellashipping extends Controller
{
	private $_version = '1.2.15';
	private $error = array();

	public function install()
	{
		$this->load->model('extension/itellashipping/itellashipping');

		$this->model_extension_itellashipping_itellashipping->install();

		// Defaults for courier emails
		$this->saveSettings(array(
			'itellashipping_advanced_email_LT' => 'smartship.routing.lt@itella.com',
			'itellashipping_advanced_email_LV' => 'smartship.routing.lv@itella.com',
			'itellashipping_advanced_email_subject' => 'E-com order booking',
		));
	}

	public function uninstall()
	{
		$this->load->model('extension/itellashipping/itellashipping');

		$this->model_extension_itellashipping_itellashipping->uninstall();
	}

	public function index()
	{
		$this->load->language('extension/shipping/itellashipping');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		$extension_home = 'extension';
		if (version_compare(VERSION, '3.0.0', '>=')) {
			$extension_home = 'marketplace';
		}

		if (isset($this->request->get['fixdb']) && $this->validate()) {
			$this->fixDBTables();
			$this->response->redirect($this->url->link('extension/shipping/itellashipping', $this->getUserToken(), true));
		}

		if (isset($this->request->get['fixxml']) && $this->validate()) {
			$this->updateXMLFile();
			$this->session->data['success'] = $this->language->get('xml_updated');
			$this->response->redirect($this->url->link($extension_home . '/modification', $this->getUserToken(), true));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->prepPostData();

			if (isset($this->request->post['force_locations_update'])) { // need to update
				$this->session->data['success'] = $this->forceUpdate();
			}

			if (isset($this->request->post['api_settings_update'])) {
				// we need unescaped password post
				$this->request->post['itellashipping_api_pass_2711'] = $_POST['itellashipping_api_pass_2711'];
				$this->request->post['itellashipping_api_pass_2317'] = $_POST['itellashipping_api_pass_2317'];
				unset($this->request->post['api_settings_update']);
				$this->saveSettings($this->request->post);
				$this->session->data['success'] = $this->language->get('text_success');
			}

			if (isset($this->request->post['module_settings_update'])) {
				unset($this->request->post['module_settings_update']);
				$this->saveSettings($this->request->post);
				$this->session->data['success'] = $this->language->get('text_success');
			}
			if (isset($this->request->post['sender_settings_update'])) {
				unset($this->request->post['sender_settings_update']);
				$this->saveSettings($this->request->post);
				$this->session->data['success'] = $this->language->get('text_success');
			}

			if (isset($this->request->post['price_settings_update'])) {
				unset($this->request->post['price_settings_update']);
				$this->saveSettings($this->request->post);
				$this->session->data['success'] = $this->language->get('text_success');
			}

			if (isset($this->request->post['cod_settings_update'])) {
				unset($this->request->post['cod_settings_update']);
				$this->saveSettings($this->request->post);
				$this->session->data['success'] = $this->language->get('text_success');
			}

			if (isset($this->request->post['advanced_settings_update'])) {
				unset($this->request->post['advanced_settings_update']);
				$this->saveSettings($this->request->post);
				$this->session->data['success'] = $this->language->get('text_success');
			}

			if (isset($this->request->post['tracking_email_update'])) {
				unset($this->request->post['tracking_email_update']);
				$this->saveSettings($this->request->post);
				$this->session->data['success'] = $this->language->get('text_success');
			}

			$this->response->redirect($this->url->link('extension/shipping/itellashipping', $this->getUserToken(), true));
		}

		$data['itella_version'] = $this->_version;
		$data['heading_title'] = $this->language->get('heading_title');

		// Notification about need to fix db
		$data['db_fix_notify'] = $this->language->get('db_fix_notify');
		$data['button_fix_db'] = $this->language->get('button_fix_db');
		// Notification about xml update
		$data['xml_fix_notify'] = $this->language->get('xml_fix_notify');
		$data['button_fix_xml'] = $this->language->get('button_fix_xml');

		// Api settings
		$data['text_api_settings'] = $this->language->get('text_api_settings');
		$data['text_price_settings'] = $this->language->get('text_price_settings');
		$data['text_cod_settings'] = $this->language->get('text_cod_settings');
		$data['text_cod_options_help'] = $this->language->get('text_cod_options_help');
		$data['text_locations_help'] = $this->language->get('text_locations_help');

		$data['entry_test_mode'] = $this->language->get('entry_test_mode');
		$data['entry_api_user'] = $this->language->get('entry_api_user');
		$data['entry_api_pass'] = $this->language->get('entry_api_pass');
		$data['entry_api_contract'] = $this->language->get('entry_api_contract');
		$data['entry_api_contract_gls'] = $this->language->get('entry_api_contract_gls');
		$data['text_api_contract_gls_help'] = $this->language->get('text_api_contract_gls_help');
		$data['entry_cod_options'] = $this->language->get('entry_cod_options');
		$data['entry_bic'] = $this->language->get('entry_bic');
		$data['entry_iban'] = $this->language->get('entry_iban');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_cost_parcel'] = $this->language->get('entry_cost_parcel');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['text_sender_settings'] = $this->language->get('text_sender_settings');
		$data['entry_sender_name'] = $this->language->get('entry_sender_name');
		$data['entry_sender_street'] = $this->language->get('entry_sender_street');
		$data['entry_sender_postcode'] = $this->language->get('entry_sender_postcode');
		$data['entry_sender_city'] = $this->language->get('entry_sender_city');
		$data['entry_sender_country'] = $this->language->get('entry_sender_country');
		$data['entry_sender_phone'] = $this->language->get('entry_sender_phone');
		$data['entry_sender_email'] = $this->language->get('entry_sender_email');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['text_locations'] = $this->language->get('text_locations');
		$data['text_last_update'] = $this->language->get('text_last_update');
		$data['text_total_locations'] = $this->language->get('text_total_locations');
		$data['text_cron_url'] = $this->language->get('text_cron_url');
		$data['button_update'] = $this->language->get('button_update');

		$data['text_advanced_settings'] = $this->language->get('text_advanced_settings');
		$data['entry_advanced_email_subject'] = $this->language->get('entry_advanced_email_subject');
		$data['entry_advanced_email'] = $this->language->get('entry_advanced_email');

		//Tab texts
		$data['tab_api'] = $this->language->get('tab_api');
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_sender_info'] = $this->language->get('tab_sender_info');
		$data['tab_price'] = $this->language->get('tab_price');
		$data['tab_cod'] = $this->language->get('tab_cod');
		$data['tab_pickuppoints'] = $this->language->get('tab_pickuppoints');
		$data['tab_advanced'] = $this->language->get('tab_advanced');
		$data['text_price_help'] = $this->language->get('text_price_help');
		$data['text_price_help_country'] = $this->language->get('text_price_help_country');

		$data['entry_price_country'] = $this->language->get('entry_price_country');
		$data['entry_price_country_placeholder'] = $this->language->get('entry_price_country_placeholder');
		$data['entry_price_pickup'] = $this->language->get('entry_price_pickup');
		$data['entry_price_courier'] = $this->language->get('entry_price_courier');
		$data['entry_price_free'] = $this->language->get('entry_price_free');
		$data['button_add_price'] = $this->language->get('button_add_price');
		$data['button_save_price'] = $this->language->get('button_save_price');
		$data['text_actions'] = $this->language->get('text_actions');
		$data['entry_api_2711'] = $this->language->get('entry_api_2711');
		$data['entry_api_2317'] = $this->language->get('entry_api_2317');

		// Tracking email tab
		$data['tab_tracking_email'] = $this->language->get('tab_tracking_email');
		$data['text_tracking_email'] = $this->language->get('text_tracking_email');
		$data['entry_tracking_email_subject'] = $this->language->get('entry_tracking_email_subject');
		$data['entry_tracking_email_template'] = $this->language->get('entry_tracking_email_template');
		$data['text_tracking_email_template_help'] = $this->language->get('text_tracking_email_template_help');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $this->getUserToken(), true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link($extension_home . '/extension', $this->getUserToken() . '&type=shipping', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_nologo'),
			'href' => $this->url->link('extension/shipping/itellashipping', $this->getUserToken(), true)
		);

		$data['action'] = $this->url->link('extension/shipping/itellashipping', $this->getUserToken(), true);

		$data['cancel'] = $this->url->link($extension_home . '/extension', $this->getUserToken() . '&type=shipping', true);

		$data['cod_options'] = $this->loadPaymentOptions();

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();
		$data['languages'] = $languages;

		$data['itellashipping_title_data'] = [];
		$default_title_pickup = $this->language->get('itellashipping_pickup_point_title_default');
		$default_title_courier = $this->language->get('itellashipping_courier_title_default');
		foreach ($languages as $language) {
			$key_pickup = 'itellashipping_pickup_point_title_' . $language['language_id'];
			$localized_title_pickup = $this->config->get($key_pickup);

			$key_courier = 'itellashipping_courier_title_' . $language['language_id'];
			$localized_title_courier = $this->config->get($key_courier);

			$data['itellashipping_title_data'][$language['language_id']] = [
				$key_pickup => $localized_title_pickup ? $localized_title_pickup : $default_title_pickup,
				$key_courier => $localized_title_courier ? $localized_title_courier : $default_title_courier
			];
		}

		$data['itellashipping_title_lang'] = $this->language->get('itellashipping_title_lang');
		$data['itellashipping_pickup_point_title'] = $this->language->get('itellashipping_pickup_point_title');
		$data['itellashipping_courier_title'] = $this->language->get('itellashipping_courier_title');

		$data['ajax_url'] = HTTPS_CATALOG . 'index.php?route=extension/module/itellashipping/ajax&' . $this->getUserToken();
		$data['ajax_url'] = 'index.php?route=extension/shipping/itellashipping/ajax&' . $this->getUserToken();

		foreach (array(
			'itellashipping_tax_class_id', 'itellashipping_geo_zone_id',
			'itellashipping_api_user_2711', 'itellashipping_api_pass_2711', 'itellashipping_api_contract_2711',
			'itellashipping_api_user_2317', 'itellashipping_api_pass_2317', 'itellashipping_api_contract_2317',
			'itellashipping_api_contract_2317_gls',
			'itellashipping_cod_status', 'itellashipping_bic', 'itellashipping_iban',
			'itellashipping_sender_name', 'itellashipping_sender_street', 'itellashipping_sender_postcode',
			'itellashipping_sender_city', 'itellashipping_sender_country', 'itellashipping_sender_phone',
			'itellashipping_sender_email', 'itellashipping_advanced_email_subject',
			'itellashipping_tracking_email_status', 'itellashipping_tracking_email_subject'
		) as $key) {
			if (isset($this->request->post[$key])) {
				$data[$key] = $this->request->post[$key];
			} else {
				$data[$key] = $this->config->get($key);
			}
		}

		// special cases (that need json_decode)
		if (isset($this->request->post['itellashipping_cod_options'])) {
			$data['itellashipping_cod_options'] = json_decode($this->request->post['itellashipping_cod_options']);
		} else {
			$data['itellashipping_cod_options'] = json_decode($this->config->get('itellashipping_cod_options'));
		}

		if (isset($this->request->post['itellashipping_tracking_email_template'])) {
			$data['itellashipping_tracking_email_template'] = json_decode($this->request->post['itellashipping_tracking_email_template']);
		} else {
			$data['itellashipping_tracking_email_template'] = json_decode($this->config->get('itellashipping_tracking_email_template'));
			if (empty($data['itellashipping_tracking_email_template'])) {
				$data['itellashipping_tracking_email_template'] = file_get_contents(DIR_TEMPLATE . 'extension/itellashipping/tracking_mail.twig');
			}
		}

		// opencart 3 expects status and sort_order begin with shipping_ 
		$setting_prefix = '';
		if (version_compare(VERSION, '3.0.0', '>=')) {
			$setting_prefix = 'shipping_';
		}

		if (isset($this->request->post[$setting_prefix . 'itellashipping_status'])) {
			$data['itellashipping_status'] = $this->request->post[$setting_prefix . 'itellashipping_status'];
		} else {
			$data['itellashipping_status'] = $this->config->get($setting_prefix . 'itellashipping_status');
		}

		if (isset($this->request->post[$setting_prefix . 'itellashipping_sort_order'])) {
			$data['itellashipping_sort_order'] = $this->request->post[$setting_prefix . 'itellashipping_sort_order'];
		} else {
			$data['itellashipping_sort_order'] = $this->config->get($setting_prefix . 'itellashipping_sort_order');
		}

		if (!$data['itellashipping_cod_options']) {
			$data['itellashipping_cod_options'] = array();
		}

		$data['itellashipping_prices'] = array_map(
			function ($price) {
				return json_decode($price['value'], true);
			},
			$this->getPrices()
		);

		$data['locations_info'] = $this->getLocationsInfo();
		$data['last_update'] = $this->config->get('itellashipping_last_update');
		$data['last_update'] = $data['last_update'] == null ? 'Never updated' : date('Y-m-d H:i:s', $data['last_update']);
		$data['cron_url'] = $this->getCronUrl();

		// courier email data
		$data['advanced_emails'] = array();
		foreach (array('LT', 'LV', 'EE', 'FI') as $code) {
			if (isset($this->request->post['itellashipping_advanced_email_' . $code])) {
				$email = $this->request->post['itellashipping_advanced_email_' . $code];
			} else {
				$email = $this->config->get('itellashipping_advanced_email_' . $code);
			}
			$data['advanced_emails'][] = array(
				'code' => $code,
				'email' => $email
			);
		}

		$data['db_check'] = $this->checkDBTables();
		$data['db_fix_url'] = $this->url->link('extension/shipping/itellashipping', $this->getUserToken() . '&fixdb', true);

		$data['xml_check'] = $this->checkModificationVersion();
		$data['xml_fix_url'] = $this->url->link('extension/shipping/itellashipping', $this->getUserToken() . '&fixxml', true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/itellashipping', $data));
	}

	protected function getUserToken()
	{
		if (version_compare(VERSION, '3.0.0', '>=')) {
			return 'user_token=' . $this->session->data['user_token'];
		}
		return 'token=' . $this->session->data['token'];
	}

	protected function checkModificationVersion()
	{
		$source_xml = DIR_SYSTEM . 'library/itella_lib/itella_base.ocmod.xml';
		if (version_compare(VERSION, '3.0.0', '>=')) {
			$source_xml = DIR_SYSTEM . 'library/itella_lib/itella_base_oc3.ocmod.xml';
		}

		$xml = DIR_SYSTEM . 'itella_base.ocmod.xml';

		return version_compare($this->getModXMLVersion($source_xml), $this->getModXMLVersion($xml), '>');
	}

	protected function getModXMLVersion($file)
	{
		if (!is_file($file)) {
			return null;
		}
		$xml = file_get_contents($file);

		$dom = new DOMDocument('1.0', 'UTF-8');
		$dom->loadXml($xml);

		$version = $dom->getElementsByTagName('version')->item(0)->nodeValue;

		return $version;
	}

	protected function updateXMLFile()
	{
		$this->load->model('extension/itellashipping/itellashipping');
		$this->model_extension_itellashipping_itellashipping->copyModificationXML();
	}

	protected function checkDBTables()
	{
		$result = array();
		$itella_table = $this->db->query("DESCRIBE `" . DB_PREFIX . "itella_order`")->rows;
		$comment_field_found = false;
		foreach ($itella_table as $col) {
			switch (strtolower($col['Field'])) {
				case 'id_pickup_point':
					// needs to be varchar, 1.0.0 module had bug where its set as INT
					if (strpos(strtolower($col['Type']), 'varchar') === false) {
						$result['itella_order'] = array(
							'field' => $col['Field'],
							'fix' => "
								ALTER TABLE `" . DB_PREFIX . "itella_order` 
								MODIFY `id_pickup_point` VARCHAR(30) COLLATE utf8_unicode_ci DEFAULT NULL;
							"
						);
					}
					break;

				case 'comment':
					$comment_field_found = true;
					break;
			}
		}

		// added in 1.2.9 version
		if (!$comment_field_found) {
			$result['itella_order'] = array(
				'field' => 'comment',
				'fix' => "
					ALTER TABLE `" . DB_PREFIX . "itella_order` 
					ADD `comment` text COLLATE utf8_unicode_ci DEFAULT NULL;
				"
			);
		}

		if (version_compare(VERSION, '3.0.0', '>=')) {
			$session_table = $this->db->query("DESCRIBE `" . DB_PREFIX . "session`")->rows;
			foreach ($session_table as $col) {
				if (strtolower($col['Field']) != 'data') {
					continue;
				}
				if (strtolower($col['Type']) == 'text') {
					// needs to be MEDIUMTEXT or LONGTEXT
					$result['session'] = array(
						'field' => $col['Field'],
						'fix' => "
								ALTER TABLE `" . DB_PREFIX . "session` 
								MODIFY `data` MEDIUMTEXT;
							"
					);
				}
				break;
			}
		}

		return $result;
	}

	protected function fixDBTables()
	{
		$db_check = $this->checkDBTables();
		if (!$db_check) {
			return; // nothing to fix
		}

		foreach ($db_check as $table => $data) {
			$this->db->query($data['fix']);
			//$this->db->query("ALTER TABLE `" . DB_PREFIX . $table . "` MODIFY `" . $data['field'] . "` " . $data['fix'] . ";");
		}
	}

	protected function validate()
	{
		if (!$this->user->hasPermission('modify', 'extension/shipping/itellashipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
			return false; // skip the rest
		}

		if (isset($this->request->post['itellashipping_cost']) && empty($this->request->post['itellashipping_cost'])) {
			$this->error['warning'] = $this->language->get('required');
		}

		return !$this->error;
	}

	protected function getPrices()
	{
		$result = $this->db->query("SELECT value FROM " . DB_PREFIX . "setting WHERE `code` = 'itellashipping' AND `key` LIKE 'itellashipping_price_%'");
		return $result->rows;
	}

	protected function getLocationsInfo()
	{
		$locations = array('LT' => 0, 'LV' => 0, 'EE' => 0, 'FI' => 0);

		$dir = DIR_DOWNLOAD . "itellashipping/";

		foreach (array_keys($locations) as $key) {
			$path = $dir . 'locations_' . $key . '.json';
			if (file_exists($path)) {
				$points = file_get_contents($path);
				if ($points) {
					$locations[$key] = count(json_decode($points, true));
				}
			}
		}
		return $locations;
	}

	protected function forceUpdate()
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->getCronUrl());
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, 60);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$data = curl_exec($curl);
		curl_close($curl);

		return $data;
	}

	protected function getCronUrl()
	{
		$secret = $this->config->get('itellashipping_cron_secret');
		if (!$secret) { // first time create a secret
			$this->saveSettings(array('itellashipping_cron_secret' => uniqid()));
			$secret = $this->config->get('itellashipping_cron_secret');
		}

		return HTTPS_CATALOG . 'index.php?route=extension/module/itellashipping/ajax&action=updateLocations&secret=' . $secret;
	}

	protected function saveSettings($data)
	{
		$this->load->model('setting/setting');

		foreach ($data as $key => $value) {
			$query = $this->db->query("SELECT setting_id FROM `" . DB_PREFIX . "setting` WHERE `code` = 'itellashipping' AND `key` = '" . $this->db->escape($key) . "'");
			if ($query->num_rows) {
				$id = $query->row['setting_id'];
				$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape($value) . "', serialized = '0' WHERE `setting_id` = '$id'");
			} else {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET store_id = '0', `code` = 'itellashipping', `key` = '$key', `value` = '" . $this->db->escape($value) . "'");
			}
		}
	}

	protected function loadPaymentOptions()
	{
		$result = array();

		if (version_compare(VERSION, '3.0.0', '>=')) {
			$this->load->model('setting/extension');
			$payments = $this->model_setting_extension->getInstalled('payment');
		} else {
			$this->load->model('extension/extension');
			$payments = $this->model_extension_extension->getInstalled('payment');
		}

		foreach ($payments as $payment) {
			$this->load->language('extension/payment/' . $payment);
			$result[$payment] = $this->language->get('heading_title');
		}

		return $result;
	}

	/**
	 * Converts certain settings that comes as array into string
	 */
	protected function prepPostData()
	{
		// when no checkboxes is selected post doesnt send it, make sure settings is updated correctly
		if (isset($this->request->post['cod_settings_update']) && !isset($this->request->post['itellashipping_cod_options'])) {
			$this->request->post['itellashipping_cod_options'] = array();
		}

		if (isset($this->request->post['itellashipping_cod_options'])) {
			$this->request->post['itellashipping_cod_options'] = json_encode($this->request->post['itellashipping_cod_options']);
		}

		if (isset($this->request->post['itellashipping_tracking_email_template'])) {
			$this->request->post['itellashipping_tracking_email_template'] = json_encode($this->request->post['itellashipping_tracking_email_template']);
		}

		// Opencart 3 expects status to be shipping_itellashipping_status
		if (version_compare(VERSION, '3.0.0', '>=') && isset($this->request->post['itellashipping_status'])) {
			$this->request->post['shipping_itellashipping_status'] = $this->request->post['itellashipping_status'];
			unset($this->request->post['itellashipping_status']);
		}

		// Opencart 3 expects sort_order to be shipping_itellashipping_sort_order
		if (version_compare(VERSION, '3.0.0', '>=') && isset($this->request->post['itellashipping_sort_order'])) {
			$this->request->post['shipping_itellashipping_sort_order'] = $this->request->post['itellashipping_sort_order'];
			unset($this->request->post['itellashipping_sort_order']);
		}
	}

	protected function hasAccess()
	{
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function ajax()
	{
		$this->load->language('extension/shipping/itellashipping');
		if (!$this->validate()) {
			echo json_encode($this->error);
			exit();
		}
		$restricted = json_encode(['warning' => 'Restricted']);
		switch ($_GET['action']) {
			case 'save':
				if (!$this->hasAccess()) {
					echo json_encode($this->error);
					exit();
				}
				echo json_encode($this->ajaxUpdateOrderData());
				exit();
				break;
			case 'printLabel':
				echo json_encode($this->ajaxPrintLabel());
				exit();
				break;
			case 'resendEmail':
				echo json_encode($this->ajaxResendEmail());
				exit();
				break;
			case 'generateLabel':
				echo json_encode($this->ajaxGenerateLabel());
				exit();
				break;
			case 'getCountries':
				$this->getCountries();
				break;
			case 'savePrice':
				$this->savePrice();
				break;
			case 'deletePrice':
				$this->deletePrice();
				break;

			default:
				die($restricted);
				break;
		}
	}

	protected function ajaxGenerateLabel()
	{
		if (isset($this->request->post['id_order'])) {
			$id_order = (int) $this->request->post['id_order'];
		} else {
			return array('error' => $this->language->get('error_no_order_id'));
		}

		$this->load->model('extension/itellashipping/itellashipping');
		return $this->model_extension_itellashipping_itellashipping->generateLabel($id_order);
	}

	protected function ajaxResendEmail()
	{
		if (isset($this->request->get['id_order'])) {
			$id_order = (int) $this->request->get['id_order'];
		} else {
			return array('error' => $this->language->get('error_no_order_id'));
		}

		$this->load->model('extension/itellashipping/itellashipping');
		$order = $this->model_extension_itellashipping_itellashipping;
		return $order->sendTrackingUrl($id_order);
	}

	protected function ajaxPrintLabel()
	{
		if (isset($this->request->get['id_order'])) {
			$id_order = (int) $this->request->get['id_order'];
		} else {
			return array('error' => $this->language->get('error_no_order_id'));
		}

		$this->load->model('extension/itellashipping/itellashipping');
		$pdf = $this->model_extension_itellashipping_itellashipping->getLabel($id_order);

		if (isset($pdf['error'])) {
			return $pdf;
		}

		$pdf = base64_decode($pdf);
		if ($pdf) { // check if its not empty
			$filename = 'itella_' . time();
			$path = DIR_DOWNLOAD  . $filename . '.pdf';
			file_put_contents($path, $pdf);
			// make sure there is nothing before headers
			if (ob_get_level()) ob_end_clean();
			header("Content-Type: application/pdf");
			header("Content-Transfer-Encoding: binary");
			header('Content-Disposition: inline; filename="labels.pdf"');
			// disable caching on client and proxies, if the download content vary
			header("Expires: 0");
			header("Cache-Control: no-cache, must-revalidate");
			header("Pragma: no-cache");
			readfile($path);
		} else {
			return array('error' => $this->language->get('error_empty_label'));
		}
	}

	protected function ajaxUpdateOrderData()
	{
		$id_order = false;
		if (isset($this->request->post['id_order'])) {
			$id_order = (int) $this->request->post['id_order'];
		} else {
			return array('error' => 'No order ID');
		}

		$this->load->model('extension/itellashipping/itellashipping');
		$order = $this->model_extension_itellashipping_itellashipping;

		$data = array();

		if (isset($this->request->post['itella_extra'])) {
			$itella_extra = $this->request->post['itella_extra'];
		} else {
			$itella_extra = array();
		}

		if (isset($this->request->post['is_pickup'])) {
			$old_data = $order->getOrder($id_order); // should always work as this function is used from inside order

			$is_pickup = (int) $this->request->post['is_pickup'];

			if ($is_pickup == 0 && $old_data['is_pickup'] != $is_pickup) {
				$order->updateOCShippingCode(
					$id_order,
					'itellashipping.courier',
					$this->language->get('itella_lng_prefix') . ' ' . $this->language->get('itella_lng_courier')
				);
			}

			$pickup_label = '';
			if (isset($this->request->post['pickup_label'])) {
				$pickup_label = filter_var($this->request->post['pickup_label'], FILTER_SANITIZE_STRING);
			}

			if ($is_pickup == 1 && isset($this->request->post['id_pickup_point'])) {
				$method = explode('.', $this->request->post['id_pickup_point']);
				if ($method[0] != 'itellashipping') {
					return array('error' => $this->language->get('itella_not_itella'));
				}
				if ($method[1] != 'courier') { // extract pickup point id from shipping code if its not courier
					$data['id_pickup_point'] = explode('_', $method[1])[1];
					if ($is_pickup == 1 && $data['id_pickup_point'] != $old_data['id_pickup_point']) {
						$order->updateOCShippingCode($id_order, 'itellashipping.pickup_' . $data['id_pickup_point'], $pickup_label);
					}
				} else {
					return array('error' => 'Marked as pickup, got courier instead');
				}
			}
		} else {
			$is_pickup = 0;
		}
		$data['is_pickup'] = $is_pickup;

		if ($is_pickup == 0 && isset($this->request->post['packs'])) {
			$data['packs'] = (int) $this->request->post['packs'];
		} else {
			$data['packs'] = 1;
		}

		if (isset($this->request->post['weight'])) {
			$data['weight'] = (float) $this->request->post['weight'];
		} else {
			$data['weight'] = 0;
		}

		if (isset($this->request->post['is_cod']) && isset($this->request->post['cod_amount'])) {
			$data['is_cod'] = (int) $this->request->post['is_cod'];
			$data['cod_amount'] = $this->request->post['cod_amount'];
		} else {
			$data['is_cod'] = 0;
		}

		if (isset($this->request->post['comment'])) {
			$data['comment'] = $this->db->escape($this->request->post['comment']);
		} else {
			$data['comment'] = '';
		}

		// reset extra services
		foreach (array('is_oversized', 'is_call_before_delivery', 'is_fragile') as $key) {
			$data[$key] = 0;
		}

		if (is_array($itella_extra)) {
			foreach ($itella_extra as $extra) {
				if ($is_pickup == 0 && in_array($extra, array('is_oversized', 'is_call_before_delivery', 'is_fragile'))) {
					$data[$extra] = 1;
				}
			}
		}

		// reset error, tracking number and manifest id upon new data saving
		$data['error'] = NULL;
		$data['label_number'] = NULL;
		$data['id_itella_manifest'] = NULL;

		try {
			$result = $order->updateOrderData($id_order, $data);
		} catch (\Throwable $th) {
			return array('error' => $th->getMessage());
		} catch (\Exception $th) {
			return array('error' => $th->getMessage());
		}

		return array('success' => 'Itella information for order updated', 'data' => $result);
	}

	protected function getCountries()
	{
		$this->load->model('extension/itellashipping/price_range');
		// check if needs countries assigned to specific geo zone or all of them
		if (isset($this->request->post['geo_zone_id'])) {
			$geo_zone_id = (int) $this->request->post['geo_zone_id'];
		} else {
			$geo_zone_id = 0;
		}

		echo json_encode($this->model_extension_itellashipping_price_range->getCountries($geo_zone_id));
		exit();
	}

	protected function savePrice()
	{
		if (!isset($this->request->post['country'])) {
			echo json_encode(array('error' => 'Bad request'));
			exit();
		}

		$country_code = $this->request->post['country'];

		$data = $this->request->post;

		// echo json_encode(array('success' => $data));
		// exit();

		$store_id = 0;
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int) $store_id . "' AND `code` = 'itellashipping' AND `key` = 'itellashipping_price_" . $country_code . "'");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET store_id = '" . (int) $store_id . "', `code` = 'itellashipping', `key` = 'itellashipping_price_" . $country_code . "', `value` = '" . json_encode($data) . "'");

		echo json_encode(array('success' => $data));
		exit();
	}

	protected function deletePrice()
	{
		if (!isset($this->request->post['country'])) {
			echo json_encode(array('error' => 'Bad request'));
			exit();
		}

		$country_code = $this->request->post['country'];


		$data = $this->request->post;

		$store_id = 0;
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int) $store_id . "' AND `code` = 'itellashipping' AND `key` = 'itellashipping_price_" . $country_code . "'");

		echo json_encode(array('success' => $data));
		exit();
	}
}
