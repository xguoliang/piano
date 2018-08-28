<?php

class Piano_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function GetCompany($offset, $limit, $lat, $lng, $area, $sort_type,$name = '')
    {

        $q = "select *,(select count(*) from collect where entity_type = 9 and entity_id = company.id) as count from company where 1=1";

        if ($area != "") {
            $q .= " and area like '%$area%'";
        }
        if ($name != "") {
            $q .= " and name like '%$name%'";
        }
        $q.=" and lng<>'' and lat<>''";
        if ($sort_type == 1) {
            $q .= " order by count desc";
        } else if ($sort_type == 2) {
            $q .= " order by sqrt(($lng-lng)*($lng-lng)+($lat-lat)*($lat-lat)) asc";
        }
        $q .= " limit $offset,$limit";
        $query = $this->db->query($q);
        return $query->result_array();
    }
}
?>
