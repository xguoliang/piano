<?php

class Perform extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function PerformList() {
        $data['area'] = $this->GetArea("perform", 1);
        $this->prender('phone/perform/perform_list', $data, array('title' => '各类演出'));
    }

    public function SelectPerform() {
        $area = $_POST['area'];
        $type = $_POST['type'];
        $time = $_POST['time'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Company_model->ListSelectPerform($area, $type, $time, $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PerformDetail() {
        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('perform', array('id' => $id));
        $this->prender('phone/perform/perform_detail', $data, array('title' => '演出详情'));
    }

}

?>