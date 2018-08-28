<?php

class Headline extends Back_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function HeadlineList()
    {
        $data['instrument'] = $this->Universal_model->FetchData('instrument');
        $this->render('back/headline/headlinelist', $data, array('title' => '头条管理','index_mod' => 4));
    }

    public function FetchCount()
    {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchData('headline',$equal,$like);
        echo json_encode($res);
    }


    public function AddOne()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $equal = array('id' => $id);
        $one = $this->Universal_model->FetchOne('headline', $equal);
        $data['one'] = $one;
        $this->render('back/headline/addheadline', $data, array('title' => '编辑头条',  'index_mod' => 4));
    }

    public function SaveOne()
    {
        if (isset($_SESSION['back_user'])) {
            if ($_POST['id'] == '') {
                $_POST['save']['add_time'] = date("Y-m-d H:i:s",time());
                $_POST['save']['company_id'] = $_SESSION['back_user']['com_id'];
            }

            $this->Universal_model->SaveOne('headline','id',$_POST);
            $res = array('status' => 1, 'msg' => '保存成功!');
        } else {
            $res = array('status' => 2, 'msg' => '登录失效，请重新登陆后操作!');
        }
        echo json_encode($res);
    }

    public function DeleteOne()
    {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        if (isset($_SESSION['back_user'])) {
            $this->Universal_model->DeleteOne('headline', $equal);
            $res = array('status' => 1, 'msg' => '删除成功!');
        } else {
            $res = array('status' => 2, 'msg' => '登录失效，请重新登录后操作!');
        }
        echo json_encode($res);
    }
}

?>