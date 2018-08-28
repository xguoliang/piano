<?php

class Order_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function SelectProductOrder($com_id, $status, $pagesize, $offset) {
        $q = "select id,order_id,name,status,add_time from view_orders_detail_student where com_id=$com_id and entity_type=1 and is_delete=0";
        if ($status != 0) {
            $q .= " and status=$status";
        }
        $q .= " group by order_id order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function SelectLessonOrder($com_id, $status, $pagesize, $offset) {
        $q = "select id,order_id,name,status,add_time from view_orders_detail_student_lesson where company_id=$com_id and entity_type=2 and is_delete=0";
        if ($status != 0) {
            $q .= " and status=$status";
        }
        $q .= " group by order_id order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function SelectActivityOrder($com_id, $status, $pagesize, $offset) {
        $q = "select id,order_id,name,status,add_time from view_orders_detail_student_activity where company_id=$com_id and entity_type=2 and is_delete=0";
        if ($status != 0) {
            $q .= " and status=$status";
        }
        $q .= " group by order_id order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function OrderIdsGetOrderDetail($order_id, $com_id) {
        if (count($order_id) > 0) {
            if (count($order_id) == 1) {
                $q = "select * from view_orders_detail_student where com_id=$com_id and order_id=" . $order_id[0];
            } else {
                $q = "select * from view_orders_detail_student where com_id=$com_id and (order_id=" . $order_id[0];
            }
            for ($i = 1; $i < count($order_id); $i++) {
                if ($i == (count($order_id) - 1)) {
                    $q .= " or order_id=" . $order_id[$i] . ")";
                } else {
                    $q .= " or order_id=" . $order_id[$i];
                }
            }
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

    public function OrderIdsUserGetOrderDetail($order_id) {
        if (count($order_id) > 0) {
            $q = "select * from view_orders_detail_student where order_id=" . $order_id[0];
            for ($i = 1; $i < count($order_id); $i++) {
                $q .= " or order_id=" . $order_id[$i];
            }
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

    public function LessonOrderIdsGetOrderDetail($order_id, $com_id) {
        if (count($order_id) > 0) {
            if (count($order_id) == 1) {
                $q = "select * from view_orders_detail_student_lesson where company_id=$com_id and order_id=" . $order_id[0];
            } else {
                $q = "select * from view_orders_detail_student_lesson where company_id=$com_id and (order_id=" . $order_id[0];
            }
            for ($i = 1; $i < count($order_id); $i++) {
                if ($i == (count($order_id) - 1)) {
                    $q .= " or order_id=" . $order_id[$i] . ")";
                } else {
                    $q .= " or order_id=" . $order_id[$i];
                }
            }
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

    public function LessonOrderIdsUserGetOrderDetail($order_id) {
        if (count($order_id) > 0) {
            $q = "select * from view_orders_detail_student_lesson where order_id=" . $order_id[0];
            for ($i = 1; $i < count($order_id); $i++) {
                $q .= " or order_id=" . $order_id[$i];
            }
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

    public function ActivityOrderIdsGetOrderDetail($order_id, $com_id) {
        if (count($order_id) > 0) {
            if (count($order_id) == 1) {
                $q = "select * from view_orders_detail_student_activity where company_id=$com_id and order_id=" . $order_id[0];
            } else {
                $q = "select * from view_orders_detail_student_activity where company_id=$com_id and (order_id=" . $order_id[0];
            }
            for ($i = 1; $i < count($order_id); $i++) {
                if ($i == (count($order_id) - 1)) {
                    $q .= " or order_id=" . $order_id[$i] . ")";
                } else {
                    $q .= " or order_id=" . $order_id[$i];
                }
            }
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

    public function ActivityOrderIdsUserGetOrderDetail($order_id, $com_id) {
        if (count($order_id) > 0) {
            $q = "select * from view_orders_detail_student_activity where order_id=" . $order_id[0];
            for ($i = 1; $i < count($order_id); $i++) {
                $q .= " or order_id=" . $order_id[$i];
            }
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

    public function InsertEvaluate($order_id, $product_id, $star, $desc, $img, $add_time) {
        if (count($product_id) > 0) {
            $q = "insert into evaluate (order_id,product_id,star,desc,img,add_time) values ($order_id," . $product_id[0] . "," . $star[0] . ",'" . $desc[0] . "','" . $img[0] . "','$add_time')";
            for ($i = 1; $i < count($product_id); $i++) {
                $q .= ",($order_id," . $product_id[$i] . "," . $star[$i] . ",'" . $desc[$i] . "','" . $img[$i] . "','$add_time')";
            }
            $this->db->query($q);
        }
    }

}

?>