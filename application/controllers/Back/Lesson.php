<?php

class Lesson extends Back_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Develop_model');
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function LessonList() {
        $data['instrument'] = $this->Universal_model->FetchData('instrument');
        $this->render('back/lesson/lessonlist', $data, array('title' => '课程管理', 'index_mod' => 2));
    }

    public function FetchCount() {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $this->db->select('a.*,b.name as ins_name')
                ->from('lesson as a')
                ->join('instrument as b', 'a.instrument_id = b.id', 'left');
        foreach ($equal as $k => $v) {
            $this->db->where('a.' . $k, $v);
        }
        foreach ($like as $k => $v) {
            $this->db->like('a.' . $k, $v);
        }
        $this->db->order_by('add_time', 'desc');
        $res = $this->db->get()->result_array();
        echo json_encode($res);
    }

    public function AddOne() {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $equal = array('id' => $id);
        $one = $this->Universal_model->FetchOne('lesson', $equal);
        $data['one'] = $one;
        $data['instrument'] = $this->Develop_model->GetResult('instrument', array('is_delete' => 0));
        $this->render('back/lesson/addlesson', $data, array('title' => '编辑课程', 'index_mod' => 2));
    }

    public function SaveOne() {
        if (isset($_SESSION['back_user'])) {
            if ($_POST['id'] == '') {
                $_POST['save']['add_time'] = date("Y-m-d H:i:s", time());
                $_POST['save']['company_id'] = $_SESSION['back_user']['com_id'];
                $_POST['save']['is_delete'] = 0;
            } else {
                
            }
            $this->Universal_model->SaveOne('lesson', 'id', $_POST);
            $res = array('status' => 1, 'msg' => '保存成功!');
        } else {
            $res = array('status' => 2, 'msg' => '登录失效，请重新登陆后操作!');
        }
        echo json_encode($res);
    }

}

?>