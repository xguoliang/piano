<?php

class SiteLease extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function SiteLeaseList()
    {
        $data = array();
        $this->render('admin/sitelease/siteleaselist', $data, array('title' => '场地租赁','index_pmod' => 5, 'index_mod' => 2));
    }

    public function FetchCount()
    {
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $this->db->select('count(0)')
            ->from('site_lease as a')
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
            ->from('site_lease as a')
            ->join('instrument as b','a.instrument_id = b.id','left');
        foreach($like as $k=>$v){
            $this->db->like('a.'.$k,$v);
        }
        $res = $this->db->limit($limit,$offset)->get()->result_array();
        $type_array = array(
            '1' => '排练场',
            '2' => '演出场',
            '3' => '相亲角',
            '4' => '弄堂里',
            '5' => '相亲角'
        );
        foreach($res as $k=>$v){
            $res[$k]['type'] = $type_array[$v['type']];
        }
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
            $this->render('admin/sitelease/addone',$data,array('title' => '场地租赁','index_pmod' => 5,'index_mod' => 2));
        }
    }
}

?>