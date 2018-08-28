<?php

class Business extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function BusinessList() {
        $this->prender('phone/business/business_list', $data, array('title' => '演出买卖'));
    }

    public function SelectBusiness() {
        $type = $_POST['type'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        if ($type == 1) {
            $data = $this->Develop_model->GetAllOrderLimitResult('view_business_bandsman', 'price', 'desc', $pagesize, $offset);
        } else {
            $data = array();
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function BusinessDetail() {
        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('view_business_bandsman', array('id' => $id));
        $this->prender('phone/business/business_detail', $data, array('title' => '演出买卖'));
    }

}

?>