<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index($page = 'login_view') {
               
                if (isset($_SESSION['logged_in']))
                        redirect(base_url());

                $this->load->library('form_validation');

		if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
                {
                        // Whoops, we don't have a page for that!
                        show_404();
                }

                $this->load->model('login_model');
                if (isset($_POST['send'])) {

                        $this->form_validation->set_rules('username', 'логина', 'required|min_length[4]|max_length[20]');
                        $this->form_validation->set_rules('password', 'пароля', 'required');

                        $check = $this->form_validation->run();

                        if ($check == true) {
                                $login = htmlspecialchars($_POST['username']);
                                $pass = htmlspecialchars($_POST['password']);
                                $msg['success'] = $this->login_model->login($login,$pass);
                                $msg['login'] = $login;
                                
                                $this->load->view('templates/header'); 
                                $this->load->view('pages/'.$page, $msg);
                                $this->load->view('templates/footer');

                        } else {
                                $this->load->view('templates/header');
                                $this->load->view('pages/'.$page);
                                $this->load->view('templates/footer');
                        }
                }
                else { 
                        $this->load->view('templates/header');
                        $this->load->view('pages/'.$page);
                        $this->load->view('templates/footer');
                }
	}

        public function activate ($act) {
                $this->load->helper('form');
                $this->load->model('login_model');
                if (isset($_SESSION['activate'])) 
                {
                        $email = $_SESSION['activate'];
                        $verify['verify'] = $this->login_model->activate($act,$email);
                        $this->load->view('templates/header'); 
                        $this->load->view('pages/login_view', $verify);
                        $this->load->view('templates/footer');
                } else {
                        $_SESSION['activate'] = $this->post->email;
                }
        }
}

?>