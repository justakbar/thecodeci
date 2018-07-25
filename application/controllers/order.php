<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public function index () {

		if (!isset($_SESSION['logged_in'])) {
			redirect (base_url() . 'login');
		}

		$this->load->model('ordvac_model');
		$this->load->helper('form');
		$data['error'] = '';
		if (isset($_POST['send'])) {
			$zagqu  = htmlentities(trim($_POST['zagqu']),ENT_QUOTES);
			$cost   = htmlentities(trim($_POST['cost']),ENT_QUOTES);
			$valyuta = htmlentities($_POST['valyuta'],ENT_QUOTES);
			$text   = htmlentities(trim($_POST['noise']),ENT_QUOTES);
			$domain = htmlentities($_POST['domain'],ENT_QUOTES);

			$data['error'] = $this->ordvac_model->order($zagqu, $cost, $valyuta, $domain, $text);

			$this->load->view('templates/header');
			$this->load->view('pages/to_order_view',$data);
			$this->load->view('templates/footer');
		} else {
			$this->load->view('templates/header');
			$this->load->view('pages/to_order_view',$data);
			$this->load->view('templates/footer');
		}
	}
}
?>