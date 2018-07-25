<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model {
	public function getUserData ($id) {
		$data = array();
		$query = $this->db->query("SELECT user_id, login, first_name, last_name, ask, answer, orders, phonenumber, contactemail, messenger_number, messenger FROM users WHERE user_id = '$id'");

		if ($query) {
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$data = array(
						'id' => $row['user_id'],
						'login' => $row['login'],
						'first_name' => $row['first_name'],
						'last_name' => $row['last_name'],
						'ask' => count(explode(",", $row['ask'])) - 1,
						'answer' => count(explode(",", $row['answer'])) - 1,
						'orders' => explode(",",$row['orders']),
						'phonenumber' => $row['phonenumber'],
						'contactemail' => $row['contactemail'],
						'messenger_number' => $row['messenger_number'],
						'messenger' => $row['messenger']
					);
					return $data;
				}
			} else return '<div class = "alert alert-danger">User not found!</div>';
		} else return '<div class = "alert alert-danger">Something went wrong!</div>';
	}

	public function makeDate($since) {
		$since = time() - $since;
		$chunks = array(
			array(60 * 60 * 24 * 365 , 'year'),
			array(60 * 60 * 24 * 30 , 'month'),
			array(60 * 60 * 24 * 7, 'week'),
			array(60 * 60 * 24 , 'day'),
			array(60 * 60 , 'hour'),
			array(60 , 'minute'),
			array(1 , 'second')
		);

	    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
	   		$seconds = $chunks[$i][0];
		   	$name = $chunks[$i][1];
	        if (($count = floor($since / $seconds)) != 0) {
	        	break;
	    	}
	    }

		$print = ($count == 1) ? '1 '.$name . ' ago': "$count {$name}s ago";

		return $print;
	}

	public function getQuestion ($user) {
		$data = array();

		$query = $this->db->query("SELECT id, zagqu, tags, answers, login, dates, view FROM questions WHERE login = '$user' ORDER BY id DESC LIMIT 0,10");

		if ($query) {
			foreach ($query->result_array() as $row) {
				$data[] = array(
					'id' => $row['id'],
					'zagqu' => $row['zagqu'],
					'tags' => $row['tags'],
					'answers' => $row['answers'],
					'login' => $row['login'],
					'dates' =>	$this->makeDate($row['dates']),
					'views' => $row['view']
				);
			}
			return $data;
		} else return 'fuck';
	}

	public function viewed($view) {
		return $view = ($view > 1) ? $view . ' views' : $view . ' view';
	}

	public function getOrders ($user) {
		$data = array();

		$query = $this->db->query("SELECT id,zagqu, tekst, full_name, tsena, views, published, visibility, deleted FROM ordvac WHERE login = '$user' AND deleted != 'deleted'");

		if($query) {
			foreach ($query->result_array() as $row) {

				$data[] = array(
					'id' => $row['id'],
					'zagqu' => $row['zagqu'],
					'cost' => $row['tsena'],
					'full_name' => $row['full_name'],
					'tekst' => html_entity_decode($row['tekst']),
					'viewed' => $this->viewed($row['views']),
					'published' => $this->makeDate($row['published']),
					'visibility' => $row['visibility'],
					'deleted' => $row['deleted']
 				);
			}
		}
		return $data;
	}

	public function updatePass ($login, $lastpass, $password1, $password2) {
		if(!empty($password1) && !empty($password2) && !empty($lastpass))
        {
            if($password2 == $password1 && !empty($password2) && !empty($password1)) 
            {
                if(isset($_SESSION['email']) && $_SESSION['username'] && isset($_COOKIE['cookie']) && isset($_COOKIE['hash']))
                {
                    $query = $this->db->query("SELECT password FROM users WHERE login = '$login'");
                    
                    foreach ($query->result_array() as $row) {
                    	$pass = $row['password'];
                    }

                    if($pass === sha1(sha1($lastpass)))
                    {
                        $password2 = sha1(sha1($password2));

                        $query = $this->db->query("UPDATE users SET password = '$password2' WHERE login = '$login'");

                        if($query)
                        	return '<div class = "alert alert-success">Success</div>';
                        else return '<div class = "alert alert-danger">Something went wrong!</div>';
                    }
                    else $err = '<div class = "alert alert-danger">Неверный текущий пароль!</div>';
                }
                else $err = '<div class = "alert alert-danger">Что то пошло не так!</div>';
            }
            else $err = '<div class = "alert alert-danger">Пароли не совпадают!</div>';
        }
        else $err = '<div class = "alert alert-danger">Try again!</div>';
        return $err;
	}

	public function updateContacts ($id,$contact_number, $email, $messenger, $messenger_data) {
		$error = array();
		if (!empty($contact_number)) {
			
			if($contact_number[0] === '+')
				$contact_number = substr($contact_number, 1);

			if(strlen($contact_number) != 12 || preg_match('/[+]/',$contact_number))
				$error[] = '<div class = "alert alert-danger">Телефон номер неверный!</div>';
		}

		if (!empty($email)) {
			if(!filter_var($email, FILTER_VALIDATE_EMAIL))
				$error[] = '<div class = "alert alert-danger">Эл. почта неверный!</div>';
		}

		if (!empty($messenger_data)) {
			
			if($messenger_data[0] === '+')
				$messenger_data = substr($messenger_data,1);

			if(strlen($messenger_data) != 12 || !is_numeric($messenger_data))
				$error[] = '<div class = "alert alert-danger">Номер мессенджера неверный!</div>';
			
			if ($messenger != 'Telegram' && $messenger != 'WhatsApp')
				$error[] = '<div class = "alert alert-danger">WhatsApp или Telegram</div>';
		}

		if(count($error) == 0)
		{
			$query = $this->db->query("UPDATE users SET phonenumber = '$contact_number', contactemail = '$email', messenger_number = '$messenger_data', messenger = '$messenger' WHERE user_id = '$id'");
			
			if($query)
				return array('<div class = "alert alert-success">Success</div>');
			else return array('<div class = "alert alert-danger">Something went wrong!</div>');
		}
		else return $error;
	}
}
?>