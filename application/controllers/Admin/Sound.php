<?php

class Sound extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function SoundList()
    {
        $data = array();
        $this->render('admin/record/soundlist', $data, array('title' => '录音列表','index_pmod' => 6, 'index_mod' => 3));
    }

    public function FetchCount()
    {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchCount('sound', $equal, $like);
        echo json_encode($res);
    }

    public function FetchPageData()
    {
        $limit = $_POST['limit'];
        $offset = $limit * ($_POST['page'] - 1);
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchPageData('sound', $offset, $limit, $equal, $like);
        echo json_encode($res);
    }

    public function AddOne()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $equal = array('id' => $id);
        $one = $this->Universal_model->FetchOne('sound',$equal);
        if($one == null){
            echo "<script>alert('参数错误!')</script>";
            echo "window.history.go(-1)";
        }else{
            $data['one'] = $one;
            $this->render('admin/record/addone',$data,array('title' => '查看录音','index_pmod' => 1,'index_mod' => 1));
        }
    }

    public function DeleteOne()
    {
        if (isset($_SESSION['piano_admin'])) {
            $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
            $this->Universal_model->DeleteOne('sound', $equal);
            $res = array('status' => 1,'msg' => '删除成功!');
        } else {
            $res = array('status' => 2,'msg' => '登录失效，请重新登录后操作!');
        }
        echo json_encode($res);
    }
}

?>