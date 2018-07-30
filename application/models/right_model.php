<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Right_model extends CI_Model {

	public function get_right_side () {

		$query = $this->db->query("SELECT value FROM metki WHERE id = 1");

		if ($query) {
			$row = $query->row_array();
			$metki = json_decode($row['value'],TRUE);
			return $metki;
		} else {
			return false;
		}
	}
}
?>