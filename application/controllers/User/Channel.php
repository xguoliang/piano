<?php

class Channel extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Universal_model');
    }

    public function ChannelList() {
        $this->prender('phone/channel/channel_list', $data, array('title' => '特色频道'));
    }

    public function getChannel()
    {
        $limit = $_POST['limit'];
        $offset = $_POST['limit'] * ($_POST['page'] - 1);
        $res = $this->Universal_model->FetchPageData('channel',$offset,$limit);
        echo json_encode($res);
    }
}

?>