<?php

class Teacher extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Universal_model');
    }

    public function TeacherList()
    {

    }

    public function TeacherDetail()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $one = $this->Universal_model->FetchOne('teacher',array('id' => $id));
        if($one == null){
            exit;
        }
        $one['video_num'] = $this->db->select('count(0) as video_num')->from('media')->where('teacher_id',$id)->where('type',1)->get()->row_array()['video_num'];
        $one['audio_num'] = $this->db->select('count(0) as audio_num')->from('media')->where('teacher_id',$id)->where('type',0)->get()->row_array()['audio_num'];

        $data['one'] = $one;
        $this->prender('phone/teacher/teacher_detail',$data,array('title' => $one['name'],'top' => '1'));
    }

    public function Fetchmedia()
    {
        $limit = $_POST['limit'];
        $offset = ($_POST['page'] - 1) * $limit;
        $equal = $_POST['equal'];
        $res = $this->Universal_model->FetchPageData('media',$offset,$limit,$equal,array(),array('add_time' => 'desc'));
        echo json_encode($res);
    }
}

?>