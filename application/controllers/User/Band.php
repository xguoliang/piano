<?php

class Band extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function PBandList() {
        $data['instrument'] = $this->Develop_model->GetAllResult('instrument');
        $data['name'] = isset($_GET['name']) ? $_GET['name'] : '';
        $this->prender('phone/band/band_list', $data, array('title' => '乐队组建'));
    }

    public function SelectBand() {
        date_default_timezone_set('Asia/Shanghai');
        $add_time = (string) date("Y-m-d");
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $name = $_POST['name'];
        $need = $_POST['need'];
        $data = $this->Bandsman_model->SelectBand($pagesize, $offset, $name, $need);
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['end_time'] >= $add_time) {
                $data[$i]['status'] = 0;
            } else {
                $data[$i]['status'] = 1;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function PBandDetail() {
        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('band', array('id' => $id));
        $data['chuangshi'] = $this->Bandsman_model->BandsmanIdGetBandsman($data['detail']['bandsman_id']);
        $data['member'] = $this->Develop_model->GetResult('view_band_bandsman_bandsman', array('band_id' => $id, 'status' => 1));
        $this->prender('phone/band/band_detail', $data, array('title' => $data['detail']['name']));
    }

    public function ApplyBand() {
        date_default_timezone_set('Asia/Shanghai');
        $add_time = (string) date("Y-m-d H:i:s");
        $id = $_POST['id'];
        if (isset($_SESSION['lerenuser'])) {
            $bandsman = $this->Develop_model->GetRow('bandsman', array('user_id' => $_SESSION['lerenuser']['id']));
            if (isset($bandsman['id'])) {
                $detail = $this->Develop_model->GetRow('band', array('id' => $id));
                if ($detail['bandsman_id'] == $bandsman['id']) {
                    echo 5;
                    exit;
                }
                if (count($this->Develop_model->GetResult('band_bandsman', array('bandsman_id' => $bandsman['id'], 'band_id' => $id))) == 0) {
                    $this->Develop_model->InsertTable('band_bandsman', array('band_id' => $id, 'bandsman_id' => $bandsman['id'], 'add_time' => $add_time));
                    echo 1;
                } else {
                    echo 3;
                }
            } else {
                echo 2;
            }
        } else {
            echo 4;
        }
    }

    public function BandsmanDetail() {
        $id = $_GET['id'];
        $data['detail'] = $this->Bandsman_model->BandsmanIdGetBandsman($id);
        $data['business'] = $this->Develop_model->GetRow('business', array('bandsman_id' => $id));
        $this->prender('phone/band/bandsman_detail', $data, array('title' => '乐手详情'));
    }

    public function CollectBandsman() {
        $id = $_POST['id'];
        if (isset($_SESSION['lerenuser']['id'])) {
            $this->InsertCollect($_SESSION['lerenuser']['id'], $id, 10);
            echo 1;
        } else {
            echo 2;
        }
    }

}

?>