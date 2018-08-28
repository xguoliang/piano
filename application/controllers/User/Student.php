<?php

class Student extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->is_login();
    }

    public function PStudentIndex() {
        $data['detail'] = $this->Develop_model->GetRow('student', array('user_id' => $_SESSION['lerenuser']['id']));
        if (!isset($data['detail']['id'])) {
            $this->Develop_model->InsertTable('student', array('user_id' => $_SESSION['lerenuser']['id'], 'name' => "", 'phone' => $_SESSION['lerenuser']['phone']));
            $data['detail'] = $this->Develop_model->GetRow('student', array('user_id' => $_SESSION['lerenuser']['id']));
        }
        $data['guanzhu'] = count($this->Bandsman_model->GetCollectBandAndBandsman($_SESSION['lerenuser']['id']));
        $data['collect_count'] = count($this->Develop_model->GetResult('collect', array('user_id' => $_SESSION['lerenuser']['id'])));
        $data['order_count'] = count($this->Develop_model->GetResult('orders', array('user_id' => $_SESSION['lerenuser']['id'])));
        $_SESSION['lerenuser']['student_id'] = $data['detail']['id'];
        $_SESSION['lerenuser']['roler'] = 4;
        $this->prender('phone/student/student_index', $data, array('title' => '个人'));
    }

    public function PChangeStudent() {
        $data['detail'] = $this->Develop_model->GetRow('student', array('user_id' => $_SESSION['lerenuser']['id']));
        $this->prender('phone/student/change_student', $data, array('title' => '信息编辑'));
    }

    public function UpdateStudent() {
        $data['headimg'] = str_replace(base_url(), "", $_POST['headimg']);
        $data['name'] = $_POST['name'];
        $data['phone'] = $_POST['phone'];
        $data['sex'] = $_POST['sex'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $this->Develop_model->UpdateTable('student', 'id', $_SESSION['lerenuser']['student_id'], $data);
        echo 1;
    }

    public function PMyCollect() {
        $this->prender('phone/collect/student_collect', $data, array('title' => '我的收藏'));
    }

    public function ProductCollect() {
        $this->prender('phone/collect/product_collect', $data, array('title' => '商品收藏'));
    }

    public function MyCollectProduct() {
        $this->SelectCollectProduct();
    }

    public function LessonCollect() {
        $this->prender('phone/collect/lesson_collect', $data, array('title' => '课程收藏'));
    }

    public function MyCollectLesson() {
        $this->SelectCollectLesson();
    }

    public function ActivityCollect() {
        $this->prender('phone/collect/activity_collect', $data, array('title' => '活动收藏'));
    }

    public function MyCollectActivity() {
        $this->SelectCollectActivity();
    }

    public function PerformCollect() {
        $this->prender('phone/collect/perform_collect', $data, array('title' => '演出收藏'));
    }

    public function MyCollectPerform() {
        $this->SelectCollectPerform();
    }

    public function LeaseCollect() {
        $this->prender('phone/collect/lease_collect', $data, array('title' => '设备租赁收藏'));
    }

    public function MyCollectLease() {
        $this->SelectCollectLease();
    }

    public function SiteLeaseCollect() {
        $this->prender('phone/collect/site_lease_collect', $data, array('title' => '场地租赁收藏'));
    }

    public function MyCollectSiteLease() {
        $this->SelectCollectSiteLease();
    }

    public function MovieCollect() {
        $this->prender('phone/collect/movie_collect', $data, array('title' => '影视制作收藏'));
    }

    public function MyCollectMovie() {
        $this->SelectCollectMovie();
    }

    public function StudentDeleteCollect() {
        $this->DeleteCollect();
    }

    public function PChooseOrderType() {
        $this->prender('phone/student/choose_order_type', $data, array('title' => '我的订单'));
    }

    public function PProductOrder() {
        $this->prender('phone/student/product_order', $data, array('title' => '商品订单'));
    }

    public function SelectProductOrder() {
        $status = $_POST['status'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        if ($status == 0) {
            $data = $this->Develop_model->GetOrderLimitResult('view_order_company', array('user_id' => $_SESSION['lerenuser']['id'], 'is_delete' => 0, 'entity_type' => 1), 'add_time', 'desc', $pagesize, $offset);
        }
        $order_id = array();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['detail'] = array();
            array_push($order_id, $data[$i]['id']);
        }
        $detail = $this->Order_model->OrderIdsUserGetOrderDetail($order_id);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($detail); $j++) {
                if ($data[$i]['id'] == $detail[$j]['order_id']) {
                    array_push($data[$i]['detail'], $detail[$j]);
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PProductOrderDetail() {
        $id = $_GET['id'];
        $data['order'] = $this->Develop_model->GetRow('orders', array('id' => $id));
        $data['detail'] = $this->Develop_model->GetResult('view_orders_detail_student', array('order_id' => $id));
        $this->prender('phone/student/product_order_detail', $data, array('title' => '订单详情'));
    }

    public function PLessonOrder() {
        $this->prender('phone/student/lesson_order', $data, array('title' => '课程订单'));
    }

    public function SelectLessonOrder() {
        $status = $_POST['status'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        if ($status == 0) {
            $data = $this->Develop_model->GetOrderLimitResult('view_order_company', array('user_id' => $_SESSION['lerenuser']['id'], 'is_delete' => 0, 'entity_type' => 2), 'add_time', 'desc', $pagesize, $offset);
        }
        $order_id = array();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['detail'] = array();
            array_push($order_id, $data[$i]['id']);
        }
        $detail = $this->Order_model->LessonOrderIdsUserGetOrderDetail($order_id);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($detail); $j++) {
                if ($data[$i]['id'] == $detail[$j]['order_id']) {
                    array_push($data[$i]['detail'], $detail[$j]);
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PLessonOrderDetail() {
        $id = $_GET['id'];
        $data['order'] = $this->Develop_model->GetRow('orders', array('id' => $id));
        $data['detail'] = $this->Develop_model->GetResult('view_orders_detail_student_lesson', array('order_id' => $id));
        $this->prender('phone/student/lesson_order_detail', $data, array('title' => '订单详情'));
    }

    public function PActivityOrder() {
        $this->prender('phone/student/activity_order', $data, array('title' => '活动订单'));
    }

    public function SelectActivityOrder() {
        $status = $_POST['status'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        if ($status == 0) {
            $data = $this->Develop_model->GetOrderLimitResult('view_order_company', array('user_id' => $_SESSION['lerenuser']['id'], 'is_delete' => 0, 'entity_type' => 3), 'add_time', 'desc', $pagesize, $offset);
        }
        $order_id = array();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['detail'] = array();
            array_push($order_id, $data[$i]['id']);
        }
        $detail = $this->Order_model->ActivityOrderIdsUserGetOrderDetail($order_id);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($detail); $j++) {
                if ($data[$i]['id'] == $detail[$j]['order_id']) {
                    array_push($data[$i]['detail'], $detail[$j]);
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PActivityOrderDetail() {
        $id = $_GET['id'];
        $data['order'] = $this->Develop_model->GetRow('orders', array('id' => $id));
        $data['detail'] = $this->Develop_model->GetResult('view_orders_detail_student_activity', array('order_id' => $id));
        $this->prender('phone/student/activity_order_detail', $data, array('title' => '订单详情'));
    }

    public function OrderEvaluate() {
        $id = $_GET['id'];
        $data['order'] = $this->Develop_model->GetRow('orders', array('id' => $id));
        if ($data['order']['is_evaluate'] == 0) {
            $data['detail'] = $this->Develop_model->GetResult('view_order_detail_student', array('order_id' => $id));
            $this->prender('phone/student/order_evaluate', $data, array('title' => '发表评论'));
        } else {
            echo '该订单已评价过';
        }
    }

    public function InsertEvaluate() {
        date_default_timezone_set('Asia/Shanghai');
        $add_time = (string) date("Y-m-d H:i:s");
        $id = $_POST['id'];
        $product_id = explode('&*', $_POST['product_id']);
        $star = explode('&*', $_POST['star']);
        $desc = explode('&*', $_POST['desc']);
        $img = explode('&*', $_POST['img']);
        $this->Order_model->InsertEvaluate($id, $product_id, $star, $desc, $img, $add_time);
        echo 1;
    }

    public function MyAddress() {
        $data['address'] = $this->Develop_model->GetOrderResult('address', array('user_id' => $_SESSION['lerenuser']['id']), 'is_default', 'desc');
        $this->prender('phone/student/my_address', $data, array('title' => '我的地址'));
    }

    public function EditAddress() {
        if (isset($_GET['id'])) {
            $data['id'] = $_GET['id'];
            $data['detail'] = $this->Develop_model->GetRow('address', array('id' => $data['id']));
        } else {
            $data['id'] = '';
        }
        if (isset($data['detail']) && $data['detail']['user_id'] != $_SESSION['lerenuser']['id']) {
            echo '你没有权限修改该地址';
            exit;
        } else {
            $this->prender('phone/student/edit_address', $data, array('title' => '编辑地址'));
        }
    }

    public function SaveAddress() {
        date_default_timezone_set('Asia/Shanghai');
        $id = $_POST['id'];
        $data['name'] = $_POST['name'];
        $data['phone'] = $_POST['phone'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['is_default'] = $_POST['is_default'];
        if ($data['is_default'] == 1) {
            $this->Develop_model->UpdateTable('address', 'user_id', $_SESSION['lerenuser']['id'], array('is_default' => 0));
        }
        if ($id == '') {
            $data['user_id'] = $_SESSION['lerenuser']['id'];
            $data['add_time'] = (string) date("Y-m-d H:i:s");
            $this->Develop_model->InsertTable('address', $data);
        } else {
            $this->Develop_model->UpdateTable('address', 'id', $id, $data);
        }
        echo 1;
    }

    public function ChangeDefault() {
        $id = $_POST['id'];
        $is_default = $_POST['is_default'];
        if ($is_default == 1) {
            $this->Develop_model->UpdateTable('address', 'user_id', $_SESSION['lerenuser']['id'], array('is_default' => 0));
        }
        $this->Develop_model->UpdateTable('address', 'id', $id, array('is_default' => $is_default));
        echo 1;
    }

    public function DeleteAddress() {
        $id = $_POST['id'];
        $this->Develop_model->DeleteTable('address', array('id' => $id));
        echo 1;
    }

}

?>