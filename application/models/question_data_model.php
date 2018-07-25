<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_data_model extends CI_Model {

	function getAnswers ($id) {
		$data = array();
		$query = $this->db->query("SELECT answer, login, dates FROM answer WHERE qu_id = '$id' ORDER BY id DESC");
		if ($query) {
			if ($query->num_rows() > 0) {
				foreach ( $query->result_array() as $row) {
					$data[] = array(
						'answer' => html_entity_decode($row['answer']),
						'login' => $row['login'],
						'dates' => $this->makeDate($row['dates'])
					);
				}
			} else return '';
		}
		return $data;
	}

	function makeDate($since) {
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

	function getData ($id) {
		$data = array();

		$query = $this->db->query("SELECT * FROM questions WHERE id = $id");

		if ($query) {
			if ($query->num_rows() > 0) { 
				foreach ($query->result_array() as $row) {
					$data = array(
						'id' => $row['id'],
						'zagqu' => $row['zagqu'],
						'question' => $row['question'],
						'tags' => $row['tags'],
						'answers' => $row['answers'],
						'login' => $row['login'],
						'dates' => $this->makeDate($row['dates']),
						'views' => $row['view']
					);
				}
			}
			else return 'Question not exist!';
		}
		return $data;
	}

	function answerToQuestion ($text) {
		if (isset($_SESSION['logged_in'])) { 
			if ( !empty($text) ) {
				$login = $_SESSION['username'];
				$url = explode("/", uri_string());
				$id = $url[2];
				$time = time();
				$query = $this->db->query("INSERT INTO answer (answer, qu_id, login, dates) VALUES ('$text', '$id', '$login', '$time')");
				$this->db->query("UPDATE questions SET answers = answers + 1 WHERE id = '$id'");
				if ($query) {
					$query = $this->db->query("SELECT answer FROM users WHERE login = '$login'");

					foreach ($query->result_array() as $row){
						$last = $row['answer'] . $id . ',';
					}

					$this->db->query("UPDATE users SET answer = '$last' WHERE login = '$login'");
					return '<div class = "alert alert-success">Success</div>';
				}
			}
		}
	}
}