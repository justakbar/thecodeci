<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function info ($id = NULL) {
        
		$page = 'user_model';

		if ( ! file_exists(APPPATH.'models/'.$page.'.php')) {
            show_404();
        }

        $this->load->model($page);

        $data['data'] = $this->$page->getUser($id);
        if ($data['data'] != false){
            $data['question'] = $this->$page->getQuestion($id);
            $data['order'] = $this->$page->getOrders($id);
            $this->load->view('templates/header');
            $this->load->view('pages/user_view', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header');
            $this->load->view('pages/user_view',$data);
            $this->load->view('templates/footer');
        }

	}
}
?>