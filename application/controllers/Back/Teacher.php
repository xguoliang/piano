<?php

class Teacher extends Back_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function TeacherList()
    {
        $data['instrument'] = $this->Universal_model->FetchData('instrument');
        $this->render('back/teacher/teacherlist', $data, array('title' => '老师管理', 'index_mod' => 3));
    }

    public function FetchCount()
    {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchData('teacher', $equal, $like, array('add_time', 'desc'));
        echo json_encode($res);
    }


    public function AddOne()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if (isset($_SESSION['back_user'])) {
            if($id != ''){
                $equal = array('id' => $id);
                $one = $this->Universal_model->FetchOne('teacher', $equal);
                $equal = array('company_id' => $_SESSION['back_user']['com_id']);
                $lesson = $this->Universal_model->FetchData('lesson',$equal);
                $my_lesson = $this->Universal_model->FetchData('lesson_teacher',array('teacher_id' => $id));
                $my_lesson_id = array();
                foreach($my_lesson as $k=>$v){
                    $my_lesson_id[$k] = $v['lesson_id'];
                }
                $data['one'] = $one;
                $data['lesson'] = $lesson;
                $data['my_lesson_id'] = $my_lesson_id;
                $data['video'] = $this->Universal_model->FetchData('media',array('teacher_id' => $id,'type' => 1));
                $data['sound'] = $this->Universal_model->FetchData('media',array('teacher_id' => $id,'type' => 0));
            }else{
                $equal = array('company_id' => $_SESSION['back_user']['com_id']);
                $lesson = $this->Universal_model->FetchData('lesson',$equal);
                $data['lesson'] = $lesson;
                $data['sound'] = array();
                $data['video'] = array();
            }
            $this->render('back/teacher/addteacher', $data, array('title' => '编辑老师', 'index_mod' => 3));
        } else {
            echo "<script>alert('参数错误!');window.history.go(-1);</script>";
        }

    }



    public function DeleteOne()
    {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        if (isset($_SESSION['back_user'])) {
            $this->Universal_model->DeleteOne('teacher', $equal);
            $res = array('status' => 1, 'msg' => '删除成功!');
        } else {
            $res = array('status' => 2, 'msg' => '登录失效，请重新登录后操作!');
        }
        echo json_encode($res);
    }

    public function FetchMedia()
    {
        $equal = isset($_POST['equal']) ? $_POST['equal']: array();
        $res = $this->Universal_model->FetchOne('media',$equal);
        echo json_encode($res);
    }

    public function DeleteMedia()
    {
        if(isset($_SESSION['back_user'])){
            $equal = isset($_POST['equal']) ? $_POST['equal']: array();
            $this->Universal_model->DeleteOne('media',$equal);
            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

    public function SaveOne()
    {
        if (isset($_SESSION['back_user'])) {
            $teacher = isset($_POST['teacher'])?$_POST['teacher']:array();
            $my_lesson = isset($_POST['my_lesson'])?$_POST['my_lesson']:array();
            $music = isset($_POST['music'])?$_POST['music']:array();
            $video = isset($_POST['video'])?$_POST['video']:array();
            if($_POST['id'] == ''){
                $company = $this->Universal_model->FetchOne('company',array('user_id'=>$_SESSION['back_user']['id']));
                $teacher['company_id'] = $company['id'];
                $teacher['add_time'] = date("Y-m-d H:i:s",time());
                $this->db->insert('teacher',$teacher);
                $id = $this->db->insert_id();
            }else{
                $id = $_POST['id'];
                $this->db->update('teacher',$teacher,array('id' => $id));
            }
            $this->db->delete('lesson_teacher',array('teacher_id' => $id));
            foreach($my_lesson as $k=>$v){
                $lesson[$k]['teacher_id'] = $id;
                $lesson[$k]['lesson_id'] = $v;
            }
            if(count($my_lesson) > 0){
                $this->Universal_model->SaveData('lesson_teacher',$lesson);
            }
            $this->db->delete('media',array('teacher_id' => $id));
            foreach($video as $k=>$v){
                $video[$k]['teacher_id'] = $id;
            }
            foreach($music as $k=>$v){
                $music[$k]['teacher_id'] = $id;
            }
            if(count($music) > 0){
                $this->Universal_model->SaveData('media',$music);

            }
            if(count($video) > 0) {
                $this->Universal_model->SaveData('media',$video);

            }
            $res = array('status' => 1, 'msg' => '保存成功!');
        } else {
            $res = array('status' => 2, 'msg' => '登录失效，请重新登陆后操作!');
        }
        echo json_encode($res);
    }
}
?>