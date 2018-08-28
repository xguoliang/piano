<?php

class Bandsman extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->is_login();
    }

    public function PBandsmanIndex() {
        $data['detail'] = $this->Develop_model->GetRow('bandsman', array('user_id' => $_SESSION['lerenuser']['id']));
        if (!isset($data['detail']['id'])) {
            $this->Develop_model->InsertTable('bandsman', array('user_id' => $_SESSION['lerenuser']['id'], 'name' => "", 'phone' => $_SESSION['lerenuser']['phone']));
            $data['detail'] = $this->Develop_model->GetRow('bandsman', array('user_id' => $_SESSION['lerenuser']['id']));
        }
        $instrument = $this->Develop_model->GetRow('instrument', array('id' => $data['detail']['instrument_id']));
        $data['detail']['instrument'] = $instrument['name'];
        $data['guanzhu'] = count($this->Bandsman_model->GetCollectBandAndBandsman($_SESSION['lerenuser']['id']));
        $data['collect_count'] = count($this->Develop_model->GetResult('collect', array('user_id' => $_SESSION['lerenuser']['id'])));
        $data['order_count'] = count($this->Develop_model->GetResult('orders', array('user_id' => $_SESSION['lerenuser']['id'])));
        $_SESSION['lerenuser']['bandsman_id'] = $data['detail']['id'];
        $_SESSION['lerenuser']['roler'] = 2;
        $this->prender('phone/bandsman/bandsman_index', $data, array('title' => '乐手'));
    }

    public function PChangeBandsman() {
        $data['instrument'] = $this->Develop_model->GetAllResult('instrument');
        $data['detail'] = $this->Develop_model->GetRow('bandsman', array('user_id' => $_SESSION['lerenuser']['id']));
        $this->prender('phone/bandsman/change_bandsman', $data, array('title' => '信息编辑'));
    }

    public function UpdateBandsman() {
        $id = $_SESSION['lerenuser']['bandsman_id'];
        $data['headimg'] = str_replace(base_url(), "", $_POST['headimg']);
        $data['name'] = $_POST['name'];
        $data['phone'] = $_POST['phone'];
        $data['sex'] = $_POST['sex'];
        $data['instrument_id'] = $_POST['instrument_id'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->UpdateTable('bandsman', 'id', $id, $data);
        echo 1;
    }

    public function PMyConcern() {
        $data['bandsman'] = $this->Develop_model->GetResult('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_type' => 10));
        $data['band'] = $this->Develop_model->GetResult('collect', array('user_id' => $_SESSION['lerenuser']['id'], 'entity_type' => 11));
        $bandsman_id = array();
        $band_id = array();
        for ($i = 0; $i < count($data['bandsman']); $i++) {
            array_push($bandsman_id, $data['bandsman'][$i]['entity_id']);
        }
        for ($i = 0; $i < count($data['band']); $i++) {
            array_push($band_id, $data['band'][$i]['entity_id']);
        }
        $bandsman = $this->Bandsman_model->BandsmanIdsGetBandsman($bandsman_id);
        for ($i = 0; $i < count($data['bandsman']); $i++) {
            for ($j = 0; $j < count($bandsman); $j++) {
                if ($data['bandsman'][$i]['entity_id'] == $bandsman[$j]['id']) {
                    $data['bandsman'][$i]['headimg'] = $bandsman[$j]['headimg'];
                    $data['bandsman'][$i]['name'] = $bandsman[$j]['name'];
                    $data['bandsman'][$i]['instrument'] = $bandsman[$j]['instrument_name'];
                    break;
                }
            }
        }
        $band = $this->Bandsman_model->BandIdsGetBand($band_id);
        for ($i = 0; $i < count($data['band']); $i++) {
            for ($j = 0; $j < count($band); $j++) {
                if ($data['band'][$i]['entity_id'] == $band[$j]['id']) {
                    $data['band'][$i]['headimg'] = $band[$j]['headimg'];
                    $data['band'][$i]['name'] = $band[$j]['name'];
                    break;
                }
            }
        }
        $this->prender('phone/bandsman/my_concern', $data, array('title' => '我的关注'));
    }

    public function PBandsmanCollect() {
        $this->prender('phone/bandsman/collect', $data, array('我的收藏'));
    }

    public function MyCollectProduct() {
        $this->SelectCollectProduct();
    }

    public function MyCollectLesson() {
        $this->SelectCollectLesson();
    }

    public function MyCollectActivity() {
        $this->SelectCollectActivity();
    }

    public function BandsmanDeleteCollect() {
        $this->DeleteCollect();
    }

    public function PMyBand() {
        $data['band'] = $this->Develop_model->GetResult('band', array('bandsman_id' => $_SESSION['lerenuser']['bandsman_id']));
        $data['apply'] = $this->Develop_model->GetResult('view_band_bandsman', array('bandsman_id' => $_SESSION['lerenuser']['bandsman_id']));
        $this->prender('phone/bandsman/my_band', $data, array('title' => '乐队组建'));
    }

    public function BandMember() {
        $id = $data['id'] = $_GET['id'];
        $band = $this->Develop_model->GetRow('band', array('id' => $id));
        if ($band['bandsman_id'] == $_SESSION['lerenuser']['bandsman_id']) {
            $data['me'] = $this->Bandsman_model->BandsmanIdGetBandsman($_SESSION['lerenuser']['bandsman_id']);
            $data['bandsman'] = $this->Develop_model->GetResult('view_band_bandsman_bandsman', array('band_id' => $id, 'status' => 1));
            $data['apply'] = $this->Develop_model->GetResult('view_band_bandsman_bandsman', array('band_id' => $id, 'status' => 0));
            $this->prender('phone/bandsman/band_member', $data, array('title' => '乐队成员'));
        } else {
            echo '你没有权限';
        }
    }

    public function AgreeBandMember() {
        $band_id = $_POST['band_id'];
        $bandsman_id = $_POST['bandsman_id'];
        $this->Bandsman_model->AgreeBandMember($band_id, $bandsman_id);
        echo 1;
    }

    public function DenyBandMember() {
        $band_id = $_POST['band_id'];
        $bandsman_id = $_POST['bandsman_id'];
        $this->Bandsman_model->DenyBandMember($band_id, $bandsman_id);
        echo 1;
    }

    public function PAddBand() {
        $data['detail'] = $this->Develop_model->GetRow('bandsman', array('user_id' => $_SESSION['lerenuser']['id']));
        if (!isset($data['detail']['id'])) {
            $this->Develop_model->InsertTable('bandsman', array('user_id' => $_SESSION['lerenuser']['id'], 'name' => "", 'phone' => $_SESSION['lerenuser']['phone']));
            $data['detail'] = $this->Develop_model->GetRow('bandsman', array('user_id' => $_SESSION['lerenuser']['id']));
        }
        $this->prender('phone/bandsman/add_band', $data, array('title' => '发布乐队组建'));
    }

    public function InsertBand() {
        date_default_timezone_set('Asia/Shanghai');
        $data['add_time'] = (string) date("Y-m-d H:i:s");
        $data['bandsman_id'] = $_SESSION['lerenuser']['bandsman_id'];
        $data['name'] = $_POST['name'];
        $data['end_time'] = $_POST['end_time'];
        $data['need'] = $_POST['need'];
        $this->Develop_model->InsertTable('band', $data);
        echo 1;
    }

    public function PChangeBand() {
        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('band', array('id' => $id));
        if ($data['detail']['bandsman_id'] == $_SESSION['lerenuser']['bandsman_id']) {
            $this->prender('phone/bandsman/change_band', $data, array('title' => '编辑乐队组建'));
        } else {
            echo '你没有权限';
        }
    }

    public function UpdateBand() {
        $id = $_POST['id'];
        $data['bandsman_id'] = $_SESSION['lerenuser']['bandsman_id'];
        $data['name'] = $_POST['name'];
        $data['end_time'] = $_POST['end_time'];
        $data['need'] = $_POST['need'];
        $this->Develop_model->UpdateTable('band', 'id', $id, $data);
        echo 1;
    }

    public function DeleteBand() {
        $id = $_POST['id'];
        $this->Develop_model->DeleteTable('band', array('id' => $id));
        $this->Develop_model->DeleteTable('band_bandsman', array('band_id' => $id));
        echo 1;
    }

    public function DeleteApply() {
        $id = $_POST['id'];
        $this->Develop_model->DeleteTable('band_bandsman', array('id' => $id));
        echo 1;
    }

    public function PMyCompanionship() {
        $data['companionship'] = $this->Develop_model->GetOrderResult('companionship', array('bandsman_id' => $_SESSION['lerenuser']['bandsman_id']), 'add_time', 'desc');
        $data['apply'] = $this->Develop_model->GetOrderResult('view_companionship_bandsman', array('bandsman_id' => $_SESSION['lerenuser']['bandsman_id']), 'add_time', 'desc');
        $this->prender('phone/bandsman/my_companionship', $data, array('title' => '陪伴练习'));
    }

    public function PAddCampanionship() {
        $data['detail'] = $this->Develop_model->GetRow('bandsman', array('user_id' => $_SESSION['lerenuser']['id']));
        if (!isset($data['detail']['id'])) {
            $this->Develop_model->InsertTable('bandsman', array('user_id' => $_SESSION['lerenuser']['id'], 'name' => "", 'phone' => $_SESSION['lerenuser']['phone']));
            $data['detail'] = $this->Develop_model->GetRow('bandsman', array('user_id' => $_SESSION['lerenuser']['id']));
        }
        $this->prender('phone/bandsman/add_campanionship', $data, array('title' => '发布陪伴练习'));
    }

    public function InsertCampanionship() {
        date_default_timezone_set('Asia/Shanghai');
        $data['add_time'] = (string) date("Y-m-d H:i:s");
        $data['bandsman_id'] = $_SESSION['lerenuser']['bandsman_id'];
        $data['name'] = $_POST['name'];
        $data['companionship_time'] = $_POST['companionship_time'];
        $data['phone'] = $_POST['phone'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->InsertTable('companionship', $data);
        echo 1;
    }

    public function PChangeCampanionship() {
        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('companionship', array('id' => $id));
        if ($data['detail']['bandsman_id'] == $_SESSION['lerenuser']['bandsman_id']) {
            $this->prender('phone/bandsman/change_campanionship', $data, array('title' => '编辑陪伴练习'));
        } else {
            echo '你没有权限';
        }
    }

    public function UpdateCampanionship() {
        $id = $_POST['id'];
        $data['name'] = $_POST['name'];
        $data['companionship_time'] = $_POST['companionship_time'];
        $data['phone'] = $_POST['phone'];
        $data['area'] = $_POST['area'];
        $data['address'] = $_POST['address'];
        $data['desc'] = $_POST['desc'];
        $this->Develop_model->UpdateTable('companionship', 'id', $id, $data);
        echo 1;
    }

    public function PApplyMe() {
        $id = $_GET['id'];
        $data['apply'] = $this->Develop_model->GetResult("companionship_bandsman", array('companionship_id' => $id));
        $bandsman_id = array();
        for ($i = 0; $i < count($data['apply']); $i++) {
            array_push($bandsman_id, $data['apply'][$i]['bandsman_id']);
        }
        $bandsman = $this->Bandsman_model->BandsmanIdsGetBandsman($bandsman_id);
        for ($i = 0; $i < count($data['apply']); $i++) {
            for ($j = 0; $j < count($bandsman); $j++) {
                if ($data['apply'][$i]['bandsman_id'] == $bandsman[$j]['id']) {
                    $data['apply'][$i]['bandsman'] = $bandsman[$j];
                }
            }
        }
        $this->prender('phone/bandsman/apply_me', $data, array('title' => '陪伴邀请'));
    }

    public function AgreeCampanionshipApply() {
        $id = $_POST['id'];
        $detail = $this->Develop_model->GetRow('companionship_bandsman', array('id' => $id));
        $this->Bandsman_model->AgreeCampanionship($detail['companionship_id'], $detail['bandsman_id']);
        echo 1;
    }

    public function DenyCampanionshipApply() {
        $id = $_POST['id'];
        $this->Develop_model->UpdateTable('companionship_bandsman', 'id', $id, array('status' => 2));
        echo 1;
    }

    public function DeleteCampanionship() {
        $id = $_POST['id'];
        $this->Develop_model->DeleteTable('companionship', array('id' => $id));
        echo 1;
    }

    public function CancelCamponionshipApply() {
        $id = $_POST['id'];
        $this->Develop_model->DeleteTable('companionship_bandsman', array('id' => $id));
        echo 1;
    }

    public function PMyWorks() {
        $data['works'] = $this->Develop_model->GetOrderResult('works', array('bandsman_id' => $_SESSION['lerenuser']['bandsman_id']), 'add_time', 'desc');
        $this->prender('phone/bandsman/my_works', $data, array('title' => '发布作品'));
    }

    public function PAddWorks() {
        $this->prender('phone/bandsman/add_works', $data, array('title' => '发布作品'));
    }

    public function InsertWorks() {
        date_default_timezone_set('Asia/Shanghai');
        $data['add_time'] = (string) date("Y-m-d H:i:s");
        $data['bandsman_id'] = $_SESSION['lerenuser']['bandsman_id'];
        $data['name'] = $_POST['name'];
        $data['url'] = str_replace(base_url(), "", $_POST['url']);
        $houzhui = strtolower(strrchr($data['url'], "."));
        if (in_array($houzhui, array(".mp3", ".ogg"))) {
            $data['type'] = 1;
        } else {
            $data['type'] = 2;
        }
        $this->Develop_model->InsertTable('works', $data);
        echo 1;
    }

    public function PChangeWorks() {
        $id = $_GET['id'];
        $data['detail'] = $this->Develop_model->GetRow('works', array('id' => $id));
        if ($data['detail']['bandsman_id'] == $_SESSION['lerenuser']['bandsman_id']) {
            $this->prender('phone/bandsman/change_works', $data, array('title' => '发布作品'));
        } else {
            echo '你没有权限';
        }
    }

    public function UpdateWorks() {
        $id = $_POST['id'];
        $data['name'] = $_POST['name'];
        $data['url'] = $_POST['url'];
        $houzhui = strtolower(strrchr($data['url'], "."));
        if (in_array($houzhui, array(".mp3", ".ogg", ".wav"))) {
            $data['type'] = 1;
        } else {
            $data['type'] = 2;
        }
        $this->Develop_model->UpdateTable('works', 'id', $id, $data);
        echo 1;
    }

    public function DeleteWorks() {
        $id = $_POST['id'];
        $this->Develop_model->DeleteTable('works', array('id' => $id));
        echo 1;
    }

    public function PerformBusiness() {
        $data['detail'] = $this->Develop_model->GetRow('business', array('bandsman_id' => $_SESSION['lerenuser']['bandsman_id']));
        if (!isset($data['detail']['id'])) {
            $data['detail']['coverimg'] = "";
            $data['detail']['name'] = "";
            $data['detail']['price'] = "";
            $data['detail']['type'] = 0;
            $data['detail']['phone'] = "";
            $data['detail']['desc'] = "";
        }
        $this->prender('phone/bandsman/perform_business', $data, array('title' => '演出买卖'));
    }

    public function SaveBusiness() {
        $data['bandsman_id'] = $_SESSION['lerenuser']['bandsman_id'];
        $data['coverimg'] = str_replace(base_url(), "", $_POST['coverimg']);
        $data['name'] = $_POST['name'];
        $data['price'] = $_POST['price'];
        $data['type'] = $_POST['type'];
        $data['phone'] = $_POST['phone'];
        $data['desc'] = $_POST['desc'];
        if (count($this->Develop_model->GetResult('business', array('bandsman_id' => $_SESSION['lerenuser']['bandsman_id']))) == 0) {
            $this->Develop_model->InsertTable('business', $data);
        } else {
            $this->Develop_model->UpdateTable('business', 'bandsman_id', $_SESSION['lerenuser']['bandsman_id'], $data);
        }
        echo 1;
    }

}

?>