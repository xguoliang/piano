<?php

class News_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function SelectNews($pagesize, $offset) {
        $query = $this->db->order_by('sort', 'asc')->get('news', $pagesize, $offset);
        return $query->result_array();
    }

}
?>
