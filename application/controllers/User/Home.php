<?php

class Home extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Universal_model');
    }

    public function Index()
    {
        $data['channel'] = $this->Universal_model->FetchPageData('channel',0,6,array(),array(),array('sort' => 'asc'));
        $data['recommend'] = $this->Universal_model->FetchPageData('recommend',0,6,array(),array(),array('sort' => 'asc'));
        $data['push'] = $this->Universal_model->FetchPageData('push',0,3,array(),array(),array('sort' => 'asc'));
        $data['banner'] = $this->Universal_model->FetchData('banner',array(),array(),array('sort' => 'asc'));
        $this->prender('phone/home/index', $data, array('title' => '首页'));
    }
}

?>