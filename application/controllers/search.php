<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	public function index () {

		if (isset($_GET['qu'])) {
			$word = htmlentities($_GET['qu'], ENT_QUOTES);

			$this->load->model('search_model');
			$search = "zagqu LIKE '%$word%' OR question LIKE '%$word%' OR tags LIKE '%$word%'";

			$this->load->library('pagination');
			$config['base_url'] = base_url(). 'search/';
			$config['total_rows'] = $this->db->where($search)->get('questions')->num_rows();
	        $config['reuse_query_string'] = TRUE;

	        $config['per_page'] = 10;

	        $config['full_tag_open'] = '<div class = "pagination">';
	        $config['full_tag_close'] = '</div>';
	        $config['cur_tag_open'] = '<span class = "actived">';
	        $config['cur_tag_close'] = '</span>';
	        $page = isset($_GET['per_page']) ? $_GET['per_page'] : 0;

			$data['data'] = $this->search_model->search($word, $config['per_page'], $page);

			$this->pagination->initialize($config);

			$this->load->view('templates/header');
	        $this->load->view('pages/search_view', $data);
	        $this->load->view('templates/footer');
		}
	}
}
?>