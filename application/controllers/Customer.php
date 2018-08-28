<?php

class Customer extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    /*
     * 客户管理页面
     */
    public function CustomerList()
    {
        $data = array();
        $this->render('customer/customer_list', $data, array('title' => '客户管理', 'index_module_id' => 2));
    }

    /*
     * 获取客户信息
     */
    public function FetchCount()
    {
        $or_like = $_POST['or_like'];
        if($_SESSION['zx_crm_user']['user_role_id'] == 1){
            $sql = 'select c.*,u.user_name from client as c left join user as u on c.cli_user_id = u.user_id where c.cli_nickname like "%'
                . $or_like['cli_nickname'] . '%" or c.cli_company like "%' . $or_like['cli_nickname'] . '%" or c.cli_phone like "%' . $or_like['cli_nickname'] . '%"'
                . 'order by if(c.cli_remind>' . time() . ',0,1) ASC,c.cli_remind ASC,c.cli_created_at DESC';
        }else if($_SESSION['zx_crm_user']['user_role_id'] == 2){
            $ids = $_SESSION['zx_crm_user']['user_unserling_ids'];
            $sql = 'select c.*,u.user_name from client as c left join user as u on c.cli_user_id = u.user_id where cli_user_id in ('.$ids.') and (c.cli_nickname like "%'
                . $or_like['cli_nickname'] . '%" or c.cli_company like "%' . $or_like['cli_nickname'] . '%" or c.cli_phone like "%' . $or_like['cli_nickname'] . '%")'
                . 'order by if(c.cli_remind>' . time() . ',0,1) ASC,c.cli_remind ASC,c.cli_created_at DESC';
        }else{
            $id = $_SESSION['zx_crm_user']['user_id'];
            $sql = 'select c.*,u.user_name from client as c left join user as u on c.cli_user_id = u.user_id where cli_user_id = '.$id.' and( c.cli_nickname like "%'
                . $or_like['cli_nickname'] . '%" or c.cli_company like "%' . $or_like['cli_nickname'] . '%" or c.cli_phone like "%' . $or_like['cli_nickname'] . '%")'
                . 'order by if(c.cli_remind>' . time() . ',0,1) ASC,c.cli_remind ASC,c.cli_created_at DESC';
        }

        $query = $this->db->query($sql);
        $res = $query->result_array();
        echo json_encode($res);
    }

    //获取单条数据
    public function FetchOne()
    {
        $equal = $_POST['equal'];
        $res = $this->Universal_model->FetchOne('client', $equal);
        $res['cli_created_at'] = date("Y-m-d H:i:s", $res['cli_created_at']);
        echo json_encode($res);
    }

    //保存单条数据
    public function SaveOne()
    {
        if (isset($_SESSION['zx_crm_user'])) {
            if ($_POST['id'] == '') {
                $_POST['save']['cli_user_id'] = $_SESSION['zx_crm_user']['user_id'];
                $_POST['save']['cli_created_at'] = time();
//                $_POST['save']['tra_deal_time'] = time();
            }
            if (isset($_POST['save']['cli_remind'])) {
                $_POST['save']['cli_remind'] = strtotime($_POST['save']['cli_remind']);
            }
            $this->Universal_model->SaveOne('client', 'cli_id', $_POST);
            $res = array(
                'status' => 1,
                'msg' => '保存成功!'
            );
        } else {
            $res = array(
                'status' => 2,
                'msg' => '登录失效，请重新登录后操作!'
            );
        }
        echo json_encode($res);
    }

    //获取客户记录
    public function FetchRecord()
    {
        $equal = $_POST['equal'];
        $equal1 = $_POST['equal1'];
        $order = array('cli_created_at', 'desc');
        $res['record'] = $this->Universal_model->FetchData('record', $equal, array(), $order);
        $res['client'] = $this->Universal_model->FetchOne('client',$equal1);
        $res['client']['cli_remind'] = date("Y-m-d H:i:s",$res['client']['cli_remind']);
        foreach ($res['record'] as $k => $v) {
            $res['record'][$k]['rec_created_at'] = date("Y年m月d日 H:i");
        }
        echo json_encode($res);
    }

    //保存销售记录
    public function SaveRecord()
    {
        if (isset($_SESSION['zx_crm_user'])) {
            if ($_POST['id'] == '') {
                $_POST['save']['rec_user_id'] = $_SESSION['zx_crm_user']['user_id'];
                $_POST['save']['rec_created_at'] = time();
            }
            $this->Universal_model->SaveOne('record', 'rec_id', $_POST);
            $res = array(
                'status' => 1,
                'msg' => '保存成功!'
            );
        } else {
            $res = array(
                'status' => 2,
                'msg' => '登录失效，请重新登录后操作!'
            );
        }
        echo json_encode($res);
    }

    //获取用户未提交交易
    public function FetchTrade()
    {
        $equal = $_POST['equal'];
        $res = $this->Universal_model->FetchOne('trade', $equal);
        if ($res != null) {
            $res['tra_pay_time'] = date("Y-m-d H:i:s", $res['tra_pay_time']);
        }
        echo json_encode($res);
    }

    //保存交易
    public function SaveTrade()
    {
        if (isset($_SESSION['zx_crm_user'])) {
            if ($_POST['id'] == '') {
                $_POST['save']['tra_created_at'] = time();
                $_POST['save']['tra_user_id'] = $_SESSION['zx_crm_user']['user_id'];
            }
            $_POST['save']['tra_pay_time'] = strtotime($_POST['save']['tra_pay_time']);
            $this->Universal_model->SaveOne('trade', 'tra_id', $_POST);
            $res = array(
                'status' => 1,
                'msg' => '保存成功!'
            );
        } else {
            $res = array(
                'status' => 2,
                'msg' => '登录失效，请重新登录后操作!'
            );
        }
        echo json_encode($res);
    }

    //保存交易
    public function SaveTra()
    {
        if(isset($_SESSION['zx_crm_user'])){
            $this->Universal_model->SaveOne('trade','tra_id',$_POST);
            $res = array('status' => 1,'msg' => '保存成功!');
        }else{
            $res = array('status' => 2,'msg' => '登录失效，请重新登陆后操作！');
        }
        echo json_encode($res);
    }

    /*
     * 成交客户页面
     */
    public function DealCustomer()
    {
        $data = array();
        $this->render('customer/deal_customer_list', $data, array('title' => '成交客户', 'index_module_id' => 3));
    }

    /*
     * 成交客户和最新一笔的交易数据
     */
    public function FetchDealCount()
    {
        $like = isset($_POST['like']) ? $_POST['like'] : array();
        if($_SESSION['zx_crm_user']['user_role_id'] == 1){
            $sql = 'select * from view_client_trade as a where (select count(0) from view_client_trade as b where a.tra_created_at < b.tra_created_at and a.cli_id = b.cli_id and a.tra_status >= 2 and b.tra_status >= 2) < 1 and a.tra_status >=2 and a.cli_phone like "%' . $like['cli_phone'] . '%" ';
        }else if($_SESSION['zx_crm_user']['user_role_id'] == 2){
            $ids = $_SESSION['zx_crm_user']['user_unserling_ids'];
            $sql = 'select * from view_client_trade as a where a.cli_user_id in ('.$ids.') and (select count(0) from view_client_trade as b where a.tra_created_at < b.tra_created_at and a.cli_id = b.cli_id and a.tra_status >= 2 and b.tra_status >= 2) < 1 and a.tra_status >=2 and a.cli_phone like "%' . $like['cli_phone'] . '%"';
        }else{
            $id = $_SESSION['zx_crm_user']['user_id'];
            $sql = 'select * from view_client_trade as a where a.cli_user_id = '.$id.' and (select count(0) from view_client_trade as b where a.tra_created_at < b.tra_created_at and a.cli_id = b.cli_id and a.tra_status >= 2 and b.tra_status >= 2) < 1 and a.tra_status >=2 and a.cli_phone like "%' . $like['cli_phone'] . '%"';
        }
        $res = $this->db->query($sql)->result_array();
        $pro_array = array(
            '1' => '网站商城',
            '2' => '展示小程序',
            '3' => '商城小程序'
        );
        foreach ($res as $k => $v) {
            $res[$k]['tra_pro_name'] = $pro_array[$v['tra_pro_type']];
            $res[$k]['tra_over_time'] = date("Y-m-d", strtotime("+" . $v['tra_years'] . ' year', $v['tra_pay_time']));
        }
        echo json_encode($res);
    }

    /*
     * 客户成交订单
     */
    public function FetchDealTrade()
    {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $equal['tra_status>='] = 2;
        $res = $this->Universal_model->FetchData('trade', $equal, array(), array('tra_created_at' => 'desc'));
        $pro_array = array(
            '1' => '网站商城',
            '2' => '展示小程序',
            '3' => '商城小程序'
        );
        foreach ($res as $k => $v) {
            $res[$k]['tra_pay_time'] = date("Y年m月d日 H:i", $v['tra_pay_time']);
            $res[$k]['tra_pro_name'] = $pro_array[$v['tra_pro_type']];
            $res[$k]['tra_over_time'] = date("Y-m-d", strtotime("+" . $v['tra_years'] . ' year', $v['tra_pay_time']));
        }
        echo json_encode($res);
    }

    /*
     * 获取单条交易
     */
    public function FetchOneTrade()
    {
        $equal = isset($_POST['equal']) ? $_POST['equal'] : array();
        $pro_array = array(
            '1' => '网站商城',
            '2' => '展示小程序',
            '3' => '商城小程序'
        );
        $res = $this->Universal_model->FetchOne('trade', $equal);
        $res['tra_pro_name'] = $pro_array[$res['tra_pro_type']];
        $res['tra_years'] = $res['tra_years'] . '年';
        $res['tra_pay_way'] = ($res['tra_pay_way'] == '1' ? '支付宝支付' : '微信支付');
        $res['tra_pay_time'] = date("Y-m-d H:i", $res['tra_pay_time']);
        echo json_encode($res);
    }

    /*
     * 审核
     */
    public function VerifyTrade()
    {
        if (isset($_SESSION['zx_crm_user'])) {
            if($_POST['save']['tra_status'] == 3){
                $_POST['save']['tra_verify_time'] = time();
            }else{
                $_POST['save']['tra_verify_time'] = 0;
            }
            $this->db->where('tra_cli_id',$_POST['id'])->where('tra_status',2)->update('trade',$_POST['save']);
//            $this->Universal_model->SaveOne('trade', 'tra_id', $_POST);
            $res = array(
                'status' => 1,
                'msg' => '审核成功'
            );
        } else {
            $res = array(
                'status' => 2,
                'msg' => '登录失效，请重新登录后操作!'
            );
        }
        echo json_encode($res);
    }

    /*
     * 待申请
     */
    public function NoAppliedTrade()
    {
        $data = array();
        $this->render('customer/no_applied_trade', $data, array('title' => '待申请', 'index_module_id' => 4));
    }

    /*
     * 待申请
     */
    public function FetchNoApply()
    {
        $like = isset($_POST['like'])?$_POST['like']:array();
        $equal = isset($_POST['equal'])?$_POST['equal']:array();
        $this->db->select('*')
            ->from('trade as t')
            ->join('client as c','t.tra_cli_id = c.cli_id','left');
        if($_SESSION['zx_crm_user']['user_role_id'] == 2){
            $this->db->where_in('t.tra_user_id',explode(',',$_SESSION['zx_crm_user']['user_unserling_ids']));
        }else if($_SESSION['zx_crm_user']['user_role_id'] == 3){
            $this->db->where('t.tra_user_id',$_SESSION['zx_crm_user']['user_id']);
        }
        foreach($like as $k=>$v){
            $this->db->like($k,$v);
        }
        foreach($equal as $k=>$v){
            $this->db->where($k.'>=',$v);
        }
        $res = $this->db->order_by('t.tra_created_at','desc')->get()->result_array();
        $pro_array = array(
            '1' => '网站商城',
            '2' => '展示小程序',
            '3' => '商城小程序'
        );
        foreach($res as $k=>$v){
            $res[$k]['tra_pro_name'] = $pro_array[$v['tra_pro_type']];
            $res[$k]['tra_verify_time'] = date("Y-m-d",$v['tra_verify_time']);
        }
        echo json_encode($res);
    }

    /*
     * 保存交易
     */
    public function SaveApply()
    {
        if(isset($_SESSION['zx_crm_user'])){

            if(isset($_POST['save']['tra_is_applied'])){
                if($_POST['save']['tra_is_applied'] == 1){
                    $_POST['save']['tra_applied_time'] = time();
                }else{
                    $_POST['save']['tra_applied_time'] = 0;
                }
            }
            if(isset($_POST['save']['tra_is_made'])){
                if($_POST['save']['tra_is_made'] == 1){
                    $_POST['save']['tra_made_time'] = time();
                    $_POST['save']['tra_status'] = 4;
                }else{
                    $_POST['save']['tra_made_time'] = 0;
                    $_POST['save']['tra_status'] = 3;
                }
            }
            $this->Universal_model->SaveOne('trade','tra_id',$_POST);

            $res = array('status' => 1);
        }else{
            $res = array('status' => 2);
        }
        echo json_encode($res);
    }

    /*
     * 待制作
     */
    public function NoMadeTrade()
    {
        $data = array();
        $this->render('customer/no_made_list', $data, array('title' => '待制作', 'index_module_id' => 5));
    }


}

?>