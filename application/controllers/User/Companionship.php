<?php

class Companionship extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function PCompanionshipList() {
        $data['area'] = $this->GetArea('companionship', 0);
        $data['instrument'] = $this->Develop_model->GetAllOrderResult('instrument', 'sort', 'asc');
        $this->prender('phone/companionship/companionship_list', $data, array('title' => '陪伴练习'));
    }

    public function SelectCompanionship() {
        $area = $_POST['area'];
        $instrument_id = $_POST['instrument_id'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $data = $this->Bandsman_model->SelectCompanionship($area, $instrument_id, $pagesize, $offset);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function ApplyCompanionship() {
        date_default_timezone_set('Asia/Shanghai');
        $add_time = (string) date("Y-m-d H:i:s");
        $companionship_id = $_POST['companionship_id'];
        $bandsman = $this->Develop_model->GetRow('bandsman', array('user_id' => $_SESSION['lerenuser']['id']));
        $detail = $this->Develop_model->GetRow('companionship', array('id' => $companionship_id));
        if ($detail['bandsman_id'] == $bandsman['id']) {
            echo 3;
            exit;
        }
        if (count($this->Develop_model->GetResult('companionship_bandsman', array('companionship_id' => $companionship_id, 'bandsman_id' => $bandsman['id']))) == 0) {
            $this->Develop_model->InsertTable('companionship_bandsman', array('companionship_id' => $companionship_id, 'bandsman_id' => $bandsman['id'], 'add_time' => $add_time));
            echo 1;
        } else {
            echo 2;
        }
    }

}

?>