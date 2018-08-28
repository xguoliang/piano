<?php

class Vip extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function VipList()
    {
        $data = array();
        $this->render('admin/vip/viplist', $data, array('title' => '会员权益', 'index_pmod' => 9, 'index_mod' => 3));
    }

    public function FetchCount()
    {
        $res = $this->Universal_model->FetchCount('vip');
        echo $res;
    }

    public function FetchPageData()
    {
        $limit = $_POST['limit'];
        $offset = $limit  * ($_POST['page'] - 1);
        $res = $this->Universal_model->FetchPageData('vip',$offset,$limit);
        echo json_encode($res);
    }

    public function AddOne()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if ($id != '') {
            $data['one'] = $this->Universal_model->FetchOne('vip');
        }
        $this->render('admin/vip/addone', $data, array('title' => '编辑会员权益', 'index_pmod' => 9, 'index_mod' => 3));
    }

    public function SaveOne()
    {
        if(isset($_SESSION['piano_admin'])){
            $this->Universal_model->SaveOne('vip','id',$_POST);
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
            $this->Universal_model->DeleteOne('vip',$equal);
            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }
}

?>