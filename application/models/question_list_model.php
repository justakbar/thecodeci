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

	public function count_all_questions () {
		return chunk_split($this->db->count_all('questions'), 3, ' ');
	}

	public function countTagsAndCheck($tag) {
		$row = $this->db->query("SELECT * FROM metki")->row_array();
		$arr = json_decode($row['value'],true);
		if (isset($arr[$tag])) {
			return $arr[$tag];
		} else return 0;
	}

	public function makePagination ($id,$all,$type) {
		$text = '';
		$all = ceil($all / 10);
		$first = (($id - 4) > 1) ? $id - 5 : 1;
		$last = (($id + 4) < $all) ? $id + 5 : $all;

		if ($first > 1 && $first != $id) {
			$text .= '<a href="' . base_url() . 'question/'.$type.'1">1</a> <span style ="padding: 8px;">...</span>';
			$first++;
		}
		while ($first < $last) {

			if ($first != $id) {
				$text .= '<a href="' . base_url() . 'question/'.$type . $first . '">' . $first . '</a>';
			} else {
				$text .= '<span class = "actived">' . $first . '</span>';
			}
			$first++;
		}
		if ($all - $last > 0) {
			$text .= '<span style ="padding: 8px;">...</span>';
		}

		if ($all != $id) {
			$text .= '<a href="' . base_url() . 'question/' . $type . $all . '">' . $all . '</a>';
		} else {
			$text .= '<span class = "actived">' . $all . '</span>';
		}
		return $text;
	}

    public function get_last_ten_question ($num) {
    	$data = array();

	    $query = $this->db->query("SELECT * FROM questions ORDER BY id DESC LIMIT $num, 10");
    	if ($query) {
			foreach ($query->result_array() as $row) {
				$data[] = array(
					'id' => $row['id'],
					'zagqu' => $row['zagqu'],
					'tags' => html_entity_decode($row['tags']),
					'answers' => $row['answers'],
					'login' => $row['login'],
					'dates' => $this->makeDate($row['dates']),
					'views' => $row['view'],
					'votes' => $row['votes'],
				);
			}
		}
		else exit("error");
    	return $data;
    }

    public function get_tag_questions ($num,$tag) {
    	$data = array();

		$query = $this->db->query("SELECT * FROM questions WHERE tags LIKE '%$tag%' ORDER BY id DESC LIMIT $num, 10");

		if ($query) {
			foreach ($query->result_array() as $row) {
				$data[] = array(
					'id' => $row['id'],
					'zagqu' => $row['zagqu'],
					'tags' => html_entity_decode($row['tags']),
					'answers' => $row['answers'],
					'login' => $row['login'],
					'dates' => $this->makeDate($row['dates']),
					'views' => $row['view'],
					'votes' => $row['votes']
				);
			}
			return $data;
		} else return 'Something went wrong!';
    }
}
