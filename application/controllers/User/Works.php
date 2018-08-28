<?php

class Works extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function WorksList() {
        $this->prender('phone/works/works_list', $data, array('title' => '音乐视频'));
    }

    public function SelectWorks() {
        $type = $_POST['type'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('works', array('type' => $type), 'add_time', 'desc', $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function MovieList() {
        $this->prender('phone/works/movie_list', $data, array('title' => '影音制作'));
    }

    public function SelectMovie() {
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('movie', array('is_delete' => 0), 'add_time', 'desc', $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function MovieDetail() {
        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('movie', array('id' => $id));
        $this->prender('phone/works/movie_detail', $data, array('title' => '影音制作'));
    }

}

?>