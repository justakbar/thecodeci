<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Question extends CI_Controller {

        public function page ()
        {
            $this->load->library('pagination');
            $page = 'question_list_model';
            if ( ! file_exists(APPPATH.'models/'.$page.'.php'))
            {
                    // Whoops, we don't have a page for that!
                    show_404();
            }
            $this->load->model($page);

            $config['base_url'] = base_url(). 'question/page/';
            $config['total_rows'] = $this->db->count_all('questions');
            $config['per_page'] = 10;

            $config['full_tag_open'] = '<div class = "pagination">';
            $config['full_tag_close'] = '</div>';
            $config['cur_tag_open'] = '<span class = "actived">';
            $config['cur_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            $data['question'] = $this->$page->get_last_ten_question($config['per_page'], $this->uri->segment(3));

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

            if (isset($id)) {
                
                    $data['data'] = $this->$page->getData ($id);
                    $data['answer'] = $this->$page->getAnswers ($id);
                    $this->load->view('templates/header');
                    $this->load->view('pages/question_data_view',$data);
                    $this->load->view('templates/footer');
            } else {
                    $data['data'] = 'Question not exist!';
                    $this->load->view('templates/header');
                    $this->load->view('pages/question_data_view',$data);
                    $this->load->view('templates/footer');
            }
        }       

        public function tag ( $tag = NULL) {
            $this->load->model('question_list_model');
            $this->load->library('pagination');
            
            $search = "tags LIKE '%$tag%'";

            $config['total_rows'] = $this->db->where($search)->get('questions')->num_rows();
            $config['base_url'] = base_url(). 'questions/';
            $config['reuse_query_string'] = TRUE;
            $config['per_page'] = 10;
            $config['full_tag_open'] = '<div class = "pagination">';
            $config['full_tag_close'] = '</div>';
            $config['cur_tag_open'] = '<span class = "actived">';
            $config['cur_tag_close'] = '</span>';
            $page = isset($_GET['per_page']) ? $_GET['per_page'] : 0;

            $data['question'] = $this->question_list_model->get_tag_questions($tag, $config['per_page'], $page);

            $this->pagination->initialize($config);

            $this->load->view('templates/header');
            $this->load->view('pages/question_view',$data);
            $this->load->view('templates/footer');
        }
}
