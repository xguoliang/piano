<?php

class Recommend extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function RecommendList()
    {
        $data = array();
        $this->render('admin/recommend/recommendlist', $data, array('title' => '推荐管理', 'index_pmod' => 9, 'index_mod' => 5));
    }

    public function FetchCount()
    {
        $res = $this->Universal_model->FetchCount('recommend');
        echo $res;
    }

    public function FetchPageData()
    {
        $limit = $_POST['limit'];
        $offset = $limit  * ($_POST['page'] - 1);
        $res = $this->Universal_model->FetchPageData('recommend',$offset,$limit);
        echo json_encode($res);
    }

    public function AddOne()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if ($id != '') {
            $data['one'] = $this->Universal_model->FetchOne('recommend');
        }
        $this->render('admin/recommend/addone', $data, array('title' => '编辑推荐', 'index_pmod' => 9, 'index_mod' =>5));
    }

    public function SaveOne()
    {
        if(isset($_SESSION['piano_admin'])){
            $this->Universal_model->SaveOne('recommend','id',$_POST);
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
            $this->Universal_model->DeleteOne('recommend',$equal);
            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }
}

?>