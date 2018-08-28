<?php

class Delprice extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->model('Universal_model');
    }

    public function DelpriceList()
    {
        $data['area'] = $this->GetArea('company', 0);
        $data['brand'] = $this->Universal_model->FetchData('brand');
        $this->prender('phone/delprice/delprice_list', $data, array('title' => '降价排行'));
    }

    public function GetDelprice()
    {
        $area = isset($_POST['area']) ? $_POST['area'] : '';
        $min_price = isset($_POST['min_price']) ? $_POST['min_price'] : '';
        $max_price = isset($_POST['max_price']) ? $_POST['max_price'] : '';
        $sort_type = isset($_POST['sort_type']) ? $_POST['sort_type'] : '';

        $lng = isset($_POST['lng']) ? $_POST['lng'] : '';
        $lat = isset($_POST['lat']) ? $_POST['lat'] : '';
        $pagesize = $_POST['limit'];
        $offset = ($_POST['page'] - 1) * $pagesize;
        $brand_id = $_POST['brand_id'];
        $q = 'select *,(select count(0) from collect where entity_id = view_product_company.id and entity_type = 1) as count from view_product_company where 1=1 ';
        if($brand_id !=0 && $brand_id != ''){
            $q .= ' and brand_id = "'.$brand_id.'"';
        }
        if($area !=0 && $area != ''){
            $q .= ' and area like "%'.$area.'%"';
        }
        if($min_price != '' && $max_price != ''){
            $q .=' and price <= '.$max_price .' and price >= '.$min_price;
        }
        if ($sort_type == 1) {
            $q .= " order by count desc";
        } else if ($sort_type == 2) {
            $q .= " order by sqrt(($lng-`lng`)*($lng-`lng`)+($lat-`lat`)*($lat-`lat`))";
        }else if ($sort_type == 3) {
            $q .= " order by show_price-price desc";
        } else if ($sort_type == 4) {
            $q .= " order by show_price-price asc";
        }

        $q .= " limit $offset,$pagesize";
        $query = $this->db->query($q);
        $res =  $query->result_array();
        echo json_encode($res);
    }
}

?>