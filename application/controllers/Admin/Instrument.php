<?php

class Instrument extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function InstrumentList() {
        $data = array();
        $this->render('admin/instrument/instrumentlist', $data, array('title' => '乐器管理', 'index_pmod' => 2, 'index_mod' => 2));
    }

    public function FetchCount() {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchCount('instrument', $equal, $like);
        echo json_encode($res);
    }

    public function FetchPageData() {
        $limit = $_POST['limit'];
        $offset = $limit * ($_POST['page'] - 1);
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $order = array(
            'sort' => 'asc',
        );
        $res = $this->Universal_model->FetchPageData('instrument', $offset, $limit, $equal, $like, $order);
        echo json_encode($res);
    }

    public function AddOne() {
        if (isset($_GET['id'])) {
            $data['one'] = $this->Develop_model->GetRow('instrument', array('id' => $_GET['id']));
        }
        $this->render('admin/instrument/addproduct', $data, array('title' => '编辑乐器', 'index_pmod' => 2, 'index_mod' => 2));
    }

    public function SaveOne() {
        if (isset($_SESSION['piano_admin'])) {
            $this->Universal_model->SaveOne('instrument', 'id', $_POST);
            $res = array('status' => 1, 'msg' => '保存成功!');
        } else {
            $res = array('status' => 2, 'msg' => '登录失效，请重新登陆后操作!');
        }
        echo json_encode($res);
    }

}

?>