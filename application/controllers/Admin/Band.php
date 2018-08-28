<?php

class Band extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function BandList()
    {
        $data = array();
        $this->render('admin/band/bandlist', $data, array('title' => '乐队管理', 'index_pmod' => 4, 'index_mod' => 2));
    }

    public function FetchCount()
    {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchCount('band', $equal, $like);
        echo json_encode($res);
    }

    public function FetchPageData()
    {
        $limit = $_POST['limit'];
        $offset = $limit * ($_POST['page'] - 1);
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $this->db->select('a.*,b.name as bandsman_name')
            ->from('band as a')
            ->join('bandsman as b','a.bandsman_id = b.id','left');
        foreach($like as $k=>$v){
            $this->db->like('a.'.$k,$v);
        }
        $res = $this->db->limit($limit,$offset)->get()->result_array();
        echo json_encode($res);
    }

    public function SaveOne()
    {
        if (isset($_SESSION['piano_admin'])) {
            $this->Universal_model->SaveOne('band', 'id', $_POST);
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
            $this->Universal_model->DeleteOne('band', $equal);
            $res = array('status' => 1,'msg' => '删除成功!');
        } else {
            $res = array('status' => 2,'msg' => '登录失效，请重新登录后操作!');
        }
        echo json_encode($res);
    }
}

?>