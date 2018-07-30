<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function getUser($id) {
		$data = array();
		$query = $this->db->query("SELECT user_id, login, first_name, last_name, ask, answer, orders, phonenumber, contactemail, messenger_number, messenger FROM users WHERE login = '$id'");

		if ($query) {
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$data = array(
						'id' => $row['user_id'],
						'login' => $row['login'],
						'first_name' => $row['first_name'],
						'last_name' => $row['last_name'],
						'ask' => count(explode(",", $row['ask'])) - 1,
						'answer' => count(explode(",", $row['answer'])) - 1,
						'orders' => explode(",",$row['orders']),
						'phonenumber' => $row['phonenumber'],
						'contactemail' => $row['contactemail'],
						'messenger_number' => $row['messenger_number'],
						'messenger' => $row['messenger']
					);
					return $data;
				}
			} else return false;
		} else return '<div class = "alert alert-danger">Something went wrong!</div>';
	}


	public function makeDate($since) {
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


	public function getQuestion ($user) {
		$data = array();

		$query = $this->db->query("SELECT id, zagqu, tags, answers, login, dates, view FROM questions WHERE login = '$user' ORDER BY id DESC LIMIT 0,10");

		if ($query) {
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$data[] = array(
						'id' => $row['id'],
						'zagqu' => $row['zagqu'],
						'tags' => html_entity_decode($row['tags']),
						'answers' => $row['answers'],
						'login' => $row['login'],
						'dates' =>	$this->makeDate($row['dates']),
						'views' => $row['view']
					);
				}
				return $data;
			} else return false;
		} else return 'Something went wrong!';
	}

	public function viewed($view) {
		return $view = ($view > 1) ? $view . ' views' : $view . ' view';
	}

	public function getOrders ($user) {
		$data = array();

		$query = $this->db->query("SELECT id,zagqu, tekst, full_name, tsena, views, published, visibility, deleted FROM ordvac WHERE login = '$user' AND deleted != 'deleted'");

		if($query) {
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$data[] = array(
						'id' => $row['id'],
						'zagqu' => $row['zagqu'],
						'cost' => $row['tsena'],
						'full_name' => $row['full_name'],
						'tekst' => html_entity_decode($row['tekst']),
						'views' => $this->viewed($row['views']),
						'published' => $this->makeDate($row['published']),
						'visibility' => $row['visibility'],
						'deleted' => $row['deleted']
	 				);
				}
			} else return false;
		}
		return $data;
	}
}
?>