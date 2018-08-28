<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Question extends CI_Controller {

    public function index ()
    {
        $this->load->library('pagination');
        $page = 'question_list_model';
        if ( ! file_exists(APPPATH.'models/'.$page.'.php')) {
            show_404();
        }
        $this->load->model($page);

        if (isset($_GET['p']) && $_GET['p'] != 0)
            $id = $_GET['p'];
        else $id = 1;

        if (isset($_GET['p']) && $_GET['p'] > 1) {
            $num = ($_GET['p'] - 1) * 10;
        } else {
            $num = 0;
        }
        /*$i = 100;
        $tags = '<a class = "badge badge-light" href = "'.base_url().'question/tag/php">php </a>';
        while (++$i <= 200) {
            $this->db->query("INSERT INTO questions (zagqu, tags, metki) VALUES ('$i', '$tags', 'php')");
        }*/
        $type = '?p=';
        $data['question'] = $this->$page->get_last_ten_question($num);
        $data['allQuestions'] = $this->$page->count_all_questions();
        $data['pagination'] = $this->$page->makePagination($id,$this->db->count_all('questions'),$type);
        
        $this->load->view('templates/header');
        $this->load->view('pages/question_view',$data);
        $this->load->view('templates/footer');
    }

    public function num ($id = NULL, $page = 'question_data_model') {
        
        $this->load->model($page);
        if (isset($_POST['send'])) {
            $text = htmlentities($_POST['answertext'], ENT_QUOTES);

            $data['success'] = $this->$page->answerToQuestion($text);
        }

        if (isset($_POST['query'])) {
            $what = htmlentities($_POST['query'], ENT_QUOTES);
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
                if ($what == 'voteup' || $what == 'votedown')
                $this->$page->vote($id, $what);
            }
        }

        if (isset($id) && is_numeric($id)) {    
            $data['data'] = $this->$page->getData ($id);
            $data['answer'] = $this->$page->getAnswers ($id);
        } else {
            $data['data'] = 'Question not exist!';
        }
        $this->load->view('templates/header');
        $this->load->view('pages/question_data_view',$data);
        $this->load->view('templates/footer');
    }       

    public function tag ( $tag = NULL) {
        $this->load->model('question_list_model');
        $this->load->library('pagination');
        
        $search = "tags LIKE '%$tag%'";
        if (isset($_GET['p']) && $_GET['p'] != 0)
            $id = $_GET['p'];
        else $id = 1;

        if (isset($_GET['p']) && $_GET['p'] > 1) {
            $num = ($_GET['p'] - 1) * 10;
        } else {
            $num = 0;
        }

        $all = $this->question_list_model->countTagsAndCheck($tag);
        $type = 'tag/' . $tag . '/?p=';
        $data['question'] = $this->question_list_model->get_tag_questions($num,$tag);
        $data['allQuestions'] = $this->question_list_model->count_all_questions();
        if ($all != 0)
            $data['pagination'] = $this->question_list_model->makePagination($id, $all, $type);
        else $data['pagination'] = '';

        $this->load->view('templates/header');
        $this->load->view('pages/question_view',$data);
        $this->load->view('templates/footer');
    }
}