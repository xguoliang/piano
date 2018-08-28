<?php

class Orders extends User_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Universal_model');
        $this->load->model('Orders_model');

    }

    public function ConfirmOrder()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $num = isset($_GET['num']) ? $_GET['num'] : '';
        $entity_type = isset($_GET['entity_type']) ? $_GET['entity_type'] : '';
        $com_id = isset($_GET['com_id']) ? $_GET['com_id'] : '';
        if ($entity_type == 1) {
            $one = $this->Universal_model->FetchOne('product', array('id' => $id));
        } else if ($entity_type == 2) {
            $one = $this->Universal_model->FetchOne('lesson', array('id' => $id));
        } else {
            $one = $this->Universal_model->FetchOne('activity', array('id' => $id));
        }
        $company = $this->Universal_model->FetchOne('company', array('id' => $com_id));
        $one['entity_type'] = $entity_type;
        $one['num'] = $num;
        $data['one'] = $one;
        $data['company'] = $company;
        $this->prender('phone/order/confirm_order', $data, array('title' => '确认订单', 'top' => 1));
    }

    public function MakeOrder()
    {
        if (isset($_SESSION['lerenuser'])) {
            $order_no = time() . mt_rand(0000, 9999);
            $order = $_POST['order'];
            $order_detail = $_POST['order_detail'];
            $order['user_id'] = $_SESSION['lerenuser']['id'];
            $order['order_no'] = $order['order_sign_no'] = $order_no;
            $order['add_time'] = date("Y-m-d H:i:s", time());
            $this->db->trans_start();
            $id = $this->Universal_model->SaveOne('orders', 'id', array('id' => '', 'save' => $order));
            $order_detail['order_id'] = $id;
            $this->Universal_model->SaveOne('orders_detail', 'id', array('id' => '', 'save' => $order_detail));
            $this->db->trans_complete();
            $res = array('status' => 1, 'order_sign_no' => $order_no);
        } else {
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }


    //删除订单
    public function DeleteOrder()
    {
        if (isset($_SESSION['lerenuser'])) {
            $id = $_POST['id'];
            $this->db->set('is_delete', 1)->where('id', $id)->update('orders');
            $res = array('status' => 1);
        } else {
            $res = array('status' => 2);
        }
        echo json_encode($res);

    }

    public function MyOrdersType()
    {
        if (isset($_SESSION['lerenuser'])) {
            $this->prender('phone/order/order_type', $data, array('title' => '我的订单', 'top' => 1));
        } else {
            echo "<script>alert('登录失效!');window.location.href='" . base_url() . "User/Login/PLogin'</script>";
        }
    }

    public function MyOrders()
    {
        if (isset($_SESSION['lerenuser'])) {
            $entity_type = $_GET['entity_type'];
            $data['entity_type'] = $entity_type;
            if(isset($_SESSION['lerenuser']['roler'])){
                if($_SESSION['lerenuser']['roler'] == 1){
                    $company = $this->Universal_model->FetchOne('company',array('user_id' => $_SESSION['lerenuser']['id']));
                    $data['company'] = $company;
                }
                if($_SESSION['lerenuser']['roler'] == 1){
                    $this->prender('phone/order/com_orders', $data, array('title' => '我的订单'));
                }else{
                    $this->prender('phone/order/my_orders', $data, array('title' => '我的订单'));
                }
            }else{
                $this->prender('phone/order/my_orders', $data, array('title' => '我的订单'));
            }
        } else {
            echo "<script>alert('登录失效!');window.location.href='" . base_url() . "User/Login/PLogin'</script>";
        }
    }

    public function GetMyOrders()
    {
        if (isset($_SESSION['lerenuser'])) {
            $limit = isset($_POST['limit']) ? $_POST['limit'] : '';
            $offset = isset($_POST['page']) ? ($_POST['page'] - 1) * $limit : 0;
            $user_id = $_SESSION['lerenuser']['id'];
            $entity_type = isset($_POST['entity_type']) ? $_POST['entity_type'] : 1;
            $status = isset($_POST['status']) ? $_POST['status'] : 1;
            $data = $this->Orders_model->GetMyOrdersWithProInfo($offset, $limit, $user_id, $entity_type, $status);
            $res = array();
            $exists = array();
            foreach ($data as $k => $v) {
                if (in_array($v['order_id'], $exists)) {
                    array_push($res[$v['order_id']]['details'], $v);
                } else {
                    $res[$v['order_id']] = array(
                        'id' => $v['order_id'],
                        'com_id' => $v['com_id'],
                        'com_name' => $v['com_name'],
                        'amount' => $v['amount'],
                        'status' => $v['status'],
                        'is_evaluate' => $v['is_evaluate'],
                        'details' => array(
                            '0' => $v
                        )
                    );
                    array_push($exists, $v['order_id']);
                }
            }
            $res = array_merge($res);
        } else {
            $res = array();
        }
        echo json_encode($res);
    }

    public function GetComOrders()
    {
        if (isset($_SESSION['lerenuser'])) {
            $limit = isset($_POST['limit']) ? $_POST['limit'] : '';
            $offset = isset($_POST['page']) ? ($_POST['page'] - 1) * $limit : 0;
            $user_id = $_SESSION['lerenuser']['id'];
            $company = $this->Universal_model->FetchOne('company',array('user_id' => $user_id));
            $com_id = $company['id'];
            $entity_type = isset($_POST['entity_type']) ? $_POST['entity_type'] : 1;
            $status = isset($_POST['status']) ? $_POST['status'] : 1;
            $data = $this->Orders_model->GetComOrdersWithProInfo($offset, $limit, $com_id, $entity_type, $status);
            $res = array();
            $exists = array();
            foreach ($data as $k => $v) {
                if (in_array($v['order_id'], $exists)) {
                    array_push($res[$v['order_id']]['details'], $v);
                } else {
                    $res[$v['order_id']] = array(
                        'id' => $v['order_id'],
                        'user_id' => $v['com_id'],
                        'user_name' => $v['user_name'],
                        'amount' => $v['amount'],
                        'status' => $v['status'],
                        'details' => array(
                            '0' => $v
                        )
                    );
                    array_push($exists, $v['order_id']);
                }
            }
            $res = array_merge($res);
        } else {
            $res = array();
        }
        echo json_encode($res);
    }

    public function OrderEvaluate()
    {
        if (isset($_SESSION['lerenuser'])) {
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $order = $this->Universal_model->FetchOne('orders',array('id' => $id));
            $data['order_id'] = $id;
            $detail = $this->Orders_model->IdGetOrderDetail($id,$order['entity_type']);
            $data['detail'] = $detail;
            $this->prender('phone/order/order_evaluate', $data, array('title' => '发表评价'));
        } else {
            echo '<script>alert("登录失效!");window.location.href="' . base_url() . 'User/Login/PLogin"</script>';
        }
    }

    public function SaveEvaluate()
    {
        if(isset($_SESSION['lerenuser'])){
            $save = $_POST['save'];
            foreach($save as $k=>$v){
                $save[$k]['add_time'] =  date("Y-m-d H:i:s",time());
            }
            $this->db->trans_start();
            $this->Universal_model->SaveData('evaluate',$save);
            $this->db->where('id',$_POST['id'])->update('orders',array('is_evaluate' => 1));
            $this->db->trans_complete();
            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

    public function OrderDetail()
    {
        if(isset($_SESSION['lerenuser'])){
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $data['order'] = $this->Universal_model->FetchOne('orders',array('id' => $id));
            $data['details'] = $this->Orders_model->IdGetOrderDetail($id,$data['order']['entity_type']);
            if(isset($_SESSION['lerenuser']['roler'])){
                if($_SESSION['lerenuser']['roler'] == 1){
                    $this->prender('phone/order/seller_order_detail',$data,array('title' => '订单详情'));
                }else{
                    $this->prender('phone/order/order_detail',$data,array('title' => '订单详情'));
                }
            }else{
                $this->prender('phone/order/order_detail',$data,array('title' => '订单详情'));
            }
        }else{
            echo '<script>alert("登录失效，请重新登录！");window.location.href="'.base_url().'User/Login/Plogin"</script>';
        }

    }

    public function SaveService()
    {
        if(isset($_SESSION['lerenuser'])){
            $post = $_POST;
            $post['save']['add_time'] = date("Y-m-d H:i:s",time());
            $this->Universal_model->SaveOne('service','id',$post);
            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

    public function ResetOrderNo()
    {
        if(isset($_SESSION['lerenuser'])){
            $order_no = time().mt_rand(0000,9999);
            $id = $_POST['id'];
            $this->db->set('order_sign_no',$order_no)->where('id',$id)->update('orders');
            $res = array('status' => 1,'order_sign_no' => $order_no);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

    public function SaveStatus()
    {
        if(isset($_SESSION['lerenuser'])){
            $this->Universal_model->SaveOne('orders','id',$_POST);

            $res = array('status' => 1);
        }else{
            $res= array('status' => 2);
        }
        echo json_encode($res);
    }
}

?>