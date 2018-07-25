<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function index () {

		if (!isset($_SESSION['logged_in'])) {
			redirect(base_url().'login');
		}

        $page = 'profile_model';

        if ( ! file_exists(APPPATH.'models/'.$page.'.php')) {
            show_404();
        }

        $this->load->model($page);


        $id = $_SESSION['id'];
        $data['data'] = $this->$page->getUserData($id);
        $data['question'] = $this->$page->getQuestion($data['data']['login']);
        $data['order'] = $this->$page->getOrders($data['data']['login']);

        if (isset($_POST['update'])) {
        	$last = htmlentities($_POST['lastpass'],ENT_QUOTES);
        	$pass1 = htmlentities($_POST['newpass1'],ENT_QUOTES);
        	$pass2 = htmlentities($_POST['newpass2'],ENT_QUOTES);

        	$data['update'] = $this->$page->updatePass ($data['data']['login'],$last, $pass1, $pass2);
        }

        if (isset($_POST['type']) && isset($_POST['id'])) {
            $order_id = $_POST['id'];
            $order_type = $_POST['type'];
            $user = $data['data']['login'];
            
            if (is_numeric($order_id) && ($order_type == '1' || $order_type == '0')) { 
                $query = $this->db->query("SELECT visibility FROM ordvac WHERE id = '$order_id' AND login = '$user'");

                if ($query) {
                    $row = $query->row_array();
                    $visibile = $row['visibility'];

                    if ($visibile != $order_type) {
                        $query = $this->db->query("UPDATE ordvac SET visibility = '$order_type' WHERE id = '$order_id' AND login = '$user'");
                        redirect(base_url() . 'profile');
                    }
                }
            }
        }

        if (isset($_POST['id']) && isset($_POST['query'])) {
            $order_id = $_POST['id'];
            $order_query = $_POST['query'];
            $user = $data['data']['login'];

            if (is_string($order_id) && $order_query == 'delete') {
                $query = $this->db->query("SELECT deleted FROM ordvac WHERE id = '$order_id' AND login = '$user'");
                
                if ($query) {
                    $row = $query->row_array();
                    $deleted = $row['deleted'];
                    if ($deleted != $order_query) {
                        $query = $this->db->query("UPDATE ordvac SET deleted = 'deleted' WHERE id = '$order_id' AND login = '$user'");
                    }
                }
            }
        }


        if (isset($_POST['contact'])) {
        	$phonenumber = htmlentities($_POST['phonenumber'], ENT_QUOTES);
        	$contactemail = htmlentities($_POST['contactemail'], ENT_QUOTES);
        	$messenger = htmlentities($_POST['messenger'], ENT_QUOTES);
        	$messengerdata = htmlentities($_POST['messengerdata'], ENT_QUOTES);

        	$data['updatecontact'] = $this->$page->updateContacts($data['data']['id'], $phonenumber, $contactemail, $messenger, $messengerdata); 
        }

        $this->load->view('templates/header');
        $this->load->view('pages/profile_view', $data);
        $this->load->view('templates/footer');
	}
}

?>