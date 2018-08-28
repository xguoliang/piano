<?php

class Message extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Universal_model');
        $this->is_login();
    }

    public function MessageList() {
        $this->prender('phone/message/message_list', $data, array('title' => '消息'));
    }

    public function SelectMessage() {
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('message', array('user_id' => $_SESSION['lerenuser']['id']), 'add_time', 'desc', $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function MessageDetail() {
        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('message', array('id' => $id));
        $this->Develop_model->UpdateTable('message', 'id', $id, array('is_read' => 1));
        $this->prender('phone/message/message_detail', $data, array('title' => '消息'));
    }

    public function ReadMessage()
    {
        if(isset($_SESSION['lerenuser'])){
            $this->Universal_model->SaveOne('message','id',$_POST);
            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);

        }
        echo json_encode($res);
    }
}

?>