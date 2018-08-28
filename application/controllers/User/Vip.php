<?php

class Vip extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Universal_model');
    }

    public function VipList() {
        $this->prender('phone/vip/vip_list', $data, array('title' => '会员专享'));
    }

    public function getVip()
    {
        $limit = $_POST['limit'];
        $offset = $_POST['limit'] * ($_POST['page'] - 1);
        $res = $this->Universal_model->FetchPageData('vip',$offset,$limit);
        echo json_encode($res);
    }
}

?>