<?php
class ModelExtensionItellashippingManifest extends Model
{

  public function getOrders($page = 1, $filter = array())
  {
    $limit = $this->config->get('config_limit_admin');
    $offset = ($page - 1) * $limit;
    $sql_partial = $this->buildQuery($filter);

    $sql = "SELECT o.order_id, CONCAT(o.firstname, ' ', o.lastname) AS customer, 
      (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int) $this->config->get('config_language_id') . "') AS order_status,
      o.date_added, o.date_modified, io.label_number, io.error as itella_error
      FROM `" . DB_PREFIX . "order` o
      LEFT JOIN `" . DB_PREFIX . "itella_order` io ON o.order_id = io.id_order
      WHERE o.shipping_code LIKE 'itellashipping%' AND (io.id_itella_manifest IS NULL OR io.id_itella_manifest = 0)
    ";

    if (!empty($filter['filter_order_status'])) {
      $sql .= " AND o.order_status_id = '" . $filter['filter_order_status'] . "'";
    } else {
      $sql .= " AND o.order_status_id > '0'";
    }

    if (!empty($filter['filter_order_id'])) {
      $sql .= " AND o.order_id = '" . (int) $filter['filter_order_id'] . "'";
    }

    if (!empty($filter['filter_customer'])) {
      $sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($filter['filter_customer']) . "%'";
    }

    if (!empty($filter['filter_date_added'])) {
      $sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($filter['filter_date_added']) . "')";
    }

    if (!empty($filter['filter_date_modified'])) {
      $sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($filter['filter_date_modified']) . "')";
    }

    if (!empty($filter['filter_tracking'])) {
      $sql .= " AND io.label_number LIKE '%" .  $this->db->escape($filter['filter_tracking']) . "%'";
    }

    $sql .= " ORDER BY o.date_modified DESC, o.order_id DESC";
    $sql .= " LIMIT " . $limit . " OFFSET " . $offset;

    $result = $this->db->query($sql);
    // $result = $this->db->query(
    //   "
    //   SELECT o.order_id, CONCAT(o.firstname, ' ', o.lastname) AS customer, 
    //     (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int) $this->config->get('config_language_id') . "') AS order_status,
    //     o.date_added, o.date_modified, io.label_number, io.error as itella_error
    //   $sql_partial
    //   ORDER BY o.date_modified DESC, o.order_id DESC
    //   LIMIT " . $limit . " OFFSET " . $offset
    // );

    return $result->rows;
  }

  public function getOrdersCount($filter = array())
  {
    $sql = "SELECT COUNT(o.order_id) as total
      FROM `" . DB_PREFIX . "order` o
      LEFT JOIN `" . DB_PREFIX . "itella_order` io ON o.order_id = io.id_order
      WHERE o.shipping_code LIKE 'itellashipping%' AND (io.id_itella_manifest IS NULL OR io.id_itella_manifest = 0)
    ";

    if (!empty($filter['filter_order_status'])) {
      $sql .= " AND o.order_status_id = '" . $filter['filter_order_status'] . "'";
    } else {
      $sql .= " AND o.order_status_id > '0'";
    }

    if (!empty($filter['filter_order_id'])) {
      $sql .= " AND o.order_id = '" . (int) $filter['filter_order_id'] . "'";
    }

    if (!empty($filter['filter_customer'])) {
      $sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($filter['filter_customer']) . "%'";
    }

    if (!empty($filter['filter_date_added'])) {
      $sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($filter['filter_date_added']) . "')";
    }

    if (!empty($filter['filter_date_modified'])) {
      $sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($filter['filter_date_modified']) . "')";
    }

    if (!empty($filter['filter_tracking'])) {
      $sql .= " AND io.label_number LIKE '%" .  $this->db->escape($filter['filter_tracking']) . "%'";
    }
    //$sql_partial = $this->buildQuery($filter);
    // $result = $this->db->query(
    //   "
    //   SELECT COUNT(o.order_id) as total
    //   $sql_partial
    //   "
    // )->row;
    $result = $this->db->query($sql)->row;
    if ($result) {
      return $result['total'];
    }
    return 0;
  }

  private function buildQuery($filter = array())
  {
    $sql = "
      FROM `" . DB_PREFIX . "order` o
      LEFT JOIN `" . DB_PREFIX . "itella_order` io ON o.order_id = io.id_order
      WHERE o.shipping_code LIKE 'itellashipping%' AND o.order_status_id <> 0 AND (io.id_itella_manifest IS NULL OR io.id_itella_manifest = 0)
    ";

    return $sql;
  }

  public function getManifests($page = 1)
  {
    $limit = $this->config->get('config_limit_admin');
    $offset = ($page - 1) * $limit;
    $result = $this->db->query(
      "
      SELECT im.id_itella_manifest, im.date_add as date_added,
      (SELECT COUNT(*) FROM `" . DB_PREFIX . "itella_order` io WHERE io.id_itella_manifest = im.id_itella_manifest) as order_total
      FROM `" . DB_PREFIX . "itella_manifest` im
      ORDER BY im.date_add DESC, im.id_itella_manifest DESC
      LIMIT " . $limit . " OFFSET " . $offset
    );

    return $result->rows;
  }

  public function getManifestsCount()
  {
    $result = $this->db->query("SELECT COUNT(id_itella_manifest) as total FROM " . DB_PREFIX . "itella_manifest")->row;
    if ($result) {
      return $result['total'];
    }
    return 0;
  }

  public function getManifestOrders($id_manifest)
  {
    $result = $this->db->query(
      "
      SELECT o.order_id, CONCAT(firstname, ' ', lastname) as customer, 
      (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int) $this->config->get('config_language_id') . "') AS order_status 
      FROM `" . DB_PREFIX . "order` o
      WHERE o.order_id IN (SELECT io.id_order FROM `" . DB_PREFIX . "itella_order` io WHERE io.id_itella_manifest <> 0 AND io.id_itella_manifest = " . $id_manifest . ")
      ORDER BY o.order_id ASC
      "
    );

    return $result->rows;
  }
}
