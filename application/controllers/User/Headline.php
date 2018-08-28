<?php

class Headline extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function HeadlineList() {
        $this->prender('phone/headline/headline_list', $data, array('title' => '琴行头条'));
    }

    public function SelectHeadline() {
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetAllOrderLimitResult('headline', 'add_time', 'desc', $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PHeadlineDetail() {
        $id = $_GET['id'];
        $data['one'] = $this->Develop_model->GetRow('headline', array('id' => $id));
        $this->prender('phone/headline/headline_detail', $data, array('title' => $data['one']['title'],'top' => 1));
    }
}

?>