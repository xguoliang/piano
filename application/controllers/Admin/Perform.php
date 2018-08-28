<?php

class Perform extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function PerformList()
    {
        $data = array();
        $this->render('admin/perform/performlist', $data, array('title' => '演出管理', 'index_pmod' => 8, 'index_mod' => 1));
    }

    public function FetchCount()
    {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchCount('perform', $equal, $like);
        echo json_encode($res);
    }

    public function FetchPageData()
    {
        $limit = $_POST['limit'];
        $offset = $limit * ($_POST['page'] - 1);
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $order = array(
            'add_time' => 'desc',
        );
        $this->db->select('a.*,b.name as com_name')
            ->from('perform as a')
            ->join('company as b','a.company_id = b.id','left');
        foreach($like as $k=>$v){
            $this->db->like('a.'.$k,$v);
        }
        foreach($equal as $k=>$v){
            $this->db->where($k,$v);
        }
        $res = $this->db->limit($limit,$offset)->get()->result_array();
        $type_array = array(
            '1' => '酒吧助唱',
            '2' => '咖啡厅',
            '3' => '大型演唱会',
            '4' => '节日宣传',
            '5' => '乐队演出'
        );
        foreach($res as $k=>$v){
            $res[$k]['type'] = $type_array[$v['type']];
        }
        echo json_encode($res);
    }

    public function SaveOne()
    {
        if (isset($_SESSION['piano_admin'])) {
            $this->Universal_model->SaveOne('perform','id',$_POST);
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
            $this->Universal_model->DeleteOne('perform', $equal);
            $res = array('status' => 1,'msg' => '删除成功!');
        } else {
            $res = array('status' => 2,'msg' => '登录失效，请重新登录后操作!');
        }
        echo json_encode($res);
    }
}

?>