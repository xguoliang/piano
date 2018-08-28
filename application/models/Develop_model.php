<?php

class Develop_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function InsertTable($table, $data) {
        $this->db->insert($table, $data);
    }

    public function InsertTableGetId($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function UpdateTable($table, $entity, $id, $data) {
        $this->db->where($entity, $id);
        $this->db->update($table, $data);
    }

    public function DeleteTable($table, $data) {
        $this->db->delete($table, $data);
    }

    public function GetRow($table, $data) {
        $query = $this->db->get_where($table, $data);
        return $query->row_array();
    }

    public function GetSelectResult($select, $table, $data) {
        $this->db->select($select);
        $query = $this->db->get_where($table, $data);
        return $query->result_array();
    }

    public function GetResult($table, $data) {
        $query = $this->db->get_where($table, $data);
        return $query->result_array();
    }

    public function GetOrderResult($table, $data, $by, $type) {
        $query = $this->db->order_by($by, $type)->get_where($table, $data);
        return $query->result_array();
    }

    public function GetSelectOrderResult($select, $table, $data, $by, $type) {
        $this->db->select($select);
        $query = $this->db->order_by($by, $type)->get_where($table, $data);
        return $query->result_array();
    }

    public function GetAllResult($table) {
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function GetAllOrderResult($table, $by, $type) {
        $query = $this->db->order_by($by, $type)->get($table);
        return $query->result_array();
    }

    public function GetAllOrderLimitResult($table, $by, $type, $pagesize, $offset) {
        $query = $this->db->order_by($by, $type)->get($table, $pagesize, $offset);
        return $query->result_array();
    }

    public function GetOrderLimitResult($table, $data, $by, $type, $pagesize, $offset) {
        $query = $this->db->order_by($by, $type)->get_where($table, $data, $pagesize, $offset);
        return $query->result_array();
    }

    public function GetSelectOrderLimitResult($select, $table, $data, $by, $type, $pagesize, $offset) {
        $this->db->select($select);
        $query = $this->db->order_by($by, $type)->get_where($table, $data, $pagesize, $offset);
        return $query->result_array();
    }

}

?>