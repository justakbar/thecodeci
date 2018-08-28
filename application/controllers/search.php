<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	public function index () {

		if (isset($_GET['qu'])) {
			$word = htmlentities($_GET['qu'], ENT_QUOTES);

			$this->load->model('search_model');

			if (isset($_GET['p']) && $_GET['p'] > 0) {
				$id = $_GET['p'];
				$num = ($_GET['p'] - 1) * 10;
			} else {
				$num = 0;
				$id = 1;
			}
			$data['all'] = $this->search_model->countSearchResult($word);
			$type = '?qu=' . $word . '&p=';
			$data['data'] = $this->search_model->search($word,$num);
			if ($data['all'] != 0)
				$data['pagination'] = $this->search_model->makePagination($id,$data['all'],$type);
			else $data['pagination'] = '';

			$this->load->view('templates/header');
	        $this->load->view('pages/search_view', $data);
	        $this->load->view('templates/footer');
		}
	}
}
?>