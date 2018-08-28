<?php

class Cart extends User_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Cart_model');
        $this->load->model('Universal_model');

    }

    public function MyCart()
    {
        if (isset($_SESSION['lerenuser'])) {
            $this->prender('phone/cart/my_cart', $data, array('title' => '购物车'));
        } else {
            echo "<script>alert('登录失效，请重新登录！')</script>";
            exit;
        }
    }

    public function FetchMyCartProduct()
    {
        if (isset($_SESSION['lerenuser'])) {
            $entity_type = isset($_POST['entity_type']) ? $_POST['entity_type'] : 1;
            $limit = isset($_POST['limit']) ? $_POST['limit'] : 5;
            $offset = ($_POST['page'] - 1) * $limit;
            $data = $this->Cart_model->GetCartProduct($entity_type, $offset, $limit);
            $res = array();
            $exists = array();
            foreach ($data as $k => $v) {
                if ($entity_type == 1) {
                    if (in_array($v['com_id'], $exists)) {
                        array_push($res[$v['com_id']]['details'], $v);
                    } else {
                        $res[$v['com_id']] = array(
                            'com_id' => $v['com_id'],
                            'com_name' => $v['com_name'],
                            'details' => array()
                        );
                        array_push($res[$v['com_id']]['details'], $v);
                        array_push($exists, $v['com_id']);
                    }
                } else {
                    if (in_array($v['company_id'], $exists)) {
                        array_push($res[$v['company_id']]['details'], $v);
                    } else {
                        $res[$v['com_id']] = array(
                            'com_id' => $v['company_id'],
                            'com_name' => $v['name'],
                            'details' => array(
                                '0' => $v
                            )
                        );
                        array_push($res[$v['company_id']]['details'], $v);
                        array_push($exists, $v['company_id']);
                    }
                }
            }
        } else {
            $res = array();
        }
        $res = array_merge($res);
        echo json_encode($res);
    }

    public function SaveCart()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $sum = isset($_POST['sum']) ? $_POST['sum'] : 1;
        if (isset($_SESSION['lerenuser'])) {
            if ($sum == 1) {
                $this->db->set('num', 'num + 1', false)->where('id', $id)->update('cart');
            } else {
                $this->db->set('num', 'num - 1', false)->where('id', $id)->update('cart');
            }
            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }


    //删除购物车
    public function DeleteCart()
    {
        if(isset($_SESSION['lerenuser'])){
            $ids = isset($_POST['ids']) ? $_POST['ids'] : array();
            $this->db->where_in('id',$ids)->delete('cart');
            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }


    public function ConfirmOrder()
    {
        $cart_id = isset($_GET['cart_id']) ? explode(',',$_GET['cart_id']) : '';
        $entity_type = $_GET['entity_type'];
        $data = $this->Cart_model->GetCartInIds($cart_id,$entity_type);
        $res = array();
        $exists = array();
        foreach ($data as $k => $v) {
            if ($entity_type == 1) {
                if (in_array($v['com_id'], $exists)) {
                    array_push($res[$v['com_id']]['details'], $v);
                } else {
                    $res[$v['com_id']] = array(
                        'com_id' => $v['com_id'],
                        'com_name' => $v['com_name'],
                        'entity_type' => $entity_type,
                        'details' => array()
                    );
                    array_push($res[$v['com_id']]['details'], $v);
                    array_push($exists, $v['com_id']);
                }
            } else {
                if (in_array($v['company_id'], $exists)) {
                    array_push($res[$v['company_id']]['details'], $v);
                } else {
                    $res[$v['com_id']] = array(
                        'com_id' => $v['company_id'],
                        'com_name' => $v['name'],
                        'entity_type' => $entity_type,
                        'details' => array(
                            '0' => $v
                        )
                    );
                    array_push($res[$v['company_id']]['details'], $v);
                    array_push($exists, $v['company_id']);
                }
            }
        }
        $data['orders'] = $res;
        $this->prender('phone/cart/confirm_order', $data, array('title' => '确认订单','top' => 1));
    }


    //生成多张订单
    public function MakeOrder()
    {
        if(isset($_SESSION['lerenuser'])){
            $orders = $_POST['orders'];
            $user_name = $_POST['user_name'];
            $phone = $_POST['phone'];
            $save = array();
            $order_no = time() . mt_rand(0000,9999);
            $add_time = date("Y-m-d H:i:s",time());
            foreach($orders as $k=>$v){
                //主订单
                $save[$k]['user_id'] = $_SESSION['lerenuser']['id'];
                $save[$k]['company_id'] = $v['com_id'];
                $save[$k]['order_no'] = $order_no;
                $save[$k]['order_sign_no'] = $order_no;
                $save[$k]['entity_type'] = $v['entity_type'];
                $save[$k]['price'] = 0;
                $save[$k]['user_name'] = $user_name;
                $save[$k]['phone'] = $phone;
                $save[$k]['status'] = 1;
                $save[$k]['is_evaluate'] = 0;
                $save[$k]['add_time'] = $add_time;
                $save[$k]['pay_time'] = '';
                $save[$k]['is_delete'] = 0;
                //副订单
                foreach($v['details'] as $x=>$y){
                    $this->db->where('id',$y['cid'])->delete('cart');
                    $save[$k]['details'][$x]['entity_id'] = $y['id'];
                    $save[$k]['details'][$x]['price'] = $y['price'];
                    $save[$k]['details'][$x]['num'] = $y['num'];
                    $save[$k]['price'] += $y['price'] * $y['num'];
                }
            }

            $this->db->trans_start();
                foreach($save as $k=>$v){
                    $detail_save = $save[$k]['details'];
                    unset($save[$k]['details']);
                    $orders_save = $save[$k];
                    $id = $this->Universal_model->SaveOne('orders','id',array('id' => '','save' => $orders_save));
                    foreach($detail_save as $x=>$y){
                        $detail_save[$x]['order_id'] = $id;
                    }
                    $this->Universal_model->SaveData('orders_detail',$detail_save);
                }
            $this->db->trans_complete();
            $res = array('status' => 1,'order_sign_no' => $order_no);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }
}

?>