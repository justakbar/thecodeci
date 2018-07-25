<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

        public function generateCode($length=20) {

                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
                $code = "";
                $clen = strlen($chars) - 1;
                while (strlen($code) < $length) {
                        $code .= $chars[mt_rand(0,$clen)];
                }
                return $code;
        }

        public function login ($login, $password) {
                $password = sha1(sha1($password));
                $query = $this->db->query("SELECT user_id, login, email, confirm, first_name, last_name FROM users WHERE login = '$login' AND password = '$password'");

                if ($query) {
                        if ($query->num_rows() == 1) {

                                foreach ($query->result_array() as $row) {
                                        if ($row['confirm'] == 1) {
                                                $hash = $this->generateCode();
                                                $id = $row['user_id'];

                                                $this->db->query("UPDATE users SET hash = '$hash' WHERE user_id = '$id'");

                                                $_SESSION['id'] = $id;
                                                $_SESSION['username'] = $row['login'];
                                                $_SESSION['name'] = $row['first_name'];
                                                $_SESSION['surname'] = $row['last_name'];
                                                $_SESSION['hash'] = $hash;
                                                $_SESSION['logged_in'] = true;
                                                $_SESSION['email'] = $row['email'];
                                                $_SESSION['code'] = substr(sha1(sha1($row['email'])), 0, -6);

                                                setcookie('cookie', $_SESSION['code'], time() + 60*60*24);
                                                setcookie('hash', $hash, time() + 60*60*24);
                                                redirect(base_url());
                                        } else {
                                                $_SESSION['activate'] = $row['email'];
                                                return '<div class = "alert alert-warning">Подтвердите эл.почту!</div>';
                                        }
                                }

                        } else return '<div class = "alert alert-danger">Неверный логин или пароль</div>';      
                }
        }

        public function activate ($act,$email) {
                if($act === substr(sha1(sha1($email)), 0, -10))
                {
                        $query = $this->db->query("SELECT confirm FROM users WHERE email = '$email'");

                        if ($query) {
                                $row = $query->row_array();

                                if($row['confirm'] == 1)
                                        return '<div class = "alert alert-warning">Эл. почта уже активирована!</div>';
                                else {
                                        $this->db->query("UPDATE users SET confirm = '1' WHERE email = '$email'");
                                        return '<div class = "alert alert-success">Теперь вы можете войти!</div>';
                                }
                        }
                }
        }
}
?>