<?php

class Product extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Universal_model');
    }

    public function PFindGood() {
        $data['area'] = $this->GetArea('company', 0);
        $data['brand'] = $this->Develop_model->GetAllResult('brand', 'sort', 'asc');
        $this->prender('phone/product/find_good', $data, array('title' => '发现好货'));
    }

    public function SelectGood() {
        $area = $_POST['area'];
        $type = $_POST['type'];
        $min_price = $_POST['min_price'];
        $max_price = $_POST['max_price'];
        $sort_type = $_POST['sort_type'];
        $lng = $_POST['lng'];
        $lat = $_POST['lat'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        if ($type == 1) {
            $data = $this->Company_model->SelectGoodLesson($area, $min_price, $max_price, $sort_type, $lng, $lat, $pagesize, $offset);
        } else if ($type == 2) {
            $brand_id = isset($_POST['brand_id']) ? $_POST['brand_id'] : 0;
            $data = $this->Company_model->SelectGoodProduct($area, $min_price, $max_price, $brand_id, $sort_type, $lng, $lat, $pagesize, $offset);
        } else if ($type == 3) {
            $data = $this->Company_model->SelectGoodSiteLease($area, $min_price, $max_price, $sort_type, $lng, $lat, $pagesize, $offset);
        } else {
            
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PProductDetail() {
        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('product', array('id' => $id));
        $data['detail']['eva_count'] = $this->Universal_model->FetchCount('evaluate', array('product_id' => $id));
        $data['detail']['pro_count'] = $this->Universal_model->FetchCount('product', array('com_id' => $data['detail']['com_id']));
        $data['brand'] = $this->Develop_model->GetRow('brand', array('id' => $data['detail']['brand_id']));
        $data['company'] = $this->Develop_model->GetRow('company', array('id' => $data['detail']['com_id']));
        $data['company']['avg_star'] = floor($this->Company_model->GetAvgStar($data['company']['id']));
        $count = $this->db->select('count(0)')->from('product')->where('com_id', $data['detail']['com_id'])->get()->row_array();
        $data['comment'] = $this->db->select('*')->from('view_evaluate_orders_student')->where('product_id', $id)->order_by('add_time', 'desc')->limit(0, 1)->get()->row_array();
        $data['com_pro_count'] = $count;
        $data['recommed'] = $this->Universal_model->FetchPageData('product', 0, 4, array('com_id' => $data['detail']['com_id']), array(), array('salenum' => 'desc'));
        if (isset($_SESSION['lerenuser'])) {
            $collect = $this->Universal_model->FetchOne('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_type' => 9, 'entity_id' => $id));
            if ($collect == null) {
                $data['is_collect'] = 0;
            } else {
                $data['is_collect'] = 1;
            }
        } else {
            $data['is_collect'] = 0;
        }
        $this->prender('phone/product/product_detail', $data, array('title' => $data['detail']['name']));
    }

    public function AllEvaluation() {
        $id = $_GET['id'];
        $data['id'] = $id;
        $data['detail'] = $this->Develop_model->GetRow('product', array('id' => $id));
        $this->prender('phone/product/all_evaluation', $data, array('title' => $data['detail']['name'] . '的评论'));
    }

    //收藏
    public function ChangeCollect() {
        $equal = $_POST['equal'];
        if (isset($_SESSION['lerenuser'])) {
            $equal['user_id'] = $_SESSION['lerenuser']['id'];
            $one = $this->Universal_model->FetchOne('collect', $equal);
            if ($one == null) {
                $equal['add_time'] = date("Y-m-d H:i:s", time());
                $data['id'] = '';
                $data['save'] = $equal;
                $this->Universal_model->SaveOne('collect', 'id', $data);

                $res = array('status' => 1, 'ope' => 1);
            } else {
                $this->Universal_model->DeleteOne('collect', array('id' => $one['id']));
                $res = array('status' => 1, 'ope' => 2);
            }
        } else {
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

    //加入购物车
    public function AddToCart() {
        if (isset($_SESSION['lerenuser'])) {
            $save = $_POST['save'];
            $equal = array('entity_id' => $save['entity_id'], 'entity_type' => $save['entity_type']);
            $one = $this->Universal_model->FetchOne('cart', $equal);
            if ($one == null) {
                $this->Universal_model->SaveOne('cart', 'id', array('id' => '', 'save' => $save));
            } else {
                $num = $one['num'] + $save['num'];
                $save = array('num' => $num);
                $this->Universal_model->SaveOne('cart', 'id', array('id' => $one['id'], 'save' => $save));
            }
            $res = array('status' => 1);
        } else {
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

    //
    public function GetEvaluate() {
        $id = $_POST['id'];
        $limit = $_POST['limit'];
        $offset = ($_POST['page'] - 1) * $limit;
        $res = $this->db->select('*')->from('view_evaluate_orders_student')->where('product_id', $id)->order_by('add_time', 'desc')->limit($limit, $offset)->get()->result_array();
        echo json_encode($res);
    }

}

?>