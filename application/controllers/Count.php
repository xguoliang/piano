<?php

class Count extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Universal_model');
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    /*
     * 统计页面
     */
    public function Count()
    {
        $w = date("w",strtotime("today"));
        if($w == 5){
            $month_count_day = array(
                'friday' => date("Y-m-d",strtotime("today")),
                'thursday' => date("Y-m-d",strtotime("next Thursday")),
            );
        }else{
            $month_count_day = array(
                'friday' => date("Y-m-d",strtotime("last Friday")),
                'thursday' => date("Y-m-d",strtotime("next Thursday")),
            );
        }

        $data = array('month_count_day' => $month_count_day);
        $this->render('count/count', $data, array('title' => '统计', 'index_module_id' => 1));
    }

    /*
     * 销售员每日销售额以及加人统计
     */
    public function FetchCount()
    {
        $begin_time = $_POST['begin_day'] != ''?strtotime($_POST['begin_day']."00:00:00"):strtotime(date("Y-m-d")." 00:00:00");
        $end_time =  $_POST['end_day'] != ''?strtotime($_POST['end_day']."23:59:59"):strtotime(date("Y-m-d")." 23:59:59");
        $equal = array('user_is_delete' => 2);
        $res = $this->Universal_model->FetchData('user', $equal);
        $user_trades = $this->db->select('tra_user_id,sum(tra_amount) as sum_trade_amount')->from('trade')->where('tra_verify_time >=', $begin_time)->where('tra_verify_time <=', $end_time)->where('tra_status >=',3)->group_by('tra_user_id')->get()->result_array();
        $user_clients = $this->db->select('cli_user_id,count(cli_user_id) as sum_client_amount')->from('client')->where('cli_created_at >=', $begin_time)->where('cli_created_at <=', $end_time)->group_by('cli_user_id')->get()->result_array();
        foreach ($res as $k => $v) {
            $res[$k]['sum_trade_amount'] = 0;
            foreach ($user_trades as $c => $d) {
                if ($v['user_id'] == $d['tra_user_id']) {
                    $res[$k]['sum_trade_amount'] = $d['sum_trade_amount'];
                }
            }
            $res[$k]['sum_client_amount'] = 0;

            foreach ($user_clients as $a => $b) {
                if ($v['user_id'] == $b['cli_user_id']) {
                    $res[$k]['sum_client_amount'] = $b['sum_client_amount'];
                }
            }
        }
        echo json_encode($res);
    }


}

?>