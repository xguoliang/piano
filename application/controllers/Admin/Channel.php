<?php

class Channel extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function ChannelList()
    {
        $data = array();
        $this->render('admin/channel/channellist', $data, array('title' => '频道管理', 'index_pmod' => 9, 'index_mod' => 4));
    }

    public function FetchCount()
    {
        $res = $this->Universal_model->FetchCount('channel');
        echo $res;
    }

    public function FetchPageData()
    {
        $limit = $_POST['limit'];
        $offset = $limit  * ($_POST['page'] - 1);
        $res = $this->Universal_model->FetchPageData('channel',$offset,$limit);
        echo json_encode($res);
    }

    public function AddOne()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if ($id != '') {
            $data['one'] = $this->Universal_model->FetchOne('channel',array('id' => $id));
        }
        $this->render('admin/channel/addone', $data, array('title' => '编辑频道', 'index_pmod' => 9, 'index_mod' =>4));
    }

    public function SaveOne()
    {
        if(isset($_SESSION['piano_admin'])){
            $this->Universal_model->SaveOne('channel','id',$_POST);
            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

    public function DeleteOne()
    {
        if(isset($_SESSION['piano_admin'])){
            $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
            $this->Universal_model->DeleteOne('channel',$equal);
            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }
}

?>