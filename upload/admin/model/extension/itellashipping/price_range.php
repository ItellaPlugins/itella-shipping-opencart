<?php
class ModelExtensionItellashippingPriceRange extends Model {

  public function getCountries($geo_zone_id = false)
	{
		// check if needs countries assigned to specific geo zone or all of them
		if ($geo_zone_id) {
			$result = $this->db->query("
        SELECT * FROM " . DB_PREFIX . "country c 
        LEFT JOIN " . DB_PREFIX . "zone_to_geo_zone z ON z.country_id = c.country_id 
        WHERE z.geo_zone_id = '" . $geo_zone_id . "' 
        GROUP BY c.country_id
      ");
		} else {
			$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "country");
		}

		return $result->rows;
  }
  
  protected function savePrice($data)
	{
		$store_id = 0;
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int) $store_id . "' AND `code` = 'itellashipping' AND `key` = 'itellashipping_price_" . $data['country'] . "'");
		$result = $this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET store_id = '" . (int) $store_id . "', `code` = 'itellashipping', `key` = 'itellashipping_price_" . $data['country'] . "', `value` = '" . json_encode($data) . "'");

		return array('success' => $data);
	}
}