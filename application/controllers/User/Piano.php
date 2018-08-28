<?php

class Piano extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Piano_model');
        $this->load->model('Universal_model');
    }

    public function PCompanyList() {
        $data['area'] = $this->GetArea('company', 0);
        $data['name'] = isset($_GET['name']) ? $_GET['name'] : '';
        $this->prender('phone/piano/company_list', $data, array('title' => '琴行'));
    }

    public function SelectCompany() {
        $sort_type = isset($_POST['sort_type']) ? $_POST['sort_type'] : 1;
        $area = isset($_POST['area']) ? $_POST['area'] : 1;
        $lng = $_POST['lng'];
        $lat = $_POST['lat'];
        $limit = $_POST['limit'];
        $offset = ($_POST['page'] - 1) * $limit;
        $name = $_POST['name'];
        $res = $this->Piano_model->GetCompany($offset, $limit, $lat, $lng, $area, $sort_type, $name);
        for ($i = 0; $i < count($res); $i++) {
            $res[$i]['avg_star'] = floor($this->Company_model->GetAvgStar($res[$i]['id']));
        }
        echo json_encode($res);
    }

    public function CollectCompany() {
        date_default_timezone_set('Asia/Shanghai');
        $add_time = (string) date("Y-m-d H:i:s");
        $id = $_POST['id'];
        if (count($this->Develop_model->GetResult('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_id' => $id, 'entity_type' => 9))) == 0) {
            $this->Develop_model->InsertTable('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_id' => $id, 'entity_type' => 9, 'add_time' => $add_time));
            echo 1;
        } else {
            echo 2;
        }
    }

    public function PCompanyDetail() {
        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('company', array('id' => $id));
        $this->prender('phone/piano/company_detail', $data, array('title' => $data['detail']['name']));
    }

    public function CompanySelectProduct() {
        $company_id = $_POST['company_id'];
        $search = $_POST['search'];
        $area = $_POST['area'];
        $min_price = $_POST['min_price'];
        $max_price = $_POST['max_price'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Company_model->CompanySelectProduct($company_id, $search, $area, $min_price, $max_price, $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function CollectProduct() {
        date_default_timezone_set('Asia/Shanghai');
        $add_time = (string) date("Y-m-d H:i:s");
        $id = $_POST['id'];
        if (count($this->Develop_model->GetResult('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_id' => $id, 'entity_type' => 1))) == 0) {
            $this->Develop_model->InsertTable('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_id' => $id, 'entity_type' => 1, 'add_time' => $add_time));
            echo 1;
        } else {
            echo 2;
        }
    }

    public function CompanySelectLesson() {
        $company_id = $_POST['company_id'];
        $area = $_POST['area'];
        $instrument_id = $_POST['instrument_id'];
        $min_price = $_POST['min_price'];
        $max_price = $_POST['max_price'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Company_model->CompanySelectLesson($company_id, $area, $instrument_id, $min_price, $max_price, $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function CollectLesson() {
        date_default_timezone_set('Asia/Shanghai');
        $add_time = (string) date("Y-m-d H:i:s");
        $id = $_POST['id'];
        if (count($this->Develop_model->GetResult('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_id' => $id, 'entity_type' => 2))) == 0) {
            $this->Develop_model->InsertTable('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_id' => $id, 'entity_type' => 2, 'add_time' => $add_time));
            echo 1;
        } else {
            echo 2;
        }
    }

    public function CompanySelectTeacher() {
        $company_id = $_POST['company_id'];
        $data = $this->Develop_model->GetResult('teacher', array('company_id' => $company_id));
        $teacher_id = array();
        for ($i = 0; $i < count($data); $i++) {
            array_push($teacher_id, $data[$i]['id']);
        }
        $lesson = $this->Company_model->TeacherIdsGetLessonCount($teacher_id);
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($lesson); $j++) {
                if ($data[$i]['id'] == $lesson[$j]['teacher_id']) {
                    $data[$i]['lesson_num'] = $lesson[$j]['count'];
                    break;
                }
            }
            if (!isset($data[$i]['lesson_num'])) {
                $data[$i]['lesson_num'] = 0;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PTeacherDetail() {
        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('teacher', array('id' => $id));
        $this->prender('phone/piano/teacher_detail', $data, array('title' => $data['detail']['name']));
    }

    public function CompanySelectActivity() {
        $company_id = $_POST['company_id'];
        $area = $_POST['area'];
        $type = $_POST['type'];
        $min_price = $_POST['min_price'];
        $max_price = $_POST['max_price'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Company_model->CompanySelectActivity($company_id, $area, $type, $min_price, $max_price, $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function CompanySelectHeadline() {
        $company_id = $_POST['company_id'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Develop_model->GetOrderLimitResult('headline', array('company_id' => $company_id), 'add_time', 'desc', $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

}

?>