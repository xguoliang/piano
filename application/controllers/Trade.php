<?php

class Trade extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    /*
     *
     */
    public function WebList()
    {
        $data = array();
        $this->render('trade/web_list',$data,array('title' => '网站商城','index_module_id' => 6));
    }

    public function ShowSpList()
    {
        $data = array();
        $this->render('trade/showsp_list',$data,array('title' => '展示小程序','index_module_id' => 7));
    }

    public function ShopSpList()
    {
        $data = array();
        $this->render('trade/shopsp_list',$data,array('title' => '商城小程序','index_module_id' => 8));
    }

    /*
     *
     */
    public function FetchTradeCount()
    {
        $equal = isset($_POST['equal'])?$_POST['equal']:array();
        $like = isset($_POST['like'])?$_POST['like']:array();
        $this->db->select('*')
            ->from('trade as t')
            ->join('client as c','t.tra_cli_id = c.cli_id','left');
        foreach($like as $k=>$v){
            $this->db->like($k,$v);
        }
        foreach($equal as $k=>$v){
            $this->db->where($k,$v);
        }
        $res = $this->db->order_by('t.tra_created_at','desc')->get()->result_array();
        echo json_encode($res);
    }

    /*
      *
      */
    public function SaveTrade()
    {
        if(isset($_SESSION['zx_crm_user'])){
            $this->Universal_model->SaveOne('trade','tra_id',$_POST);
            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }
}
?>