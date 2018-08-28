<?php

class Product extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function ProductList() {
        $data = array();
        $this->render('admin/product/productlist', $data, array('title' => '商品管理', 'index_pmod' => 2, 'index_mod' => 1));
    }

    public function FetchCount() {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchCount('view_company_instrument_brand', $equal, $like);
        echo json_encode($res);
    }

    public function FetchPageData() {
        $limit = $_POST['limit'];
        $offset = $limit * ($_POST['page'] - 1);
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $order = array(
            'sort' => 'asc',
            'add_time' => 'desc'
        );
        $res = $this->Universal_model->FetchPageData('view_company_instrument_brand', $offset, $limit, $equal, $like, $order);
        echo json_encode($res);
    }

    public function AddOne() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $equal = array('id' => $id);
        $one = $this->Universal_model->FetchOne('product', $equal);
        if ($one == null) {
            echo "<script>alert('参数错误!')</script>";
            echo "window.history.go(-1)";
        } else {
            $data['one'] = $one;
            $data['brand'] = $this->Develop_model->GetResult('brand', array('is_delete' => 0));
            $data['company'] = $this->Universal_model->FetchData('company');
            $this->render('admin/product/addproduct', $data, array('title' => '查看商品', 'index_pmod' => 2, 'index_mod' => 1));
        }
    }

    public function SaveOne() {
        if (isset($_SESSION['piano_admin'])) {
            if ($_POST['id'] == '') {
                $_POST['save']['add_time'] = date("Y-m-d H:i:s");
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