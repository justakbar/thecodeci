<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ordvac extends CI_Controller {

	public function page () {
        $this->load->library('pagination');
		$page = 'ordvac_model';

		if ( ! file_exists(APPPATH.'models/'.$page.'.php')) {
            show_404();
        }

        $config['base_url'] = base_url(). 'ordvac/page/';
        $config['total_rows'] = $this->db->count_all('ordvac');
        $config['per_page'] = 10;

        $config['full_tag_open'] = '<div class = "pagination">';
        $config['full_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<span class = "actived">';
        $config['cur_tag_close'] = '</span>';
        $this->pagination->initialize($config);
        $uri = $this->uri->segment(3);


        $this->load->model($page);

        $data['data'] = $this->$page->getOrder($config['per_page'],$uri);

       	$this->load->view('templates/header');
        $this->load->view('pages/ordvac_view', $data);
        $this->load->view('templates/footer');
	}

	public function order ($id) {

		$page = 'order_view';

		if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php')) {
            show_404();
        }

        $this->load->model('ordvac_model');

        $data['data'] = $this->ordvac_model->getOrderData($id);

        $this->load->view('templates/header');
        $this->load->view('pages/order_view', $data);
        $this->load->view('templates/footer');
	}
}
?>