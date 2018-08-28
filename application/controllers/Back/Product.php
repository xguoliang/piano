<?php

class Product extends Back_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Develop_model');
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function ProductList() {
        $data = array();
        $this->render('back/product/productlist', $data, array('title' => '商品管理', 'index_mod' => 1));
    }

    public function FetchCount() {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchData('view_company_instrument_brand', $equal, $like);
        echo json_encode($res);
    }

    public function AddOne() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $equal = array('id' => $id);
        $one = $this->Universal_model->FetchOne('product', $equal);
        $data['one'] = $one;
        $data['brand'] = $this->Develop_model->GetResult('brand', array('is_delete' => 0));
        $data['instrument'] = $this->Develop_model->GetResult('instrument', array('is_delete' => 0));
        $this->render('back/product/addproduct', $data, array('title' => '编辑商品', 'index_mod' => 1));
    }

    public function SaveOne() {
        if (isset($_SESSION['back_user'])) {
            if ($_POST['id'] == '') {
                $_POST['save']['add_time'] = date("Y-m-d H:i:s", time());
                $_POST['save']['com_id'] = $_SESSION['back_user']['com_id'];
            }
            if (isset($_POST['save']['img'])) {
                $_POST['save']['coverimg'] = explode(',', $_POST['save']['img'])[0];
            }
            $this->Universal_model->SaveOne('product', 'id', $_POST);
            $res = array('status' => 1, 'msg' => '保存成功!');
        } else {
            $res = array('status' => 2, 'msg' => '登录失效，请重新登陆后操作!');
        }
        echo json_encode($res);
    }

}

?>