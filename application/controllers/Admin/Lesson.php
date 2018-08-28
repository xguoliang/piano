<?php

class Lesson extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function LessonList()
    {
        $data = array();
        $this->render('admin/lesson/lessonlist', $data, array('title' => '课程管理','index_pmod' => 1, 'index_mod' => 2));
    }

    public function FetchCount()
    {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $res = $this->Universal_model->FetchCount('lesson', $equal, $like);
        echo json_encode($res);
    }

    public function FetchPageData()
    {
        $limit = $_POST['limit'];
        $offset = $limit * ($_POST['page'] - 1);
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        $this->db->select('a.*,b.name as com_name')
            ->from('lesson as a')
            ->join('company as b','a.company_id = b.id','left');
        foreach($like as $k=>$v){
            $this->db->like('a.'.$k,$v);
        }
        foreach($equal as $k=>$v){
            $this->db->where('a.'.$k,$v);
        }
        $res = $this->db->limit($limit,$offset)->get()->result_array();
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
            $this->render('admin/lesson/addone',$data,array('title' => '查看课程','index_pmod' => 1,'index_mod' => 2));
        }
    }
}

?>