<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_data_model extends CI_Model {

	public function viewed ($allip, $id) {
		$ips = explode(",", $allip);
		$ip = $_SERVER['REMOTE_ADDR'];
		if ( !in_array($ip, $ips)) {
			$ip = $ip . "," . $allip;
			$this->db->query("UPDATE questions SET views = '$ip', view = view + 1 WHERE id = '$id'");
		}
	}

	function vote ($id, $type) {

		$query = $this->db->query("SELECT voteplus,voteminus FROM questions WHERE id = '$id'");

        if ($query->num_rows()) {
            $row = $query->row_array();

            $userId = $_SESSION['id'];
            $votePlus = explode(",", $row['voteplus']);
            $voteMinus = explode(",", $row['voteminus']);

            if ($type == 'voteup') {
            	if (!in_array($userId, $votePlus)) {

            		$newVotedPlus = $userId . "," . $row['voteplus'];
            		$newVotedMinus = $row['voteminus'];

            		if (in_array($userId, $voteMinus)) {
            			$newVotedMinus = str_replace($userId . ",", '', $row['voteminus']);
	            	}
	               	$query = $this->db->query("UPDATE questions SET voteplus = '$newVotedPlus', voteminus = '$newVotedMinus', allvotes = allvotes + 1, votes = votes + 1 WHERE id = '$id'");
            	}
            } else {
            	if (!in_array($userId, $voteMinus)) {
            		$newVotedMinus= $userId . "," . $row['voteminus'];
            		$newVotedPlus = $row['voteplus'];

            		if (in_array($userId, $votePlus)) {
            			$newVotedPlus = str_replace($userId . ",", '', $row['voteplus']);
	            	}
	               	$query = $this->db->query("UPDATE questions SET voteplus = '$newVotedPlus', voteminus = '$newVotedMinus', allvotes = allvotes + 1, votes = votes - 1 WHERE id = '$id'");
            	}
            }
        }
	}

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

	function answersMake ($ans) {
		return ($ans > 1) ? $ans . ' Answers' : $ans . ' Answer';
	}

	function checkvote ($voteMinus,$votePlus) {
		$voteMinus = explode(",", $voteMinus);
		$votePlus = explode(",", $votePlus);

		if (isset($_SESSION['id']))
			$userId = $_SESSION['id'];
		else return array('','');

		if (in_array($userId, $voteMinus)) {
			return array('', 'disabled');
		} elseif (in_array($userId, $votePlus)) {
			return array('disabled', '');
		}
	}

	function getData ($id) {
		$data = array();

		$query = $this->db->query("SELECT * FROM questions WHERE id = $id");

		if ($query) {
			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$this->viewed($row['views'], $id);
				$data = array(
					'id' => $row['id'],
					'zagqu' => $row['zagqu'],
					'question' => html_entity_decode($row['question']),
					'tags' => html_entity_decode($row['tags']),
					'answers' => $this->answersMake($row['answers']),
					'login' => $row['login'],
					'dates' => $this->makeDate($row['dates']),
					'views' => $row['view'],
					'voteDis' => (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) ? $this->checkvote($row['voteminus'],$row['voteplus']) : array('',''),
					'votes' => $row['votes'],
					'allvotes' => $row['allvotes']
				);
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
					$row = $query->row_array();
					$last = $row['answer'] . $id . ',';
					$this->db->query("UPDATE users SET answer = '$last' WHERE login = '$login'");
				}
			}
		}
	}
}