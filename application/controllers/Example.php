<?php

class Example extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    public function mkFolder($cat) {
        $upFilePath = "./uploads/";
        if (!is_readable($upFilePath)) {
            is_file($upFilePath) or mkdir($upFilePath);
            chmod($upFilePath, 0777);
        }
        $cate = $upFilePath;
        $cats = explode('/', $cat);
        for ($i = 0; $i < count($cats); $i++) {
            $cate = $cate . $cats[$i] . "/";
            if (!is_readable($cate)) {
                is_file($cate) or mkdir($cate);
                chmod($cate, 0777);
            }
        }
        return $cate;
    }

    public function checkFileType($ty, $type) {
        $fileType = strrchr($ty, ".");
        $fileType1 = strtolower($fileType);
        if (!in_array($fileType1, $type)) {
            echo 2;
            exit;
        }
    }

    public function UploadImage() {
        $id = $_GET['id'];
        $maker = urldecode($_GET['maker']);
        $cate = $this->mkFolder($maker);
        if (!empty($_FILES['files']['name'])) {
            $fileinfo = $_FILES['files'];
            $tmp_name = $fileinfo['tmp_name'];
            $type = array(".jpg", ".png", ".bmp", '.jpeg');
            $this->checkFileType($_FILES['files']['name'], $type);
            if ($fileinfo['size'] < 10000000 && $fileinfo['size'] > 0) {
                $filepaths = $cate . time() . '_' . mt_rand(10000, 99999) . strrchr($fileinfo['name'], ".");
                $filepath = iconv("UTF-8", "gb2312", $filepaths);
                move_uploaded_file($tmp_name, $filepath);
                $data = array();
                array_push($data, $id, $filepaths, round($fileinfo['size'] / 1024, 2));
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            } else {
                echo 3;
            }
        } else {
            echo 1;
        }
    }

    public function UploadMusic() {
        $id = $_GET['id'];
        $maker = urldecode($_GET['maker']);
        $cate = $this->mkFolder($maker);
        if (!empty($_FILES['files']['name'])) {
            $fileinfo = $_FILES['files'];
            $tmp_name = $fileinfo['tmp_name'];
            $type = array(".mp3", ".wav", ".MP3", '.WAV');
            $this->checkFileType($_FILES['files']['name'], $type);
            if ($fileinfo['size'] < 100000000 && $fileinfo['size'] > 0) {
                $filepaths = $cate . time() . '_' . mt_rand(10000, 99999) . strrchr($fileinfo['name'], ".");
                $filepath = iconv("UTF-8", "gb2312", $filepaths);
                move_uploaded_file($tmp_name, $filepath);
                $data = array();
                array_push($data, $id, $filepaths, round($fileinfo['size'] / 1024, 2));
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            } else {
                echo 3;
            }
        } else {
            echo 1;
        }
    }

    public function UploadVideo() {
        $id = $_GET['id'];
        $maker = urldecode($_GET['maker']);
        $cate = $this->mkFolder($maker);
        if (!empty($_FILES['files']['name'])) {
            $fileinfo = $_FILES['files'];
            $tmp_name = $fileinfo['tmp_name'];
            $type = array(".mp4", ".flv");
            $this->checkFileType($_FILES['files']['name'], $type);
            if ($fileinfo['size'] < 100000000 && $fileinfo['size'] > 0) {
                $filepaths = $cate . time() . '_' . mt_rand(10000, 99999) . strrchr($fileinfo['name'], ".");
                $filepath = iconv("UTF-8", "gb2312", $filepaths);
                move_uploaded_file($tmp_name, $filepath);
                $data = array();
                array_push($data, $id, $filepaths, round($fileinfo['size'] / 1024, 2));
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            } else {
                echo 3;
            }
        } else {
            echo 1;
        }
    }

    public function UploadMovie() {
        $id = $_GET['id'];
        $maker = urldecode($_GET['maker']);
        $cate = $this->mkFolder($maker);
        if (!empty($_FILES['files']['name'])) {
            $fileinfo = $_FILES['files'];
            $tmp_name = $fileinfo['tmp_name'];
            $type = array(".mp3", ".wav", ".mp4", ".flv");
            $this->checkFileType($_FILES['files']['name'], $type);
            if ($fileinfo['size'] < 100000000 && $fileinfo['size'] > 0) {
                $filepaths = $cate . time() . '_' . mt_rand(10000, 99999) . strrchr($fileinfo['name'], ".");
                $filepath = iconv("UTF-8", "gb2312", $filepaths);
                move_uploaded_file($tmp_name, $filepath);
                $data = array();
                array_push($data, $id, $filepaths, round($fileinfo['size'] / 1024, 2));
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            } else {
                echo 3;
            }
        } else {
            echo 1;
        }
    }

    public function shouquan() {
        $appid = "wx117a75a606df3140";
        $secret = "a9f4def7d69ad644706e19a339c4e020";
        $code = $_GET['code'];
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $get_token_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $a['open'] = json_decode($res, true);
        $openid = $a['open']['openid'];
        $access_token = $a['open']['access_token'];
        $get_information_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $get_information_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $info = curl_exec($ch);
        curl_close($ch);
        $user = json_decode($info, true);
//        $this->User_model->InsertUser($user['openid'], $user['nickname'], $user['headimgurl'], $user['sex']);
//        $headurl = base_url() . "index.php/User/User/Index";
        header("Location:$headurl");
    }

}

?>