<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_list_model extends CI_Model {
	
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

    public function get_last_ten_question ($num,$offset) {
    	$data = array();
	    
	    /*$query = "SELECT id, zagqu, tags, answers, login, dates, view FROM questions ORDER BY id DESC";*/
	    $this->db->order_by('id','DESC');
	    $query = $this->db->get('questions',$num,$offset);

    	if ($query) {
			foreach ($query->result_array() as $row) {
				$data[] = array(
					'id' => $row['id'],
					'zagqu' => $row['zagqu'],
					'tags' => html_entity_decode($row['tags']),
					'answers' => $row['answers'],
					'login' => $row['login'],
					'dates' => $this->makeDate($row['dates']),
					'views' => $row['view']
				);
			}
		}
		else exit("error");
    	return $data;
    }

    public function get_tag_questions ($tag,$num,$offset) {
    	$data = array();
    	$search = "tags LIKE '%$tag%'";

    	$this->db->order_by('id','DESC');
		$query = $this->db->where($search)->get('questions',$num, $offset);

		if ($query) {
			foreach ($query->result_array() as $row) {
				$data[] = array(
					'id' => $row['id'],
					'zagqu' => $row['zagqu'],
					'tags' => html_entity_decode($row['tags']),
					'answers' => $row['answers'],
					'login' => $row['login'],
					'dates' => $this->makeDate($row['dates']),
					'views' => $row['view']
				);
			}
			return $data;
		} else return 'Something went wrong!';
    }
}
