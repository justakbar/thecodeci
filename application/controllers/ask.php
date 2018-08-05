<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ask extends CI_Controller {
	public function index () {
		
		if (!isset($_SESSION['logged_in']))
			redirect(base_url() . 'login');

		$page = 'ask_view';

		if (!file_exists(APPPATH.'views/pages/'. $page . '.php')) {
			show_404();
		}

		$this->load->model('ask_model');
		$this->load->helper('form');
		$msg['tekst'] = '';
		$msg['metki'] = '';
		$msg['zagqu'] = '';

		if (isset($_POST['send'])) {
			$tekst = htmlentities($_POST['tekst'], ENT_QUOTES);
			$zagqu = htmlentities($_POST['zagqu'], ENT_QUOTES);
			$metki = htmlentities($_POST['metki'], ENT_QUOTES);

			if (!empty($tekst) && !empty($zagqu) && !empty($metki)) 
				$msg['success'] = $this->ask_model->validate($zagqu, $tekst, $metki, $_SESSION['email'], $_SESSION['username']);
		}
		$this->load->view('templates/header');
		$this->load->view('pages/'.$page, $msg);
		$this->load->view('templates/footer');
	}
}