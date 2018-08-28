<?php

class Rent_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function SelectLease($rent_id, $search, $pagesize, $offset) {
        $q = "select * from lease where rent_id=$rent_id";
        if ($search != "") {
            $q .= " and name like '%$search%'";
        }
        $q .= " order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function SelectSiteLease($rent_id, $search, $pagesize, $offset) {
        $q = "select * from site_lease where rent_id=$rent_id";
        if ($search != "") {
            $q .= " and name like '%$search%'";
        }
        $q .= " order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function AllSelectLease($area, $instrument_id, $min_price, $max_price, $pagesize, $offset) {
        $q = "select * from lease where (1=1)";
        if ($area != "") {
            $q .= " and area like '%$area%'";
        }
        if ($instrument_id != 0) {
            $q .= " and instrument_id=$instrument_id";
        }
        if ($min_price != "") {
            $q .= " and money>=$min_price and money<=$max_price";
        }
        $q .= " limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function AllSelectSiteLease($area, $type, $min_price, $max_price,$name = '') {
        $q = "select * from site_lease where (1=1)";
        if ($area != "") {
            $q .= " and area like '%$area%'";
        }
        if ($name != "") {
            $q .= " and name like '%$name%'";
        }
        if ($type != 0) {
            $q .= " and type=$type";
        }
        if ($min_price != "") {
            $q .= " and money<=$max_price and money>=$min_price";
        }
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function LeaseIdsGetLease($lease_id) {
        if (count($lease_id) > 0) {
            $q = "select * from lease where id=" . $lease_id[0];
            for ($i = 1; $i < count($lease_id); $i++) {
                $q .= " or id=" . $lease_id[$i];
            }
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

    public function SiteLeaseIdsGetSiteLease($lease_id) {
        if (count($lease_id) > 0) {
            $q = "select * from site_lease where id=" . $lease_id[0];
            for ($i = 1; $i < count($lease_id); $i++) {
                $q .= " or id=" . $lease_id[$i];
            }
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

}

?>