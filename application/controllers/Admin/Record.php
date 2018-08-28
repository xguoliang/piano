<?php

class Record extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function RecordList0()
    {
        $data = array();
        $this->render('admin/record/recordlist0', $data, array('title' => '录音制作', 'index_pmod' => 6, 'index_mod' => 1));
    }

    public function RecordList1()
    {
        $data = array();
        $this->render('admin/record/recordlist1', $data, array('title' => '录影制作', 'index_pmod' => 6, 'index_mod' => 2));
    }

    public function FetchCount()
    {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchCount('record_room', $equal, $like);
        echo json_encode($res);
    }

    public function FetchPageData()
    {
        $limit = $_POST['limit'];
        $offset = $limit * ($_POST['page'] - 1);
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchPageData('record_room', $offset, $limit, $equal, $like);
        echo json_encode($res);
    }

    public function SaveOne()
    {
        if (isset($_SESSION['piano_admin'])) {
            $this->Universal_model->SaveOne('record_room', 'id', $_POST);
            $res = array('status' => 1, 'msg' => '保存成功!');
        } else {
            $res = array('status' => 2, 'msg' => '登录失效，请重新登陆后操作!');
        }
        echo json_encode($res);
    }

    public function DeleteOne()
    {
        if (isset($_SESSION['piano_admin'])) {
            $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
            $this->Universal_model->DeleteOne('record_room', $equal);
            $res = array('status' => 1,'msg' => '删除成功!');
        } else {
            $res = array('status' => 2,'msg' => '登录失效，请重新登录后操作!');
        }
        echo json_encode($res);
    }
}

?>