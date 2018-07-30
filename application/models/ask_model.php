<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ask_model extends CI_Model {

	function validate ($zagqu, $tekst, $metki, $email, $login) {

		$err = array();
		$metki = preg_replace('/\s\s+/', ' ', $metki);
		$part = str_word_count($metki);
		
		if($part >= 6 || $part < 0)
			return '<div class = "alert alert-danger">Добавтье не менее 1 и не более 5 метки!</div>';
		$tags = '';	
		if (count($err) == 0) {
			$tag = explode(" ", $metki);
			foreach ($tag as $key) {
				$tags .= '<a class = "badge badge-light" href = "'.base_url().'question/tag/'. urlencode($key) . '">'. html_entity_decode($key) . ' </a> ';
			}
			$time = time();
			$tags = htmlentities($tags, ENT_QUOTES);
			$query = $this->db->query("INSERT INTO `questions` (zagqu, question, tags, answers, email, login, dates, views, viewed, view) VALUES ('$zagqu', '$tekst', '$tags', '0', '$email', '$login', '$time', '', '', '0')");

			if ($query) {

				$last = $this->db->insert_id();

				$query = $this->db->get('metki');

				foreach ($query->result_array() as $row) {
					$value = $row['value'];
				}
				$array = json_decode($value,true);
				$tag = array_count_values($tag);

	  			foreach ($tag as $key => $value) {
					if (isset($array[$key])) {
						$array[$key] = $array[$key] + $value;
					}
					else $array[$key] = 1;
				}
				arsort($array);
				$array = json_encode($array, JSON_PRETTY_PRINT);
				$this->db->query("UPDATE metki SET value = '$array' WHERE id = '1'");

				$query = $this->db->query("SELECT ask FROM users WHERE login = '$login'");

				foreach ($query->result_array() as $row) {
					$last = $row['ask'] . $last . ',';
					$query = $this->db->query("UPDATE users SET ask = '$last' WHERE login = '$login'");
					if ($query)
						return '<div class = "alert alert-success">Success</div>';
					else return '<div class = "alert alert-danger">Something went wrong!';
				}
			}
		}
	}
}
