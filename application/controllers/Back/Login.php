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
        $this->load->view('back/login/login');
    }

    /*
     * 登录验证
     */
    public function ValidateLogin()
    {
        $user_account = trim($_POST['user_account']);
        $user_password = trim($_POST['user_password']);
        $equal = array('phone' => $user_account);
        $back = $this->Universal_model->FetchOne('user',$equal);
        if($back != null){
            if($back['password'] == md5(md5('leren').md5($user_password))){
                $user = $this->db->select('a.*,b.name as com_name,b.id as com_id')
                    ->from('user as a')
                    ->join('company as b','a.id = b.user_id','left')
                    ->where('a.id',$back['id'])
                    ->get()->row_array();
                $_SESSION['back_user'] = $user;
                $res = array('status' => '1','msg' => '登陆成功，正在跳转!');
            }else{
                $res = array('status' => '2','msg' => '用户名或密码不正确,请重试！');
            }
        }else{
            $res = array('status' => 3,'msg' => '用户不存在!');
        }
        echo json_encode($res);
    }

    public function Logout()
    {
        unset($_SESSION['back_user']);
        $res = array('status' => 1);
        echo json_encode($res);
    }
}

?>