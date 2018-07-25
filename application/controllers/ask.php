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

		$this->load->library('form_validation');
		$this->load->model('ask_model');

		if (isset($_POST['send'])) {
			$msg['tekst'] = '';
			$msg['metki'] = '';
			$msg['zagqu'] = '';
			if ( $this->security->xss_clean($_POST['zagqu'],$_POST['tekst'],$_POST['metki']) == TRUE) {

				$this->form_validation->set_rules('zagqu', 'заголовок вопроса', 'required|min_length[1]|max_length[100]');
				$this->form_validation->set_rules('tekst', 'текста', 'required|min_length[1]');
				$this->form_validation->set_rules('metki', 'метки', 'required|min_length[1]|max_length[100]');

				if ( $this->form_validation->run() == true ) {
					$msg['success'] = $this->ask_model->validate($_POST['zagqu'], $_POST['tekst'], $_POST['metki'], $_SESSION['email'], $_SESSION['username']);
					$this->load->view('templates/header');
					$this->load->view('pages/'.$page,$msg);
					$this->load->view('templates/footer');
				} else {
					$this->load->view('templates/header');
					$this->load->view('pages/'.$page,$msg);
					$this->load->view('templates/footer');
				} 
			} else {
				$this->load->view('templates/header');
				$this->load->view('pages/'.$page, $msg);
				$this->load->view('templates/footer');
			}
		} else {
			$this->load->view('templates/header');
			$this->load->view('pages/'.$page);
			$this->load->view('templates/footer');
		}
	}
}