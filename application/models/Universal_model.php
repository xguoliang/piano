<?php

class Universal_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    /*
     * 获取单条数据
     */
    public function FetchOne($table, $equal = array(), $no_equal = array())
    {
        foreach ($equal as $k => $v) {
            $this->db->where($k, $v);
        }
        foreach ($no_equal as $k => $v) {
            $this->db->where($k . '!=', $v);
        }
        $one = $this->db->get($table)->row_array();
        return $one;
    }

    /*
     * 获取全部数据
     */
    public function FetchData($table, $equal = array(), $like = array(), $order = array())
    {
        foreach ($equal as $k => $v) {
            $this->db->where($k, $v);
        }
        foreach ($like as $k => $v) {
            $this->db->like($k, $v);
        }
        foreach ($order as $k => $v) {
            $this->db->order_by($k, $v);
        }
        $res = $this->db->get($table)->result_array();
        return $res;
    }

    /*
     * 获取分页
     */
    public function FetchCount($table, $equal = array(), $like = array(), $or_like = array(), $where_in = array())
    {
        $this->db->select('count(0)');
        foreach ($like as $k => $v) {
            $this->db->like($k, $v);
        }
        foreach ($or_like as $k => $v) {
            $this->db->or_like($k, $v);
        }
        foreach ($equal as $k => $v) {
            $this->db->where($k, $v);
        }
        foreach ($where_in as $k => $v) {
            $this->db->where_in($k, $v);
        }
        $count = $this->db->get($table)->row_array();
        return $count['count(0)'];
    }

    /*
     * 获取分页数据
     */
    public function FetchPageData($table, $offset, $pagesize, $equal = array(), $like = array(), $order = array(), $or_like = array(), $where_in = array())
    {
        $this->db->select('*');
        foreach ($like as $k => $v) {
            $this->db->like($k, $v);
        }
        foreach ($equal as $k => $v) {
            $this->db->where($k, $v);
        }
        foreach ($or_like as $k => $v) {
            $this->db->or_like($k, $v);
        }
        foreach ($order as $k => $v) {
            $this->db->order_by($k, $v);
        }
        foreach ($where_in as $k => $v) {
            $this->db->where_in($k, $v);
        }
        $res = $this->db->get($table, $pagesize, $offset)->result_array();
        return $res;
    }

    /*
     * 插入或者保存单条数据
     */
    public function SaveOne($table, $primary, $post)
    {
        if ($post['id'] == '') {
            $this->db->insert($table, $post['save']);
            $id = $this->db->insert_id();
            return $id;
        } else {
            $this->db->update($table, $post['save'], $primary . " = '" . $post['id'] . "'");
            return 1;
        }
    }

    /*
     * 保存多条数据
     */
    public function SaveData($table, $data)
    {
        $this->db->insert_batch($table, $data);
        return 1;
    }



    /*
     * 删除单条数据
     */
    public function DeleteOne($table, $equal)
    {
        $this->db->delete($table, $equal);
        $res = array(
            'status' => 1
        );
        return $res;
    }

    /*
     * 删除多条
     */
    public function DeleteData($table, $equal)
    {
        $this->db->delete($table, $equal);
        $res = array(
            'status' => 1
        );
        return $res;
    }

    /*
     * 插入单条
     */
    public function InsertOne($table, $save)
    {
        $this->db->insert($table, $save);
        return 1;
    }

    /*
     * 更新一条
     */
    public function UpdateOne($table, $equal, $save)
    {
        $this->db->update($table, $save, $equal);
        return 1;
    }

    /*
     * 后台权限模块
     */
    public function FetchOneAuthModule($id)
    {
        $res = $this->db->select('m.mod_controller')
            ->from('module as m')
            ->join('authority as a', 'm.mod_id = a.auth_mod_id', 'left')
            ->where('a.auth_user_id', $id)
            ->order_by('m.mod_id', 'asc')
            ->get()->row_array();
        return $res;
    }

    /*
     * 个人全部权限模块
     */
    public function FetchAllAuthModule()
    {
        $res = $this->db->select('m.*')
            ->from('authority as a')
            ->join('module as m', 'm.mod_id = a.auth_mod_id', 'left')
            ->where('a.auth_user_id', $_SESSION['zx_crm_user']['user_id'])
            ->order_by('m.mod_id', 'asc')
            ->get()->result_array();
        return $res;
    }

    /*
     * 单条数据删除文件
     */
    public function DeleteFile($table, $equal, $field)
    {
        $this->db->select($field)
            ->from($table);
        foreach ($equal as $k => $v) {
            $this->db->where($k, $v);
        }
        $one = $this->db->get()->row_array();
        $file = $one[$field];
        if (unlink($file)) {
            $res = 1;
        } else {
            $res = 2;
        }
        echo $res;
    }

}

?>