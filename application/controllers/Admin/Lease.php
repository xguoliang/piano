<?php

class Lease extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function LeaseList()
    {
        $data = array();
        $this->render('admin/lease/leaselist', $data, array('title' => '设备租赁','index_pmod' => 5, 'index_mod' => 1));
    }

    public function FetchCount()
    {
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $this->db->select('count(0)')
            ->from('lease as a')
            ->join('instrument as b','a.instrument_id = b.id','left');
        foreach($like as $k=>$v){
            $this->db->like('a.'.$k,$v);
        }
        $res = $this->db->get()->row_array()['count(0)'];
        echo json_encode($res);
    }

    public function FetchPageData()
    {
        $limit = $_POST['limit'];
        $offset = $limit * ($_POST['page'] - 1);
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $this->db->select('a.*,b.name as ins_name')
            ->from('lease as a')
            ->join('instrument as b','a.instrument_id = b.id','left');
        foreach($like as $k=>$v){
            $this->db->like('a.'.$k,$v);
        }
        $res = $this->db->limit($limit,$offset)->get()->result_array();
        echo json_encode($res);
    }

    public function AddOne()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $equal = array('id' => $id);
        $one = $this->Universal_model->FetchOne('company',$equal);
        if($one == null){
            echo "<script>alert('参数错误!')</script>";
            echo "window.history.go(-1)";
        }else{
            $data['one'] = $one;
            $this->render('admin/lease/addone',$data,array('title' => '设备租赁','index_pmod' => 5,'index_mod' => 1));
        }
    }
}

?>