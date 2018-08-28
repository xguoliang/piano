<?php

session_start();

class Admin_Controller extends CI_Controller {

    protected $layout = 'admin/layout/main';

    public function __construct() {
        parent::__construct();
        $this->load->model('Develop_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        if (!isset($_SESSION['piano_admin'])) {
            header("Location:" . base_url() . "Admin/Login/Login.html");
            exit;
        }
    }

    public function UseRedis() {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        return $redis;
    }

    //file 表示是否使用渲染子视图文件，viewData表示的是子视图中渲染数据，$layout表示父视图中使用的全局数据
    protected function render($file = NULL, &$viewData = array(), $layoutData = array()) {
        if (!is_null($file)) {
            $data['content'] = $this->load->view($file, $viewData, TRUE);
            $data['layout'] = $layoutData;
            $this->load->view($this->layout, $data);
        } else {
            $this->load->view($this->layout, $viewData);
        }
        $viewData = array();
    }

}

class Back_Controller extends CI_Controller {

    protected $layout = 'back/layout/main';

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        if (!isset($_SESSION['back_user'])) {
            header("Location:" . base_url() . "Back/Login/Login.html");
            exit;
        }
    }

    //file 表示是否使用渲染子视图文件，viewData表示的是子视图中渲染数据，$layout表示父视图中使用的全局数据
    protected function render($file = NULL, &$viewData = array(), $layoutData = array()) {
        if (!is_null($file)) {
            $data['content'] = $this->load->view($file, $viewData, TRUE);
            $data['layout'] = $layoutData;
            $this->load->view($this->layout, $data);
        } else {
            $this->load->view($this->layout, $viewData);
        }
        $viewData = array();
    }

}

class User_Controller extends CI_Controller {

    protected $layout = 'user/layout/main';
    protected $payout = 'phone/layout/main';
    private $js_files = array();
    private $css_files = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('Bandsman_model');
        $this->load->model('Company_model');
        $this->load->model('Develop_model');
        $this->load->model('Order_model');
        $this->load->model('Rent_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');

