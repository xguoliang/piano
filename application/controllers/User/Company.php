<?php

class Company extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Universal_model');
    }

    public function PCompanyIndex() {
        $this->is_login();

        $data['detail'] = $this->Develop_model->GetRow('company', array('user_id' => $_SESSION['lerenuser']['id']));
        if (!isset($data['detail']['id'])) {
            $this->Develop_model->InsertTable('company', array('user_id' => $_SESSION['lerenuser']['id'], 'name' => '', 'phone' => $_SESSION['lerenuser']['phone']));
            $data['detail'] = $this->Develop_model->GetRow('company', array('user_id' => $_SESSION['lerenuser']['id']));
        }
        $_SESSION['lerenuser']['company_id'] = $data['detail']['id'];
        $_SESSION['lerenuser']['roler'] = 1;
        $this->prender('phone/company/company_index', $data, array('title' => '我的琴行'));
    }

    public function PChangeCompany() {
        $this->is_login();

        $data['detail'] = $this->Develop_model->GetRow('company', array('user_id' => $_SESSION['lerenuser']['id']));
        $this->prender('phone/company/change_company', $data, array('title' => '琴行信息编辑'));
    }

    public function UpdateCompany() {
        $this->is_login();

        $id = $_SESSION['lerenuser']['company_id'];
        $data['headimg'] = str_replace(base_url(), "", $_POST['headimg']);
        $data['name'] = $_POST['name'];
        $data['phone'] = $_POST['phone'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $data['img'] = str_replace(base_url(), "", $_POST['img']);
        $data['lng'] = $_POST['lng'];
        $data['lat'] = $_POST['lat'];
        $this->Develop_model->UpdateTable('company', 'id', $id, $data);
        echo 1;
    }

    public function PLessonList() {
        $this->is_login();

        $this->prender('phone/company/lesson_list', $data, array('title' => '课程中心'));
    }

    public function SelectLesson() {
        $this->is_login();

        $search = $_POST['search'];
        $instruction_id = $_POST['instrument_id'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $company = $this->Develop_model->GetRow('company', array('user_id' => $_SESSION['lerenuser']['id']));
        $data = $this->Company_model->SelectLesson($company['id'], $search, $instruction_id, $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PAddLesson() {
        $this->is_login();

        $data['instrument'] = $this->Develop_model->GetResult('instrument', array('is_delete' => 0));
        $this->prender('phone/company/add_lesson', $data, array('title' => '课程发布'));
    }

    public function InsertLesson() {
        $this->is_login();

        date_default_timezone_set('Asia/Shanghai');
        $data['add_time'] = (string) date("Y-m-d H:i:s");
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['start_time'] = $_POST['start_time'];
        $data['end_time'] = $_POST['end_time'];
        $data['price'] = $_POST['price'];
        $data['instrument_id'] = $_POST['instrument_id'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $data['lng'] = $_POST['lng'];
        $data['lat'] = $_POST['lat'];
        $data['company_id'] = $_SESSION['lerenuser']['company_id'];
        $this->Develop_model->InsertTable('lesson', $data);
        echo 1;
    }

    public function PChangeLesson() {
        $this->is_login();

        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('lesson', array('id' => $id));
        $data['instrument'] = $this->Develop_model->GetResult('instrument', array('is_delete' => 0));
        $this->prender('phone/company/change_lesson', $data, array('title' => '课程编辑'));
    }

    public function UpdateLesson() {
        $this->is_login();

        $id = $_POST['id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['start_time'] = $_POST['start_time'];
        $data['end_time'] = $_POST['end_time'];
        $data['price'] = $_POST['price'];
        $data['instrument_id'] = $_POST['instrument_id'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $data['lng'] = $_POST['lng'];
        $data['lat'] = $_POST['lat'];
        $this->Develop_model->UpdateTable('lesson', 'id', $id, $data);
        echo 1;
    }

    public function DeleteLesson() {
        $this->is_login();

        $id = $_POST['id'];
        $this->Develop_model->UpdateTable('lesson', 'id', $id, array('is_delete' => 1));
        echo 1;
    }

    public function PTeacherList() {
        $this->is_login();

        $this->prender('phone/company/teacher_list', $data, array('title' => '老师管理'));
    }

    public function SelectTeacher() {
        $this->is_login();

        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Company_model->SelectTeacher($_SESSION['lerenuser']['company_id'], $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PAddTeacher() {
        $this->is_login();

        $data['lesson'] = $this->Develop_model->GetResult('lesson', array('company_id' => $_SESSION['lerenuser']['company_id']));
        $this->prender('phone/company/add_teacher', $data, array('title' => '添加老师'));
    }

    public function InsertTeacher() {
        $this->is_login();

        date_default_timezone_set('Asia/Shanghai');
        $data['add_time'] = (string) date("Y-m-d H:i:s");
        $data['company_id'] = $_SESSION['lerenuser']['company_id'];
        $data['headimg'] = str_replace(base_url(), "", $_POST['headimg']);
        $data['name'] = $_POST['name'];
        $data['profession'] = $_POST['profession'];
        $data['year'] = $_POST['year'];
        $data['desc'] = $_POST['desc'];
        $data['works'] = $_POST['works'];
        $id = $this->Develop_model->InsertTableGetId('teacher', $data);
        $lesson_id = explode('|', $_POST['lesson_id']);
        $this->Company_model->InsertLessonTeacher($lesson_id, $id);
        echo 1;
    }

    public function PChangeTeacher() {
        $this->is_login();

        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('teacher', array('id' => $id));
        $data['tlesson'] = $this->Develop_model->GetResult('lesson_teacher', array('teacher_id' => $id));
        $data['lesson'] = $this->Develop_model->GetResult('lesson', array('company_id' => $_SESSION['lerenuser']['company_id']));
        $this->prender('phone/company/change_teacher', $data, array('title' => '编辑老师'));
    }

    public function UpdateTeacher() {
        $this->is_login();

        $id = $_POST['id'];
        $data['headimg'] = str_replace(base_url(), "", $_POST['headimg']);
        $data['name'] = $_POST['name'];
        $data['profession'] = $_POST['profession'];
        $data['year'] = $_POST['year'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->UpdateTable('teacher', 'id', $id, $data);
        $lesson_id = explode('|', $_POST['lesson_id']);
        $this->Develop_model->DeleteTable('lesson_teacher', array('teacher_id' => $id));
        $this->Company_model->InsertLessonTeacher($lesson_id, $id);
        echo 1;
    }

    public function DeleteTeacher() {
        $this->is_login();

        $id = $_POST['id'];
        $this->Develop_model->DeleteTable('teacher', array('id' => $id));
        $this->Develop_model->DeleteTable('lesson_teacher', array('teacher_id' => $id));
        echo 1;
    }

    public function PActivityList() {
        $this->is_login();

        $this->prender('phone/company/activity_list', $data, array('title' => '活动中心'));
    }

    public function SelectActivity() {
        $this->is_login();

        $search = $_POST['search'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Company_model->SelectActiviy($_SESSION['lerenuser']['company_id'], $search, $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PAddActivity() {
        $this->is_login();

        $this->prender('phone/company/add_activity', $data, array('title' => '发布精彩活动'));
    }

    public function InsertActivity() {
        $this->is_login();

        date_default_timezone_set('Asia/Shanghai');
        $data['add_time'] = (string) date("Y-m-d H:i:s");
        $data['company_id'] = $_SESSION['lerenuser']['company_id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['start_time'] = $_POST['start_time'];
        $data['end_time'] = $_POST['end_time'];
        $data['price'] = $_POST['price'];
        $data['type'] = $_POST['type'];
        $data['number'] = $_POST['number'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->InsertTable('activity', $data);
        echo 1;
    }

    public function PChangeActivity() {
        $this->is_login();

        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('activity', array('id' => $id));
        $this->prender('phone/company/change_activity', $data, array('title' => '编辑精彩活动'));
    }

    public function UpdateActivity() {
        $this->is_login();

        $id = $_POST['id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['start_time'] = $_POST['start_time'];
        $data['end_time'] = $_POST['end_time'];
        $data['price'] = $_POST['price'];
        $data['type'] = $_POST['type'];
        $data['number'] = $_POST['number'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->UpdateTable('activity', 'id', $id, $data);
        echo 1;
    }

    public function DeleteActivity() {
        $this->is_login();

        $id = $_POST['id'];
        $this->Develop_model->UpdateTable('activity', 'id', $id, array('is_delete' => 1));
        echo 1;
    }

    public function PPerformList() {
        $this->is_login();

        $this->prender('phone/company/perform_list', $data, array('title' => '演出列表'));
    }

    public function SelectPerform() {
        $this->is_login();

        $search = $_POST['search'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Company_model->SelectPerform($_SESSION['lerenuser']['company_id'], $search, $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PAddPerform() {
        $this->is_login();

        $this->prender('phone/company/add_perform', $data, array('title' => '发布演出'));
    }

    public function InsertPerform() {
        $this->is_login();

        date_default_timezone_set('Asia/Shanghai');
        $data['add_time'] = (string) date("Y-m-d H:i:s");
        $data['company_id'] = $_SESSION['lerenuser']['company_id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['start_time'] = $_POST['start_time'];
        $data['end_time'] = $_POST['end_time'];
        $data['price'] = $_POST['price'];
        $data['type'] = $_POST['type'];
        $data['phone'] = $_POST['phone'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->InsertTable('perform', $data);
        echo 1;
    }

    public function PChangePerform() {
        $this->is_login();

        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('perform', array('id' => $id));
        $this->prender('phone/company/change_perform', $data, array('title' => '编辑演出'));
    }

    public function UpdatePerform() {
        $this->is_login();

        $id = $_POST['id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['start_time'] = $_POST['start_time'];
        $data['end_time'] = $_POST['end_time'];
        $data['price'] = $_POST['price'];
        $data['type'] = $_POST['type'];
        $data['phone'] = $_POST['phone'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->UpdateTable('perform', 'id', $id, $data);
        echo 1;
    }

    public function DeletePerform() {
        $this->is_login();

        $id = $_POST['id'];
        $this->Develop_model->UpdateTable('perform', 'id', $id, array('is_delete' => 1));
        echo 1;
    }

    public function PSoundList() {
        $this->is_login();

        $this->prender('phone/company/sound_list', $data, array('title' => '演唱录音'));
    }

    public function SelectSound() {
        $this->is_login();

        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('sound', array('company_id' => $_SESSION['lerenuser']['company_id']), 'add_time', 'desc', $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PAddSound() {
        $this->is_login();

        $this->prender('phone/company/add_sound', $data, array('title' => '发布演唱录音'));
    }

    public function InsertSound() {
        $this->is_login();

        date_default_timezone_set('Asia/Shanghai');
        $data['add_time'] = (string) date("Y-m-d H:i:s");
        $data['company_id'] = $_SESSION['lerenuser']['company_id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['start_time'] = $_POST['start_time'];
        $data['end_time'] = $_POST['end_time'];
        $data['price'] = $_POST['price'];
//        $data['type'] = $_POST['type'];
        $data['phone'] = $_POST['phone'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->InsertTable('sound', $data);
        echo 1;
    }

    public function PChangeSound() {
        $this->is_login();

        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('sound', array('id' => $id));
        $this->prender('phone/company/change_sound', $data, array('title' => '编辑演唱录音'));
    }

    public function UpdateSound() {
        $this->is_login();

        $id = $_POST['id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['start_time'] = $_POST['start_time'];
        $data['end_time'] = $_POST['end_time'];
        $data['price'] = $_POST['price'];
//        $data['type'] = $_POST['type'];
        $data['phone'] = $_POST['phone'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->UpdateTable('sound', 'id', $id, $data);
        echo 1;
    }

    public function DeleteSound() {
        $this->is_login();

        $id = $_POST['id'];
        $this->Develop_model->UpdateTable('sound', array('id' => $id));
        echo 1;
    }

    public function PMovieList() {
        $this->is_login();

        $this->prender('phone/company/movie_list', $data, array('title' => '影视制作'));
    }

    public function SelectMovie() {
        $this->is_login();

        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('movie', array('company_id' => $_SESSION['lerenuser']['company_id'], 'is_delete' => 0), 'add_time', 'desc', $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PAddMovie() {
        $this->is_login();

        $this->prender('phone/company/add_movie', $data, array('title' => '发布影视制作'));
    }

    public function InsertMovie() {
        $this->is_login();

        date_default_timezone_set('Asia/Shanghai');
        $data['add_time'] = (string) date("Y-m-d H:i:s");
        $data['company_id'] = $_SESSION['lerenuser']['company_id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['price'] = $_POST['price'];
        $data['phone'] = $_POST['phone'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->InsertTable('movie', $data);
        echo 1;
    }

    public function PChangeMovie() {
        $this->is_login();

        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('movie', array('id' => $id));
        $this->prender('phone/company/change_movie', $data, array('title' => '编辑影视制作'));
    }

    public function UpdateMovie() {
        $this->is_login();

        $id = $_POST['id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['price'] = $_POST['price'];
        $data['phone'] = $_POST['phone'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->UpdateTable('movie', 'id', $id, $data);
        echo 1;
    }

    public function DeleteMovie() {
        $this->is_login();

        $id = $_POST['id'];
        $this->Develop_model->UpdateTable('movie', 'id', $id, array('is_delete' => 1));
        echo 1;
    }

    public function PHeadlineList() {
        $this->is_login();

        $this->prender('phone/company/headline_list', $data, array('title' => '新闻头条'));
    }

    public function SelectHeadline() {
        $this->is_login();

        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('headline', array('company_id' => $_SESSION['lerenuser']['company_id']), 'add_time', 'desc', $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PAddHeadline() {
        $this->is_login();

        $this->prender('phone/company/add_headline', $data, array('title' => '发布头条'));
    }

    public function InsertHeadline() {
        $this->is_login();

        date_default_timezone_set('Asia/Shanghai');
        $data['add_time'] = (string) date("Y-m-d H:i:s");
        $data['company_id'] = $_SESSION['lerenuser']['company_id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['title'] = $_POST['title'];
        $data['tag'] = $_POST['tag'];
        $data['desc'] = $_POST['desc'];
        if ($_POST['time'] != "") {
            $data['time'] = $_POST['time'];
        } else {
            $data['time'] = $data['add_time'];
        }
        $this->Develop_model->InsertTable('headline', $data);
        echo 1;
    }

    public function PChangeHeadline() {
        $this->is_login();

        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('headline', array('id' => $id));
        $this->prender('phone/company/change_headline', $data, array('title' => '编辑头条'));
    }

    public function UpdateHeadline() {
        $this->is_login();

        date_default_timezone_set('Asia/Shanghai');
        $id = $_POST['id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['title'] = $_POST['title'];
        $data['tag'] = $_POST['tag'];
        $data['desc'] = $_POST['desc'];
        if ($_POST['time'] != "") {
            $data['time'] = $_POST['time'];
        } else {
            $data['time'] = (string) date("Y-m-d H:i:s");
        }
        $this->Develop_model->UpdateTable('headline', 'id', $id, $data);
        echo 1;
    }

    public function DeleteHeadline() {
        $this->is_login();

        $id = $_POST['id'];
        $this->Develop_model->DeleteTable('headline', array('id' => $id));
        echo 1;
    }

    public function PProductList() {
        $this->is_login();

        $data['instrument'] = $this->Develop_model->GetResult('instrument', array('is_delete' => 0));
        $this->prender('phone/company/product_list', $data, array('title' => '商品管理'));
    }

    public function SelectProduct() {
        $this->is_login();

        $search = $_POST['search'];
        $instrument_id = $_POST['instrument_id'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Company_model->SelectProduct($_SESSION['lerenuser']['company_id'], $search, $instrument_id, $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PChangeProduct() {
        $this->is_login();

        $id = $_GET['id'];
        $data['instrument'] = $this->Develop_model->GetAllOrderResult('instrument', 'sort', 'asc');
        $data['brand'] = $this->Develop_model->GetAllOrderResult('brand', 'sort', 'asc');
        $data['detail'] = $this->Develop_model->GetRow('product', array('id' => $id));
        if ($data['detail']['com_id'] == $_SESSION['lerenuser']['company_id']) {
            $this->prender('phone/company/change_product', $data, array('title' => '编辑商品'));
        } else {
            echo '你没有权限';
        }
    }

    public function UpdateProduct() {
        $this->is_login();

        $id = $_POST['id'];
        $data['name'] = $_POST['name'];
        $data['brand_id'] = $_POST['brand_id'];
        $data['instrument_id'] = $_POST['instrument_id'];
        $data['price'] = $_POST['price'];
        $data['detail'] = $_POST['detail'];
        $this->Develop_model->UpdateTable('product', 'id', $id, $data);
        echo 1;
    }

    public function DeleteProduct() {
        $this->is_login();

        $id = $_POST['id'];
        $this->Develop_model->UpdateTable('product', 'id', $id, array('is_delete' => 1));
        echo 1;
    }

    public function PChooseOrderType() {
        $this->is_login();

        $this->prender('phone/company/choose_order_type', $data, array('title' => '我的订单'));
    }

    public function PProductOrder() {
        $this->is_login();

        $this->prender('phone/company/product_order', $data, array('title' => '商品订单'));
    }

    public function SelectProductOrder() {
        $this->is_login();

        $status = $_POST['status'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Order_model->SelectProductOrder($_SESSION['lerenuser']['company_id'], $status, $pagesize, $offset);
        $order_id = array();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['detail'] = array();
            array_push($order_id, $data[$i]['order_id']);
        }
        $detail = $this->Order_model->OrderIdsGetOrderDetail($order_id, $_SESSION['lerenuser']['company_id']);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($detail); $j++) {
                if ($data[$i]['order_id'] == $detail[$j]['order_id']) {
                    array_push($data[$i]['detail'], $detail[$j]);
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PProductOrderDetail() {
        $this->is_login();

        $id = $_GET['id'];
        $data['order'] = $this->Develop_model->GetRow('orders', array('id' => $id));
        $data['detail'] = $this->Develop_model->GetResult('view_orders_detail_student', array('order_id' => $id, 'com_id' => $_SESSION['lerenuser']['company_id']));
        $this->prender('phone/company/product_order_detail', $data, array('title' => '商品订单详情'));
    }

    public function PLessonOrder() {
        $this->is_login();

        $this->prender('phone/company/lesson_order', $data, array('title' => '课程订单'));
    }

    public function SelectLessonOrder() {
        $this->is_login();

        $status = $_POST['status'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Order_model->SelectLessonOrder($_SESSION['lerenuser']['company_id'], $status, $pagesize, $offset);
        $order_id = array();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['detail'] = array();
            array_push($order_id, $data[$i]['order_id']);
        }
        $detail = $this->Order_model->LessonOrderIdsGetOrderDetail($order_id, $_SESSION['lerenuser']['company_id']);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($detail); $j++) {
                if ($data[$i]['order_id'] == $detail[$j]['order_id']) {
                    array_push($data[$i]['detail'], $detail[$j]);
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PLessonOrderDetail() {
        $this->is_login();

        $id = $_GET['id'];
        $data['order'] = $this->Develop_model->GetRow('orders', array('id' => $id));
        $data['detail'] = $this->Develop_model->GetResult('view_order_detail_student_lesson', array('order_id' => $id, 'company_id' => $_SESSION['lerenuser']['company_id']));
        $this->prender('phone/company/lesson_order_detail', $data, array('title' => '课程订单详情'));
    }

    public function PActivityOrder() {
        $this->is_login();

        $this->prender('phone/company/activity_order', $data, array('title' => '活动订单'));
    }

    public function SelectActivityOrder() {
        $this->is_login();

        $status = $_POST['status'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Order_model->SelectActivityOrder($_SESSION['lerenuser']['company_id'], $status, $pagesize, $offset);
        $order_id = array();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['detail'] = array();
            array_push($order_id, $data[$i]['order_id']);
        }
        $detail = $this->Order_model->ActivityOrderIdsGetOrderDetail($order_id, $_SESSION['lerenuser']['company_id']);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($detail); $j++) {
                if ($data[$i]['order_id'] == $detail[$j]['order_id']) {
                    array_push($data[$i]['detail'], $detail[$j]);
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PActivityOrderDetail() {
        $this->is_login();

        $id = $_GET['id'];
        $data['order'] = $this->Develop_model->GetRow('orders', array('id' => $id));
        $data['detail'] = $this->Develop_model->GetResult('view_order_detail_student_activity', array('order_id' => $id, 'company_id' => $_SESSION['lerenuser']['company_id']));
        $this->prender('phone/company/activity_order_detail', $data, array('title' => '课程订单详情'));
    }

    public function DeleteOrder() {
        $this->is_login();

        $id = $_POST['id'];
        $this->Develop_model->UpdateTable('order', 'id', $id, array('is_delete' => 1));
        echo 1;
    }

    public function CompanyDetail() {

        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $company = $this->Universal_model->FetchOne('company', array('id' => $id));
        $data['company'] = $company;
        $data['company']['avg_star'] = floor($this->Company_model->GetAvgStar($id));
        $data['brand'] = $this->Company_model->FetchCompanyBrand($id);
        $this->prender('phone/company/company_detail', $data, array('title' => $company['name']));
    }

    public function CompanyDetail1() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $company = $this->Universal_model->FetchOne('company', array('id' => $id));
        $data['company'] = $company;
        $data['company']['avg_star'] = floor($this->Company_model->GetAvgStar($id));
        $data['brand'] = $this->Company_model->FetchCompanyBrand($id);
        $this->prender('phone/company/company_detail1', $data, array('title' => $company['name']));
    }

    public function CompanyDetail2() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $company = $this->Universal_model->FetchOne('company', array('id' => $id));
        $data['company'] = $company;
        $data['company']['avg_star'] = floor($this->Company_model->GetAvgStar($id));
        $data['brand'] = $this->Company_model->FetchCompanyBrand($id);
        $this->prender('phone/company/company_detail2', $data, array('title' => $company['name']));
    }

    public function CompanyDetail3() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $company = $this->Universal_model->FetchOne('company', array('id' => $id));
        $data['company'] = $company;
        $data['company']['avg_star'] = floor($this->Company_model->GetAvgStar($id));
        $data['brand'] = $this->Company_model->FetchCompanyBrand($id);
        $data['area'] = $this->GetArea('activity', 1);
        $this->prender('phone/company/company_detail3', $data, array('title' => $company['name']));
    }

    public function CompanyDetail4() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $company = $this->Universal_model->FetchOne('company', array('id' => $id));
        $data['company'] = $company;
        $data['company']['avg_star'] = floor($this->Company_model->GetAvgStar($id));
        $data['brand'] = $this->Company_model->FetchCompanyBrand($id);
        $this->prender('phone/company/company_detail4', $data, array('title' => $company['name']));
    }

    public function FetchCompanyProduct() {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $com_id = $_POST['id'];
        $area = isset($_POST['area']) ? $_POST['area'] : '';
        $min_price = isset($_POST['min_price']) ? $_POST['min_price'] : '';
        $max_price = isset($_POST['max_price']) ? $_POST['max_price'] : '';
        $sort_type = isset($_POST['sort_type']) ? $_POST['sort_type'] : '';

        $lng = isset($_POST['lng']) ? $_POST['lng'] : '';
        $lat = isset($_POST['lat']) ? $_POST['lat'] : '';
        $pagesize = $_POST['limit'];
        $offset = ($_POST['page'] - 1) * $pagesize;
        $brand_id = $_POST['brand_id'];
        $type = $_POST['type'];
        if ($type == 1) {
            $res = $this->Company_model->SelectGoodProduct($area, $min_price, $max_price, $brand_id, $sort_type, $lng, $lat, $pagesize, $offset, $name, $com_id);
        } else if ($type == 2) {
            $res = $this->Company_model->SelectGoodLesson($area, $min_price, $max_price, $sort_type, $lng, $lat, $pagesize, $offset, $name, $com_id);
        }
        echo json_encode($res);
    }

    public function FetchCompanyTeacher() {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $com_id = isset($_POST['id']) ? $_POST['id'] : '';
        $limit = $_POST['limit'];
        $offset = $_POST['limit'] * ($_POST['page'] - 1);

        $res = $this->db->select('t.*,count(l.lesson_id) as lesson_num')
                        ->from('teacher as t')
                        ->join('lesson_teacher as l', 't.id = l.teacher_id', 'left')
                        ->where('t.company_id', $com_id)
                        ->like('t.name', $name)
                        ->limit($limit, $offset)
                        ->group_by('t.id')
                        ->get()->result_array();
        echo json_encode($res);
    }

    public function FetchCompanyActivity() {
        $name = $_POST['name'];
        $limit = $_POST['limit'];
        $offset = ($_POST['page'] - 1) * $limit;
        $area = $_POST['area'];
        $min_price = $_POST['min_price'];
        $max_price = $_POST['max_price'];
        $sort_type = $_POST['sort_type'];
        if ($sort_type == 3) {
            $sort_type = 'desc';
        } else {
            $sort_type = 'asc';
        }
        $com_id = $_POST['id'];
        $res = $this->Company_model->FetchCompanyActivity($com_id, $sort_type, $name, $offset, $limit, $area, $min_price, $max_price);
        echo json_encode($res);
    }

    public function FetchCompanyHeadline() {
        $name = $_POST['name'];
        $limit = $_POST['limit'];
        $offset = ($_POST['page'] - 1) * $limit;
        $com_id = $_POST['id'];
        $like = array('title' => $name);
        $equal = array('company_id' => $com_id);
        $order = array('sort' => 'asc', 'add_time' => 'desc');
        $res = $this->Universal_model->FetchPageData('headline', $offset, $limit, $equal, $like, $order);
        echo json_encode($res);
    }

    public function CollectProduct() {
        $save = $_POST['save'];
        if (isset($_SESSION['lerenuser'])) {
            $one = $this->Universal_model->FetchOne('collect', $save);
            if ($one == null) {
                $res = array('status' => 1, 'coll' => 1);
                $save['add_time'] = date("Y-m-d H:i:s", time());
                $post = array('id' => '', 'save' => $save);
                $this->Universal_model->SaveOne('collect', 'id', $post);
            } else {
                $res = array('status' => 1, 'coll' => 2);
            }
        } else {
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

}

?>