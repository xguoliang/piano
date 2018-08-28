<?php

class Talent extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function PTalentRank() {
        $data['instrument'] = $this->Develop_model->GetAllOrderResult('instrument', 'sort', 'asc');
        $data['style'] = $this->Develop_model->GetAllResult('music_style');
        $data['name'] = isset($_GET['name']) ? $_GET['name'] : '';
        $this->prender('phone/talent/talent_rank', $data, array('title' => '达人精选'));
    }

    public function SelectTalent() {
        $role = $_POST['role'];
        $pagesize = $_POST['pagesize'];
        $pages = $_POST['pages'];
        $offset = ($pages - 1) * $pagesize;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        if ($role == 1) {
            $sex = $_POST['sex'];
            $instrument_id = $_POST['instrument_id'];
            $data = $this->Bandsman_model->SelectTalentBandsman($sex, $instrument_id, $pagesize, $offset,$name);
        } else {
            $music_style = $_POST['music_style'];
            $data = $this->Bandsman_model->SelectTalentBand($music_style, $pagesize, $offset);
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

}

?>