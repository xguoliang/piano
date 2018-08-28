<?php

class Lesson extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Universal_model');
    }

    public function LessonList() {
        $data['instrument'] = $this->Develop_model->GetAllResult('instrument');
        $data['area'] = $this->GetArea('lesson', 1);
        $data['name'] = isset($_GET['name']) ? $_GET['name'] : '';
        $this->prender('phone/lesson/lesson_list', $data, array('title' => '乐器培训', 'top' => 1));
    }

    public function SelectLesson() {
        $area = $_POST['area'];
        $instrument_id = $_POST['instrument_id'];
        $min_price = $_POST['min_price'];
        $max_price = $_POST['max_price'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $name = $_POST['name'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Company_model->AllSelectLesson($area, $instrument_id, $min_price, $max_price, $pagesize, $offset, $name);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function LessonDetail() {
        $id = $_GET['id'];
        if (isset($_SESSION['lerenuser'])) {
            $one = $this->Universal_model->FetchOne('collect', array('entity_type' => 2, 'entity_id' => $id));
            if ($one == null) {
                $data['is_collect'] = 0;
            } else {
                $data['is_collect'] = 1;
            }
        } else {
            $data['is_collect'] = 0;
        }
        $data['detail'] = $this->Develop_model->GetRow('lesson', array('id' => $id));
        $this->prender('phone/lesson/lesson_detail', $data, array('title' => '乐器培训详情'));
    }

}

?>