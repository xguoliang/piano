<?php
class Orders_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
    }

    public function GetMyOrdersWithProInfo($offset,$limit,$user_id,$entity_type,$status)
    {
        if($entity_type == 1){
            $this->db->select('*')->from('view_orders_detail_product');

            if($status != 0){
                $this->db->where('status', $status);
            }
            $this->db->where('entity_type',1);
            if($status == 3){
                $this->db->where('is_evaluate',0);
            }
            $data = $this->db->where('user_id',$user_id)->where('is_delete',0)->order_by('add_time','desc')->limit($limit,$offset)->get()->result_array();
        }else if($entity_type == 2){
            $this->db->select('*')->from('view_orders_detail_lesson');
            if($status != 0){
                $this->db->where('status', $status);
            }
            $this->db->where('entity_type',2);

            if($status == 3){
                $this->db->where('is_evaluate',0);
            }
            $data = $this->db->where('user_id',$user_id)->where('is_delete',0)->order_by('add_time','desc')->limit($limit,$offset)->get()->result_array();
        }else{
            $this->db->select('*')->from('view_orders_detail_activity');

            if($status != 0){
                $this->db->where('status', $status);
            }
            $this->db->where('entity_type',3);

            if($status == 3){
                $this->db->where('is_evaluate',0);
            }
            $data = $this->db->where('user_id',$user_id)->where('is_delete',0)->order_by('add_time','desc')->limit($limit,$offset)->get()->result_array();
        }
        return $data;
    }

    public function IdGetOrderDetail($id,$entity_type)
    {
        if($entity_type == 1){
            $this->db->select('*')->from('view_orders_detail_product');
            $data = $this->db->where('order_id',$id)->get()->result_array();
        }else if($entity_type == 2){
            $this->db->select('*')->from('view_orders_detail_lesson');
            $data = $this->db->where('order_id',$id)->get()->result_array();
        }else{
            $this->db->select('*')->from('view_orders_detail_activity');
            $data = $this->db->where('order_id',$id)->get()->result_array();
        }
        return $data;
    }

    public function GetComOrdersWithProInfo($offset,$limit,$com_id,$entity_type,$status)
    {
        if($entity_type == 1){
            $this->db->select('*')->from('view_orders_detail_product');
            if($status != 0){
                $this->db->where('status', $status);
            }
            $this->db->where('entity_type',1);

            if($status == 3){
                $this->db->where('is_evaluate',0);
            }
            $data = $this->db->where('com_id',$com_id)->where('is_delete',0)->order_by('add_time','desc')->limit($limit,$offset)->get()->result_array();
        }else if($entity_type == 2){
            $this->db->select('*')->from('view_orders_detail_lesson');
            if($status != 0){
                $this->db->where('status', $status);
            }
            $this->db->where('entity_type',2);

            if($status == 3){
                $this->db->where('is_evaluate',0);
            }
            $data = $this->db->where('company_id',$com_id)->where('is_delete',0)->order_by('add_time','desc')->limit($limit,$offset)->get()->result_array();
        }else{
            $this->db->select('*')->from('view_orders_detail_activity');
            if($status != 0){
                $this->db->where('status', $status);
            }
            $this->db->where('entity_type',3);

            if($status == 3){
                $this->db->where('is_evaluate',0);
            }
            $data = $this->db->where('company_id',$com_id)->where('is_delete',0)->order_by('add_time','desc')->limit($limit,$offset)->get()->result_array();
        }
        return $data;
    }
}
?>