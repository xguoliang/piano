<?php

class Piano extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function PianoList()
    {
        $data = array();
        $this->render('admin/piano/pianolist', $data, array('title' => '琴行管理','index_pmod' => 1, 'index_mod' => 1));
    }

    public function FetchCount()
    {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchCount('company', $equal, $like);
        echo json_encode($res);
    }

    public function FetchPageData()
    {
        $limit = $_POST['limit'];
        $offset = $limit * ($_POST['page'] - 1);
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchPageData('company', $offset, $limit, $equal, $like);
        echo json_encode($res);
    }

    public function AddOne()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $equal = array('id' => $id);
        $one = $this->Universal_model->FetchOne('company',$equal);
        if($one == null){
            echo "<script>alert('参数错误!')</script>";
            echo "window.history.go(-1)";
        }else{
            $data['one'] = $one;
            $this->render('admin/piano/addone',$data,array('title' => '查看琴行','index_pmod' => 1,'index_mod' => 1));
        }
    }
}

?>