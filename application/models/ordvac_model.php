<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ordvac_model extends CI_Model {
		
	function getPublishedDate($since) {
		$since = time() - $since;

		$chunks = array(
			array(60 * 60 * 24 * 365 , 'year'),
			array(60 * 60 * 24 * 30 , 'month'),
			array(60 * 60 * 24 * 7, 'week'),
			array(60 * 60 * 24 , 'day'),
			array(60 * 60 , 'hour'),
			array(60 , 'minute'),
			array(1 , 'second')
		);

	    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
	   		$seconds = $chunks[$i][0];
		   	$name = $chunks[$i][1];
	        if (($count = floor($since / $seconds)) != 0) {
	        	break;
	    	}
	    }

		$print = ($count == 1) ? '1 '.$name . ' ago': "$count {$name}s ago";

		return $print;
	}

	public function viewed($view) {
		return $view = ($view > 1) ? $view . ' views' : $view . ' view';
	}

	public function getOrder ($num,$offset) {
		$data = array();
		$qu = "visibility != 0 AND deleted != 'deleted'";
		$this->db->order_by('id','DESC');
		$query = $this->db->where($qu)->get('ordvac',$num,$offset);

		if ($query) {
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$data[] = array(
						'id' => $row['id'],
						'zagqu' => $row['zagqu'],
						'cost' => $row['tsena'],
						'views' => $this->viewed($row['views']),
						'published' => $this->getPublishedDate($row['published'])
					);
				}
				return $data;
			} else return 'Empty!';
		}
	}

	public function getOrderData ($id) {
		$query = $this->db->query("SELECT * FROM ordvac WHERE id = '$id'");

		if ($query) {
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$data = array(
						'id' => $row['id'],
						'zagqu' => $row['zagqu'],
						'text' => html_entity_decode($row['tekst']),
						'login' => $row['login'],
						'full_name' => $row['full_name'],
						'cost' => $row['tsena'],
						/*'viewed' => $this->countViews($row['viewed'], $row['viewip'], $row['views'],$id),*/
						'viewed' => $row['views'],
						'published' => $this->getPublishedDate($row['published'])
					);
				}
				return $data;
			} else return 'Order not exist!';
		}
	}


	public function order ($zagqu, $cost, $valyuta, $domain, $text) {
		$err = array();
		if (strlen($zagqu) > 150 || strlen($zagqu) < 1)
			$err[] = "Название заказа должна состоять из 1 - 150 символов!";

		if (!is_numeric($cost))
			$err[] = 'На поле "цена" должно быть число!';

		if ($valyuta != 'RUB' && $valyuta != 'UZS' && $valyuta != 'USD')
			$err[] = "Неизвестная валюта!";

		if ($domain < 1 || $domain > 4)
			$err[] = 'Неизвестная сфера деятельности!';

		$date = time();
		$login = $_SESSION['username'];
		$email = $_SESSION['email'];
		$id = $_SESSION['id'];
		$full_name = $_SESSION['name'] . ' ' . $_SESSION['surname'];

		if (count($err) == 0) {
			$cost .= ' ' . $valyuta;
			$query = "INSERT INTO ordvac (zagqu, tekst, login, email, full_name, tsena, viewed, views, published, visibility, deleted) VALUES ('$zagqu', '$text', '$login', '$email', '$full_name', '$cost', '', '0', '$date', '1', '')";

			$query = $this->db->query($query);

			if ($query) {
				$last = $this->db->insert_id();

				$query = $this->db->query("SELECT orders FROM users WHERE user_id = '$id'");
				if ($query) { 
					$row = $query->row_array();
					$order = $row['orders'] . $last . ',';

					$this->db->query("UPDATE users SET orders = '$order' WHERE user_id = '$id'");
				}
				return  '<div class = "alert alert-success"> Success! </div>';
			}
			else return '<div class = "alert alert-danger"> Something went wrong! </div>';
		}
		else return $err;
	}
}
?>