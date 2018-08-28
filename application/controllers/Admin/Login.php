<?php

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    /*
     * 登录页面
     */
    public function Login()
    {
        $this->load->view('admin/login/login');
    }

    /*
     * 登录验证
     */
    public function ValidateLogin()
    {
        $user_account = trim($_POST['user_account']);
        $user_password = trim($_POST['user_password']);
        if($user_account == 'admin' && $user_password == 'qweqwe'){
            $_SESSION['piano_admin'] = 1;
            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

    public function LogOut()
    {
        unset($_SESSION['piano_admin']);
        $res = array('status' => 1);
        echo json_encode($res);
    }
}

?>