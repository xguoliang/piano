<?php

class Banner extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function BannerList()
    {
        $data = array();
        $this->render('admin/banner/bannerlist', $data, array('title' => '轮播管理', 'index_pmod' => 9, 'index_mod' => 1));
    }

    public function FetchCount()
    {
        $res = $this->Universal_model->FetchCount('banner');
        echo $res;
    }

    public function FetchPageData()
    {
        $limit = $_POST['limit'];
        $offset = $limit  * ($_POST['page'] - 1);
        $res = $this->Universal_model->FetchPageData('banner',$offset,$limit);
        echo json_encode($res);
    }

    public function AddOne()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if ($id != '') {
            $data['one'] = $this->Universal_model->FetchOne('banner',array('id' => $id));
        }
        $this->render('admin/banner/addone', $data, array('title' => '编辑轮播图', 'index_pmod' => 9, 'index_mod' => 1));
    }

    public function SaveOne()
    {
        if(isset($_SESSION['piano_admin'])){
            $this->Universal_model->SaveOne('banner','id',$_POST);
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
            $this->Universal_model->DeleteOne('banner',$equal);
            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }
}

?>