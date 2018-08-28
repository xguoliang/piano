<?php

class Recommend extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Universal_model');
    }

    public function RecommendList() {
        $this->prender('phone/recommend/recommend_list', $data, array('title' => '精彩活动'));
    }

    public function getRecommend()
    {
        $limit = $_POST['limit'];
        $offset = $_POST['limit'] * ($_POST['page'] - 1);
        $res = $this->Universal_model->FetchPageData('recommend',$offset,$limit);
        echo json_encode($res);
    }
}

?>