<?php
class ModelExtensionShippingItellaShipping extends Model
{
	function getQuote($address)
	{
		$this->load->language('extension/shipping/itellashipping');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('itellashipping_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

		if (!$this->config->get('itellashipping_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		// check if there are prices set, else disable
		$prices = $this->config->get('itellashipping_price_' . $address['iso_code_2']);
		if (!$prices) {
			$status = false;
		}

		$method_data = array();

		if ($status) {

			//determine cost
			$prices = json_decode($prices, true);

			$quote_data = array();

			$courier_cost = $this->calculateCost($prices['courier_price'], $prices['courier_price_free']);

			if ($courier_cost >= 0) {
				$quote_data['courier'] = array(
					'code'         => 'itellashipping.courier',
					'title'        => $this->language->get('text_courier'),
					'cost'         => $courier_cost,
					'tax_class_id' => $this->config->get('itellashipping_tax_class_id'),
					'text'         => $this->currency->format($this->tax->calculate($courier_cost, $this->config->get('itellashipping_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
				);
			}


			$pickup_cost = $this->calculateCost($prices['pickup_price'], $prices['pickup_price_free']);

			if ($pickup_cost >= 0) {
				// JS code to startup map mounting
				$js = <<<'JS'
<script>
$(document).ready(function(){
	if (typeof initItella == 'function') {
		initItella($('[name=\'shipping_method\'][value^=\'fake_itella.pickup\']'));
	}

	// remove fake quote (used in admin)
	$('option[value^=\'fake_itella.pickup\']').remove();
});
</script>
JS;
				$terminals = json_decode($this->load->controller('extension/module/itellashipping/loadTerminals', array('country_code' => $address['iso_code_2'])), true);

				if (!$terminals) {
					$terminals = [];
				}

				if (count($terminals) > 0) {
					$quote_data['pickup'] = array(
						'code'         => 'fake_itella.pickup',
						'title'        => $this->language->get('text_pickup'),
						'cost'         => $pickup_cost,
						'tax_class_id' => $this->config->get('itellashipping_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($pickup_cost, $this->config->get('itellashipping_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency']) . $js
					);
				}

				foreach ($terminals as $terminal) {
					$key = 'pickup_' . $terminal['pupCode'];
					$quote_data[$key] = array(
						'code'         => 'itellashipping.' . $key,
						'title'        => $this->language->get('text_prefix') . ' ' . $terminal['publicName'] . ', ' . $terminal['address']['address'],
						'cost'         => $pickup_cost,
						'tax_class_id' => $this->config->get('itellashipping_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($pickup_cost, $this->config->get('itellashipping_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
					);
				}
			}

			$method_data = array(
				'code'       => 'itellashipping',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('itellashipping_sort_order'),
				'error'      => false
			);
		} else {
			$method_data = array(
				'code'       => 'false',
				'title'      => 'STATUS FALSE',
				'quote'      => array(),
				'sort_order' => 1,
				'error'      => false
			);
		}

		return $method_data;
	}

	protected function calculateCost($cost, $free_from)
	{
		if (empty($cost)) {
			$cost = 0;
		}

		// custom disabling through negative price setting
		if ($cost < 0) {
			return $cost;
		}

		if (!empty($free_from)) {
			$cart_price = $this->cart->getTotal();
			$cart_price = $this->currency->format($cart_price, $this->session->data['currency'], false, false);
			if ($cart_price >= $free_from) {
				$cost = 0;
			}
		}
		return $cost;
	}

	public function updateItellaOrderCarrier($id_order, $shipping_code)
	{
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "itella_order` WHERE `id_order` = $id_order")->row;
		if (!$query) {
			return; // ignore update if we dont have a record in database (it will be added with other functions)
		}

		$method = explode('.', $shipping_code);
		if ($method[0] == 'itellashipping' && $method[1] == 'courier') { // for courier just update table record
			$query = $this->db->query("UPDATE `" . DB_PREFIX . "itella_order` SET is_pickup = 0 WHERE `id_order` = $id_order");
		} else {
			//$pupCode = explode('_', $method)[1];
			// in case of pickup we can simply remove it from table as it will be created with default values later on
			$query = $this->db->query("DELETE FROM `" . DB_PREFIX . "itella_order` WHERE `id_order` = $id_order");
		}
	}
}
