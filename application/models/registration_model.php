<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration_model extends CI_Model { 

	public function registration ($first_name,$last_name,$username,$password1,$password2,$email) {
		$err = array();
		$time = time();
		if( !preg_match("/^[a-zA-Zа-яА-Я]+$/iu",$first_name))
			$err[] = "Имя и Фамилия может состоять только из букв";

		if( !preg_match("/^[a-zA-Zа-яА-Я]+$/iu",$last_name))
			$err[] = "Имя и Фамилия может состоять только из букв";

		if((strlen($first_name) < 1 || strlen($first_name) > 30) && (strlen($last_name) < 1 || strlen($last_name) > 30) )
			$err[] = "Имя и Фамилия должен быть не меньше 5-х символов и не больше 30";

		if( !preg_match("/^[a-zA-Z0-9_]+$/iu",$username))
			$err[] = "Логин может состоять только из букв английского алфавита";

		/*if( !preg_match("/^[a-zA-Z]+$/iu",$username))
			$err[] = "Логин может состоять только из букв английского алфавита";*/

		if( (strlen($username) < 5 || strlen($username) > 20) )
			$err[] = "Логин должен быть не меньше 5-х символов и не больше 20";

		if(strlen($password1) < 8)
			$err[] = "Пароль должен быть не меньше 8-х символов";

		if($password1 !== $password2)
			$err[] = "Пароли не совпадают";

		$data1 = $this->db->query("SELECT email FROM users WHERE email = '$email'");
		$data2 = $this->db->query("SELECT login FROM users WHERE login = '$username'");

		if($data1->num_rows() > 0)
			$err[] = "Эл.почта уже существует!";

		if($data2->num_rows() > 0)
			$err[] = "Логин уже существует!";

		if(count($err) == 0)
        {
          $password = sha1(sha1($password2));

          $query = $this->db->query("INSERT INTO `users` (login, email, password, first_name, last_name, confirm, reg_time) VALUES ('$username','$email',  '$password', '$first_name', '$last_name', '0', '$time')");

          mail($email, "Регистрация на сайт thecode.uz", 'Ссылка для активации: <a href = "' . base_url() . 'login/activate/'. substr(sha1(sha1($email)), 0, -10) . '">подтвердить</a>');

          $_SESSION['activate'] = $email;
          redirect (base_url().'login');
        } else return $err;
	}

}

?>