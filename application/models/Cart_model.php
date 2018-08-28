<?php

class Cart_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function GetCartProduct($entity_type, $offset, $limit)
    {
        if($entity_type == 1){
            //商品
            $res = $this->db->select('com.name as com_name,c.num,c.id as cid,p.*')
                ->from('cart as c')
                ->join('product as p','c.entity_id = p.id','left')
                ->join('company as com','p.com_id = com.id','left')
                ->where('c.entity_type',1)
                ->where('c.user_id',$_SESSION['lerenuser']['id'])
                ->limit($limit,$offset)
                ->get()->result_array();
        }else if($entity_type == 2){
            //课程
            $res = $this->db->select('com.name as com_name,c.num,c.id as cid,l.*')
                ->from('cart as c')
                ->join('lesson as l','c.entity_id = l.id','left')
                ->join('company as com','l.company_id = com.id','left')
                ->where('c.entity_type',2)
                ->where('c.user_id',$_SESSION['lerenuser']['id'])
                ->limit($limit,$offset)
                ->get()->result_array();
        }else{
            //活动
            $res = $this->db->select('com.name as com_name,c.num,c.id as cid,a.*')
                ->from('cart as c')
                ->join('activity as a','c.entity_id = a.id','left')
                ->join('company as com','a.company_id = com.id','left')
                ->where('c.entity_type',2)
                ->where('c.user_id',$_SESSION['lerenuser']['id'])
                ->limit($limit,$offset)
                ->get()->result_array();
        }
        return $res;
    }

    public function GetCartInIds($cart_id,$entity_type)
    {
        if($entity_type == 1){
            $res = $this->db->select('com.name as com_name,c.num,c.id as cid,p.*')
                ->from('cart as c')
                ->join('product as p','c.entity_id = p.id','left')
                ->join('company as com','p.com_id = com.id','left')
                ->where('c.entity_type',1)
                ->where_in('c.id',$cart_id)
                ->get()->result_array();
        }else if($entity_type == 2){
            $res = $this->db->select('com.name as com_name,c.num,c.id as cid,l.*')
                ->from('cart as c')
                ->join('lesson as l','c.entity_id = l.id','left')
                ->join('company as com','l.company_id = com.id','left')
                ->where('c.entity_type',2)
                ->where_in('c.id',$cart_id)
                ->get()->result_array();
        }else{
            //活动
            $res = $this->db->select('com.name as com_name,c.num,c.id as cid,a.*')
                ->from('cart as c')
                ->join('activity as a','c.entity_id = a.id','left')
                ->join('company as com','a.company_id = com.id','left')
                ->where('c.entity_type',2)
                ->where_in('c.id',$cart_id)
                ->get()->result_array();
        }
        return $res;
    }
}

?>