<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

        public function index($page = 'registration_view')
        {
                if (isset($_SESSION['logged_in']))
                        redirect(base_url());
                $this->load->helper('form');
                if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
                {
                        // Whoops, we don't have a page for that!
                        show_404();
                }

                $this->load->model('registration_model');

                if (isset($_POST['send'])) {
                        $first_name = htmlentities(trim($_POST['first_name']),ENT_QUOTES);
                        $last_name = htmlentities(trim($_POST['last_name']),ENT_QUOTES);
                        $email = htmlentities(trim($_POST['email']),ENT_QUOTES);
                        $username = htmlentities(trim($_POST['username']),ENT_QUOTES);
                        $password1= htmlentities(trim($_POST['password1']),ENT_QUOTES);
                        $password2 = htmlentities(trim($_POST['password2']),ENT_QUOTES);

                        $msg['msg'] = $this->registration_model->registration($first_name, $last_name, $username, $password1, $password2, $email);
                        $this->load->view('templates/header');
                        $this->load->view('pages/'.$page,$msg);
                        $this->load->view('templates/footer');
                } else {
                        $this->load->view('templates/header');
                        $this->load->view('pages/'.$page);
                        $this->load->view('templates/footer');
                }
        }

}
