<?php

class Activity extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Universal_model');
    }

    public function ActivityList() {
        $data['area'] = $this->GetArea('activity', 1);
        $this->prender('phone/activity/activity_list', $data, array('title' => '精彩活动'));
    }

    public function SelectActivity() {
        $area = $_POST['area'];
        $type = $_POST['type'];
        $min_price = $_POST['min_price'];
        $max_price = $_POST['max_price'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Company_model->SelectActivity($area, $type, $min_price, $max_price, $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function ActivityDetail() {
        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('activity', array('id' => $id));
        $count = $this->db->select('count(0) as collect_num')->from('collect')->where('entity_type',3)->where('entity_id',$id)->get()->row_array()['collect_num'];
        $data['detail']['count'] = $count;
        $one = $this->Universal_model->FetchOne('collect',array('entity_type' => 3,'entity_id' =>$id));
        if($one == null){
            $data['is_collect'] = 0;
        }else{
            $data['is_collect'] = 1;
        }
        $data['detail']['appointment'] = $this->db->select('count(0)')->from('orders_detail as od')->join('orders as o','od.order_id = o.id','left')->where('o.entity_type',3)->where('od.entity_id',$id)->get()->row_array()['count(0)'];
        $data['company'] = $this->Develop_model->GetRow('company', array('id' => $data['detail']['company_id']));
        $this->prender('phone/activity/activity_detail', $data, array('title' => '精彩活动'));
    }

    public function CollectActivity() {
        date_default_timezone_set('Asia/Shanghai');
        $add_time = (string) date("Y-m-d H:i:s");
        $id = $_POST['id'];
        if (!isset($_SESSION['lerenuser'])) {
            echo 2;
        }
        if (count($this->Develop_model->GetResult('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_id' => $id, 'entity_type' => 3))) == 0) {
            $this->Develop_model->InsertTable('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_id' => $id, 'entity_type' => 3, 'add_time' => $add_time));
        } else {
            $this->Develop_model->DeleteTable('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_id' => $id, 'entity_type' => 3));
        }
        echo 1;
    }

}

?>