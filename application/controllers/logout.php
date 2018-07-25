<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index () {
		session_destroy();
		unset($_COOKIE['hash']);
		unset($_COOKIE['cookie']);
		setcookie('cookie', '', time() - 3600, '/');
		setcookie('hash', '', time() - 3600, '/');
		/*delete_cookie('cookie', '', time() - 3600, '/');
		delete_cookie('hash', '', time() - 3600, '/');*/
		redirect (base_url().'login');
	}

}
?>