<?php

class Login extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Universal_model');
    }

    public function PLogin() {
        if (!isset($_GET['history'])) {
            $data['history'] = 0;
        } else {
            $data['history'] = $_GET['history'];
        }
        $this->prender('phone/login', $data, array('title' => '登录'));
    }

    public function ValidateLogin() {
        $data['phone'] = $_POST['phone'];
        $data['password'] = md5(md5("leren") . md5($_POST['password']));
        if (count($this->Develop_model->GetResult('user', $data)) > 0) {
            $_SESSION['lerenuser'] = $this->Develop_model->GetRow('user', $data);
            echo 1;
        } else {
            echo 2;
        }
    }

    public function PRegister() {
        $this->prender('phone/register', $data, array('title' => '注册'));
    }

    public function RegisterSendSms() {
        $phone = $_POST['phone'];
        if (count($this->Develop_model->GetResult('user', array('phone' => $phone))) == 0) {
            $this->load->library('sms');
            $this->sms->smss("23760962", "8e74eac142cc501215002fad6b4037e1", 1, $phone, "");
            echo 1;
        } else {
            echo 2;
        }
    }

    public function ForgetSendSms() {
        $phone = $_POST['phone'];
        if (count($this->Develop_model->GetResult('user', array('phone' => $phone))) > 0) {
            $this->load->library('sms');
            $this->sms->smss("23760962", "8e74eac142cc501215002fad6b4037e1", 1, $phone, "");
            echo 1;
        } else {
            echo 2;
        }
    }

    public function InsertUser() {
        date_default_timezone_set('Asia/Shanghai');
        $data['add_time'] = (string) date("Y-m-d H:i:s");
        $data['phone'] = $_POST['phone'];
        $data['password'] = md5(md5("leren") . md5($_POST['password']));
        $vcode = $_POST['vcode'];

        if (count($this->Develop_model->GetResult('user', array('phone' => $data['phone']))) == 0) {
            if ($vcode == $_SESSION['vcode']) {
                $this->Develop_model->InsertTable('user', $data);
                $id = $this->db->insert_id('id');
                $message = array(
                    'user_id' => $id,
                    'title' => '来自系统的一封信',
                    'desc' => '欢饮注册琴行平台!',
                    'is_read' => 0,
                    'add_time' => date("Y-m-d H:i:s", time())
                );
                $this->Develop_model->InsertTable('message', $message);
                $_SESSION['lerenuser'] = $this->Develop_model->GetRow('user', array('id' => $id));
                echo 1;
            } else {
                echo 3;
            }
        } else {
            echo 2;
        }
    }

    public function PForgetPassword() {
        $this->prender('phone/forget_password', $data, array('title' => '忘记密码'));
    }

    public function ValidateForgetPassword() {
        $phone = $_POST['phone'];
        $data['password'] = md5(md5('leren') . md5($_POST['password']));
        $vcode = $_POST['vcode'];
        if (count($this->Develop_model->GetResult('user', array('phone' => $phone))) > 0) {
            if ($vcode == $_SESSION['vcode']) {
                $this->Develop_model->UpdateTable('user', 'phone', $phone, $data);
                unset($_SESSION['lerenuser']);
                echo 1;
            } else {
                echo 3;
            }
        } else {
            echo 2;
        }
    }

    public function PChooseRole() {
        $this->prender('phone/choose_role', $data, array('title' => '选择角色'));
    }

    public function My() {
        if (isset($_SESSION['lerenuser'])) {
            if (isset($_SESSION['lerenuser']['roler'])) {
                if ($_SESSION['lerenuser']['roler'] == 1) {
                    header("Location:" . base_url() . "User/Company/PCompanyIndex.html");
                    exit;
                } else if ($_SESSION['lerenuser']['roler'] == 2) {
                    header("Location:" . base_url() . "User/Bandsman/PBandsmanIndex.html");
                    exit;
                } else if ($_SESSION['lerenuser']['roler'] == 3) {
                    header("Location:" . base_url() . "User/Rent/PRentIndex.html");
                    exit;
                } else if ($_SESSION['lerenuser']['roler'] == 4) {
                    header("Location:" . base_url() . "User/Student/PStudentIndex.html");
                    exit;
                } else {
                    
                }
            } else {
                header("Location:" . base_url() . "User/Login/PChooseRole.html");
                exit;
            }
        } else {
            header("Location:" . base_url() . "User/Login/PLogin.html");
            exit;
        }
    }

    public function PSet() {
        $this->is_login();
        $this->prender('phone/set', $data, array('title' => '设置'));
    }

    public function Logout() {
        session_destroy();
        echo "<script>window.location.href='" . base_url() . "User/Login/PLogin.html';</script>";
    }

    public function PChangePassword() {
        $this->is_login();
        $this->prender('phone/change_password', $data, array('title' => '修改密码'));
    }

    public function PChangePhone() {
        $this->is_login();
        $this->prender('phone/change_phone', $data, array('title' => '修改手机号码'));
    }

    public function UpdatePassword() {
        $old_pass = $_POST['old_pass'];
        $new_pass = $_POST['new_pass'];
        if (md5(md5("leren") . md5($old_pass)) == $_SESSION['lerenuser']['password']) {
            $this->Develop_model->UpdateTable('user', 'id', $_SESSION['lerenuser']['id'], array('password' => md5(md5("leren") . md5($new_pass))));
            $_SESSION['lerenuser'] = $this->Develop_model->GetRow('user', array('id' => $_SESSION['lerenuser']['id']));
            echo 1;
        } else {
            echo 2;
        }
    }

    public function ChangePhoneSms() {
        if (isset($_SESSION['lerenuser'])) {
            $phone = $_SESSION['lerenuser']['phone'];
            if ($phone == $_POST['phone']) {
                $one = $this->Universal_model->FetchOne('user', array('phone' => $phone));
                if ($one == null) {
                    $res = array('status' => 3);
                    echo json_encode($res);
                    exit;
                }
                $_SESSION['canuse'] = 1;
                $this->load->library('sms');
                $this->sms->smss("23760962", "8e74eac142cc501215002fad6b4037e1", 1, $one['phone'], "");
                $res = array('status' => 1);
            } else {
                $res = array('status' => 3);
            }
        } else {
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

    public function ValidateChangePhone() {
        $vcode = $_POST['vcode'];
        if (isset($_SESSION['lerenuser'])) {
            if (isset($_SESSION['vcode'])) {
                if ($vcode == $_SESSION['vcode']) {
                    $res = array('status' => 1);
                } else {
                    $res = array('status' => 4);
                }
            } else {
                $res = array('status' => 3);
            }
        } else {
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

    public function ChangePhone() {
        if (isset($_SESSION['canuse'])) {
            unset($_SESSION['canuse']);
            unset($_SESSION['vcode']);

            $this->prender('phone/input_phone', $data, array('title' => '修改手机号码'));
        } else {
            echo "<script>alert('参数错误，请重新验证！');window.location.href = '" . base_url() . "User/Login/PChangePhone.html'</script>";
        }
    }

    public function sendsms() {

        if (isset($_SESSION['lerenuser'])) {
            $one = $this->Universal_model->FetchOne('user', array('phone' => $_POST['phone']));
            if ($one != null) {
                $res = array('status' => 3);
                echo json_encode($res);
            }
            $phone = $_POST['phone'];
            $this->load->library('sms');
            $this->sms->smss("23760962", "8e74eac142cc501215002fad6b4037e1", 1, $phone, "");
            $res = array('status' => 1);
        } else {
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

    public function validatenewphone() {
        if (isset($_SESSION['lerenuser'])) {
            $one = $this->Universal_model->FetchOne('user', array('phone' => $_POST['phone']));
            if ($one != null) {
                $res = array('status' => 5);
                echo json_encode($res);
            }
            if (isset($_SESSION['vcode'])) {
                $vcode = $_POST['vcode'];
                $phone = $_POST['phone'];
                if ($vcode == $_SESSION['vcode']) {
                    $res = array('status' => 1);
                    $this->db->where('id', $_SESSION['lerenuser']['id'])->set('phone', $phone)->update('user');
                    unset($_SESSION['lerenuser']);
                } else {
                    $res = array('status' => 3);
                }
            } else {
                $res = array('status' => 4);
            }
        } else {
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

}