        $kongzhiqi = $this->router->fetch_class() . '/' . $this->router->fetch_method();
    }

    public function isMobile() {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung',
                'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel',
                'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront',
                'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi',
                'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }

    public function add_js($filepath) {
        array_push($this->js_files, "<script type='text/javascript' src='" . $filepath . "'></script>");
    }

    public function add_css($filepath) {
        array_push($this->css_files, "<link href='" . $filepath . "' rel='stylesheet' type='text/css'>");
    }

    //file 表示是否使用渲染子视图文件，viewData表示的是子视图中渲染数据，$layout表示父视图中使用的全局数据
    protected function render($file = NULL, &$viewData = array(), $layoutData = array()) {
        if (!is_null($file)) {
            $data['content'] = $this->load->view($file, $viewData, TRUE);
            $data['layout'] = $layoutData;
            $this->load->view($this->layout, $data);
        } else {
            $this->load->view($this->layout, $viewData);
        }
        $viewData = array();
    }

    protected function prender($file = NULL, &$viewData = array(), $layoutData = array()) {
        if (!is_null($file)) {
            $data['content'] = $this->load->view($file, $viewData, TRUE);
            $data['layout'] = $layoutData;
            $this->load->view($this->payout, $data);
        } else {
            $this->load->view($this->payout, $viewData);
        }
        $viewData = array();
    }

    public function SelectCollectProduct() {
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_type' => 1), 'add_time', 'desc', $pagesize, $offset);
        $product_id = array();
        for ($i = 0; $i < count($data); $i++) {
            array_push($product_id, $data[$i]['entity_id']);
        }
        $product = $this->Company_model->ProductIdsGetProduct($product_id);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($product); $j++) {
                if ($data[$i]['entity_id'] == $product[$j]['id']) {
                    $data[$i]['product'] = $product[$j];
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function SelectCollectLesson() {
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_type' => 2), 'add_time', 'desc', $pagesize, $offset);
        $lesson_id = array();
        for ($i = 0; $i < count($data); $i++) {
            array_push($lesson_id, $data[$i]['entity_id']);
        }
        $lesson = $this->Company_model->LessonIdsGetLesson($lesson_id);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($lesson); $j++) {
                if ($data[$i]['entity_id'] == $lesson[$j]['id']) {
                    $data[$i]['lesson'] = $lesson[$j];
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function SelectCollectActivity() {
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_type' => 3), 'add_time', 'desc', $pagesize, $offset);
        $activity_id = array();
        for ($i = 0; $i < count($data); $i++) {
            array_push($activity_id, $data[$i]['entity_id']);
        }
        $activity = $this->Company_model->ActivityIdsGetActivity($activity_id);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($activity); $j++) {
                if ($data[$i]['entity_id'] == $activity[$j]['id']) {
                    $data[$i]['activity'] = $activity[$j];
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function SelectCollectPerform() {
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_type' => 4), 'add_time', 'desc', $pagesize, $offset);
        $perform_id = array();
        for ($i = 0; $i < count($data); $i++) {
            array_push($perform_id, $data[$i]['entity_id']);
        }
        $perform = $this->Company_model->PerformIdsGetPerform($perform_id);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($perform); $j++) {
                if ($data[$i]['entity_id'] == $perform[$j]['id']) {
                    $data[$i]['perform'] = $perform[$j];
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function SelectCollectLease() {
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_type' => 5), 'add_time', 'desc', $pagesize, $offset);
        $lease_id = array();
        for ($i = 0; $i < count($data); $i++) {
            array_push($lease_id, $data[$i]['entity_id']);
        }
        $lease = $this->Rent_model->LeaseIdsGetLease($lease_id);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($lease); $j++) {
                if ($data[$i]['entity_id'] == $lease[$j]['id']) {
                    $data[$i]['lease'] = $lease[$j];
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function SelectCollectSiteLease() {
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_type' => 6), 'add_time', 'desc', $pagesize, $offset);
        $lease_id = array();
        for ($i = 0; $i < count($data); $i++) {
            array_push($lease_id, $data[$i]['entity_id']);
        }
        $lease = $this->Rent_model->SiteLeaseIdsGetSiteLease($lease_id);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($lease); $j++) {
                if ($data[$i]['entity_id'] == $lease[$j]['id']) {
                    $data[$i]['lease'] = $lease[$j];
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function SelectCollectMovie() {
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_type' => 8), 'add_time', 'desc', $pagesize, $offset);
        $movie_id = array();
        for ($i = 0; $i < count($data); $i++) {
            array_push($movie_id, $data[$i]['entity_id']);
        }
        $movie = $this->Company_model->MovieIdsGetMovie($movie_id);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($movie); $j++) {
                if ($data[$i]['entity_id'] == $movie[$j]['id']) {
                    $data[$i]['movie'] = $movie[$j];
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function InsertCollect($user_id, $entity_id, $entity_type) {
        date_default_timezone_set('Asia/Shanghai');
        $add_time = (string) date("Y-m-d H:i:s");
        if (count($this->Develop_model->GetResult('collect', array('user_id' => $user_id, 'entity_id' => $entity_id, 'entity_type' => $entity_type))) == 0) {
            $this->Develop_model->InsertTable('collect', array('user_id' => $user_id, 'entity_id' => $entity_id, 'entity_type' => $entity_type, 'add_time' => $add_time));
        }
    }

    public function DeleteCollect() {
        $id = $_POST['id'];
        $this->Develop_model->DeleteTable('collect', array('id' => $id));
        echo 1;
    }

    public function GetArea($table, $delete = 0) {
        $this->db->select('area')->from($table);
        if ($delete) {
            $this->db->where('is_delete', 0);
        }
        $data = $this->db->get()->result_array();
        $res = array();
        foreach ($data as $k => $v) {
            if (!in_array(explode(' ', $v['area'])[0], $res)) {
                $res[$k] = explode(' ', $v['area'])[0];
            }
        }
        return $res;
    }

    public function is_login() {
        if (!isset($_SESSION['lerenuser'])) {
            header("Location:" . base_url() . "User/Login/PLogin.html");
            exit;
        }
    }

}

?>