<?php

class Rent extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->is_login();
    }

    public function PRentIndex() {
        $data['detail'] = $this->Develop_model->GetRow('rent', array('user_id' => $_SESSION['lerenuser']['id']));
        if (!isset($data['detail']['id'])) {
            $this->Develop_model->InsertTable('rent', array('user_id' => $_SESSION['lerenuser']['id'], 'name' => "", 'phone' => $_SESSION['lerenuser']['phone']));
            $data['detail'] = $this->Develop_model->GetRow('rent', array('user_id' => $_SESSION['lerenuser']['id']));
        }
        $data['collect_count'] = count($this->Develop_model->GetResult('collect', array('user_id' => $_SESSION['lerenuser']['id'])));
        $data['order_count'] = count($this->Develop_model->GetResult('orders', array('user_id' => $_SESSION['lerenuser']['id'])));
        $_SESSION['lerenuser']['rent_id'] = $data['detail']['id'];
        $_SESSION['lerenuser']['roler'] = 3;
        $this->prender('phone/rent/rent_index', $data, array('title' => '租赁方'));
    }

    public function PChangeRent() {
        $data['detail'] = $this->Develop_model->GetRow('rent', array('id' => $_SESSION['lerenuser']['rent_id']));
        $this->prender('phone/rent/change_rent', $data, array('title' => '信息编辑'));
    }

    public function UpdateRent() {
        $id = $_SESSION['lerenuser']['rent_id'];
        $data['headimg'] = str_replace(base_url(), "", $_POST['headimg']);
        $data['name'] = $_POST['name'];
        $data['phone'] = $_POST['phone'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->UpdateTable('rent', 'id', $id, $data);
        echo 1;
    }

    public function PLeaseList() {
        $data['instrument'] = $this->Develop_model->GetAllResult('instrument');
        $this->prender('phone/rent/lease_list', $data, array('title' => '设备租赁'));
    }

    public function SelectLease() {
        $search = $_POST['search'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Rent_model->SelectLease($_SESSION['lerenuser']['rent_id'], $search, $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PAddLease() {
        $data['instrument'] = $this->Develop_model->GetAllResult('instrument');
        $this->prender('phone/rent/add_lease', $data, array('title' => '发布设备租赁'));
    }

    public function InsertLease() {
        date_default_timezone_set('Asia/Shanghai');
        $data['add_time'] = (string) date("Y-m-d H:i:s");
        $data['rent_id'] = $_SESSION['lerenuser']['rent_id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['start_time'] = $_POST['start_time'];
        $data['end_time'] = $_POST['end_time'];
        $data['money'] = $_POST['money'];
        $data['phone'] = $_POST['phone'];
        $data['instrument_id'] = $_POST['instrument_id'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->InsertTable('lease', $data);
        echo 1;
    }

    public function PChangeLease() {
        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('lease', array('id' => $id));
        $data['instrument'] = $this->Develop_model->GetAllResult('instrument');
        if ($data['detail']['rent_id'] == $_SESSION['lerenuser']['rent_id']) {
            $this->prender('phone/rent/change_lease', $data, array('title' => '编辑设备租赁'));
        } else {
            echo '你没有权限';
        }
    }

    public function UpdateLease() {
        $id = $_POST['id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['start_time'] = $_POST['start_time'];
        $data['end_time'] = $_POST['end_time'];
        $data['money'] = $_POST['money'];
        $data['phone'] = $_POST['phone'];
        $data['instrument_id'] = $_POST['instrument_id'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->UpdateTable('lease', 'id', $id, $data);
        echo 1;
    }

    public function DeleteLease() {
        $id = $_POST['id'];
        $this->Develop_model->UpdateTable('rent', 'id', $id, array('is_delete' => 1));
        echo 1;
    }

    public function PSiteLease() {
        $this->prender('phone/rent/site_lease', $data, array('title' => '场地租赁'));
    }

    public function SelectSiteLease() {
        $search = $_POST['search'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Rent_model->SelectSiteLease($_SESSION['lerenuser']['rent_id'], $search, $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PAddSiteLease() {
        $data['instrument'] = $this->Develop_model->GetAllResult('instrument');
        $this->prender('phone/rent/add_site_lease', $data, array('title' => '发布场地租赁'));
    }

    public function InsertSiteLease() {
        date_default_timezone_set('Asia/Shanghai');
        $data['add_time'] = (string) date("Y-m-d H:i:s");
        $data['rent_id'] = $_SESSION['lerenuser']['rent_id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['start_time'] = $_POST['start_time'];
        $data['end_time'] = $_POST['end_time'];
        $data['money'] = $_POST['money'];
        $data['phone'] = $_POST['phone'];
        $data['type'] = $_POST['instrument_id'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->InsertTable('site_lease', $data);
        echo 1;
    }

    public function PChangeSiteLease() {
        $id = $_GET['id'];
        $data['instrument'] = $this->Develop_model->GetAllResult('instrument');
        $data['detail'] = $this->Develop_model->GetRow('site_lease', array('id' => $id));
        if ($data['detail']['rent_id'] = $_SESSION['lerenuser']['rent_id']) {
            $this->prender('phone/rent/change_site_lease', $data, array('title' => '编辑场地租赁'));
        } else {
            echo '你没有权限';
        }
    }

    public function UpdateSiteLease() {
        $id = $_POST['id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['start_time'] = $_POST['start_time'];
        $data['end_time'] = $_POST['end_time'];
        $data['money'] = $_POST['money'];
        $data['phone'] = $_POST['phone'];
        $data['type'] = $_POST['instrument_id'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->UpdateTable('site_lease', 'id', $id, $data);
        echo 1;
    }

    public function DeleteSiteLease() {
        $id = $_POST['id'];
        $this->Develop_model->UpdateTable('site_lease', 'id', $id, array('is_delete' => 1));
        echo 1;
    }

    public function MyCollect() {
        $this->SelectCollectProduct();
    }

    public function RentDeleteCollect() {
        $this->DeleteCollect();
    }

}

?>