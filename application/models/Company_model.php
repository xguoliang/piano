<?php

class Company_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function SelectLesson($company_id, $search, $instruction_id, $pagesize, $offset) {
        $q = "select *,(select count(*) from orders_detail left join orders on orders_detail.order_id=orders.id where orders.entity_type=2 and orders_detail.entity_id=lesson.id and status=2) as count from lesson where company_id=$company_id and is_delete=0";
        if ($search != "") {
            $q .= " and name like '%$search%'";
        }
        if ($instruction_id != 0) {
            $q .= " and instrument_id=$instruction_id";
        }
        $q .= " order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function SelectActiviy($company_id, $search, $pagesize, $offset) {
        $q = "select * from activity where company_id=$company_id and is_delete=0";
        if ($search != "") {
            $q .= " and name like '%$search%'";
        }
        $q .= " order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function SelectPerform($company_id, $search, $pagesize, $offset) {
        $q = "select * from perform where company_id=$company_id and is_delete=0";
        if ($search != "") {
            $q .= " and name like '%$search%'";
        }
        $q .= " order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function InsertLessonTeacher($lesson_id, $teacher_id) {
        if (count($lesson_id) > 0) {
            $q = "insert into lesson_teacher (lesson_id,teacher_id) values (" . $lesson_id[0] . ",$teacher_id)";
            for ($i = 1; $i < count($lesson_id); $i++) {
                $q .= ",(" . $lesson_id[$i] . ",$teacher_id)";
            }
            $this->db->query($q);
        }
    }

    public function CompanySelectProduct($company_id, $search, $area, $min_price, $max_price, $pagesize, $offset) {
        $q = "select * from product where company_id=$company_id and is_delete=0";
        if ($search != "") {
            $q .= " and name like '%$search%'";
        }
        if ($area != "") {
            $q .= " and area like '%$area%'";
        }
        if ($min_price != "") {
            $q .= " and price>=$min_price";
        }
        if ($max_price != "") {
            $q .= " and price<=$max_price";
        }
        $q .= " order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function CompanySelectLesson($company_id, $area, $instrument_id, $min_price, $max_price, $pagesize, $offset) {
        $q = "select * from lesson where company_id=$company_id and is_delete=0";
        if ($area != "") {
            $q .= " and area like '%$area%'";
        }
        if ($instrument_id != 0) {
            $q .= " and instrument_id=$instrument_id";
        }
        if ($min_price != "") {
            $q .= " and price>=$min_price";
        }
        if ($max_price != "") {
            $q .= " and price<=$max_price";
        }
        $q .= " order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function CompanySelectActivity($company_id, $area, $type, $min_price, $max_price, $pagesize, $offset) {
        $q = "select * from activity where company_id=$company_id and is_delete=0";
        if ($area != "") {
            $q .= " and area like '%$area%'";
        }
        if ($type != 0) {
            $q .= " and type=$type";
        }
        if ($min_price != "") {
            $q .= " and price>=$min_price";
        }
        if ($max_price != "") {
            $q .= " and price<=$max_price";
        }
        $q .= " order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function TeacherIdsGetLessonCount($teacher_id) {
        if (count($teacher_id) > 0) {
            $q = "select teacher_id,count(*) as count from lesson_teacher where teacher_id=" . $teacher_id[0];
            for ($i = 1; $i < count($teacher_id); $i++) {
                $q .= " or teacher_id=" . $teacher_id[$i];
            }
            $q .= " group by teacher_id having count>0";
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

    public function AllSelectLesson($area, $instrument_id, $min_price, $max_price, $pagesize, $offset,$name = '') {
        $q = "select * from lesson where is_delete=0";
        if ($area != "") {
            $q .= " and area like '%$area%'";
        }
        if ($name != "") {
            $q .= " and name like '%$name%'";
        }
        if ($instrument_id != "") {
            $q .= " and name like '%$instrument_id%'";
        }
        if ($min_price != "") {
            $q .= " and price>=$min_price";
        }
        if ($max_price != "") {
            $q .= " and price<=$max_price";
        }
        $q .= " order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function SelectProduct($com_id, $search, $instrument_id, $pagesize, $offset) {
        $q = "select * from product where com_id=$com_id and is_delete=0";
        if ($search != "") {
            $q .= " and name like '%$search%'";
        }
        if ($instrument_id != 0) {
            $q .= " and instrument_id=$instrument_id";
        }
        $q .= " order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function SelectGoodLesson($area, $min_price, $max_price, $sort_type, $lng, $lat, $pagesize, $offset,$name = '',$com_id = '') {
        if ($sort_type == 1) {
            $q = "select ins.name as ins_name,com.name as com_name,lesson.*,(select count(*) from collect where collect.entity_id=lesson.id and entity_type=2) as count from lesson left join instrument as ins on lesson.instrument_id = ins.id left join company as com on lesson.company_id = com.id where lesson.is_delete=0";
        } else {
            $q = "select ins.name as ins_name,com.name as com_name,lesson.* from lesson  left join instrument as ins on lesson.instrument_id = ins.id left join company as com on lesson.company_id = com.id where lesson.is_delete=0";
        }
        if ($area != "") {
            $q .= " and lesson.area like '%$area%'";
        }
        if($name != ''){
            $q .= " and lesson.name like '%$name%'";
        }
        if($com_id != ''){
            $q .= " and lesson.company_id = $com_id";
        }
        if ($min_price != "") {
            $q .= " and lesson.price>=$min_price";
        }
        if ($max_price != "") {
            $q .= " and lesson.price<=$max_price";
        }
        if ($sort_type == 1) {
            $q .= " order by count desc";
        } else if ($sort_type == 2) {
            $q .= " order by sqrt(($lng-lesson.lng)*($lng-lesson.lng)+($lat-lesson.lat)*($lat-lesson.lat)) asc";
        } else if ($sort_type == 3) {
            $q .= " order by lesson.price desc";
        } else if ($sort_type == 4) {
            $q .= " order by lesson.price asc";
        }
        $q .= " limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function SelectGoodProduct($area, $min_price, $max_price, $brand_id, $sort_type, $lng, $lat, $pagesize, $offset,$name = '',$com_id = '') {
        if ($sort_type == 1) {
            $q = "select view_product_company.*,(select count(*) from collect where collect.entity_id=view_product_company.id and entity_type=1) as count from view_product_company where is_delete=0";
        } else {
            $q = "select * from view_product_company where is_delete=0";
        }
        if ($area != "") {
            $q .= " and area like '%$area%'";
        }
        if ($min_price != "") {
            $q .= " and price>=$min_price";
        }
        if($name != ''){
            $q .= " and com_name like '%$name%'";
        }
        if($com_id != ''){
            $q .= " and com_id = $com_id";
        }
        if ($max_price != "") {
            $q .= " and price<=$max_price";
        }
        if ($brand_id != 0) {
            $q .= " and brand_id=$brand_id";
        }
        if ($sort_type == 1) {
            $q .= " order by count desc";
        } else if ($sort_type == 2) {
            $q .= " order by sqrt(($lng-lng)*($lng-lng)+($lat-lat)*($lat-lat))";
        } else if ($sort_type == 3) {
            $q .= " order by price desc";
        } else if ($sort_type == 4) {
            $q .= " order by price asc";
        }
        $q .= " limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function SelectGoodSiteLease($area, $min_price, $max_price, $sort_type, $lng, $lat, $pagesize, $offset) {
        if ($sort_type == 1) {
            $q = "select site_lease.*,rent.name as com_name,instrument.name as ins_name,(select count(*) from collect where collect.entity_id=site_lease.id and entity_type=6) as count from site_lease left join rent on site_lease.rent_id = rent.id left join instrument on site_lease.instrument_id = instrument.id where 1=1";
        } else {
            $q = "select site_lease.*,rent.name as com_name,instrument.name as ins_name from site_lease left join rent on site_lease.rent_id = rent.id left join instrument on site_lease.instrument_id = instrument.id where 1=1";
        }
        if ($area != "") {
            $q .= " and area like '%$area%'";
        }
        if ($min_price != "") {
            $q .= " and money>=$min_price";
        }
        if ($max_price != "") {
            $q .= " and money<=$max_price";
        }
        if ($sort_type == 1) {
            $q .= " order by count desc";
        } else if ($sort_type == 2) {
            $q .= " order by sqrt(($lng-`lng`)*($lng-`lng`)+($lat-`lat`)*($lat-`lat`))";
        } else if ($sort_type == 3) {
            $q .= " order by money desc";
        } else if ($sort_type == 4) {
            $q .= " order by money asc";
        }
        $q .= " limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    //求店铺平均评分
    public function GetAvgStar($id) {
        $res = $this->db->select('AVG(star) as star')
                        ->from('evaluate as e')
                        ->join('orders as o', 'o.id = e.order_id', 'left')
                        ->where('o.company_id', $id)
                        ->get()->row_array();
        return $res['star'];
    }

    public function ProductIdsGetProduct($product_id) {
        if (count($product_id) > 0) {
            $q = "select product.*,company.name as com_name,company.area,instrument.name as instrument_name from product left join company on company.id=product.com_id left join instrument on product.instrument_id=instrument.id where product.id=" . $product_id[0];
            for ($i = 1; $i < count($product_id); $i++) {
                $q .= " or product.id=" . $product_id[$i];
            }
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

    public function LessonIdsGetLesson($lesson_id) {
        if (count($lesson_id)) {
            $q = "select * from lesson where id=" . $lesson_id[0];
            for ($i = 0; $i < count($lesson_id); $i++) {
                $q .= " or id=" . $lesson_id[$i];
            }
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

    public function ActivityIdsGetActivity($activity_id) {
        if (count($activity_id) > 0) {
            $q = "select * from activity where id=" . $activity_id[0];
            for ($i = 1; $i < count($activity_id); $i++) {
                $q .= " or id=" . $activity_id[$i];
            }
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

    public function MovieIdsGetMovie($movie_id) {
        if (count($movie_id) > 0) {
            $q = "select * from movie where id=" . $movie_id[0];
            for ($i = 1; $i < count($movie_id); $i++) {
                $q .= " or id=" . $movie_id[$i];
            }
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

    public function PerformIdsGetPerform($perform_id) {
        if (count($perform_id) > 0) {
            $q = "select * from perform where is_delete=0";
            if (count($perform_id) == 1) {
                $q .= " and id=" . $perform_id[0];
            } else {
                for ($i = 0; $i < count($perform_id); $i++) {
                    if ($i == 0) {
                        $q .= " and (id=" . $perform_id[$i];
                    } else if ($i == (count($perform_id) - 1)) {
                        $q .= " or id=" . $perform_id[$i] . ")";
                    } else {
                        $q .= " or id=" . $perform_id[$i];
                    }
                }
            }
            $query = $this->db->query($q);
            return $query->result_array();
        }
    }

    public function ListSelectPerform($area, $type, $time, $pagesize, $offset) {
        $q = "select * from perform where is_delete=0";
        if ($area != "") {
            $q .= " and area like '%$area%'";
        }
        if ($type != 0) {
            $q .= " and type=$type";
        }
        if ($time != "") {
            $q .= " and start_time<='$time' and end_time>='$time'";
        }
        $q .= " order by add_time desc limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    public function FetchCompanyBrand($id) {
        $data = $this->db->select('b.name,b.id')
                        ->from('product as p')
                        ->join('brand as b', 'p.brand_id = b.id', 'left')
                        ->where('p.com_id', $id)
                        ->where('b.is_delete', 0)
                        ->group_by('p.brand_id')
                        ->get()->result_array();
        return $data;
    }

    public function FetchCompanyActivity($com_id = '', $sort_type, $name, $offset, $limit, $area, $min_price, $max_price) {
        $this->db->select('*')
                ->from('activity');
        if ($com_id != '') {
            $this->db->where('company_id', $com_id);
        }
        $this->db->like('name', $name)
                ->like('area', $area)
                ->order_by('price', $sort_type);

        if ($min_price != '') {
            $this->db->where('price >=', $min_price);
        }
        if ($max_price != '') {
            $this->db->where('price', $max_price);
        }
        $this->db->limit($limit, $offset);
        $res = $this->db->get()->result_array();
        return $res;
    }

    public function SelectTeacher($company_id, $pagesize, $offset) {
        $q = "select teacher.*,(select count(*) from lesson_teacher where teacher_id=teacher.id) as count from teacher where company_id=$company_id order by count limit $offset,$pagesize";
        $query = $this->db->query($q);
        return $query->result_array();
    }

}

?>