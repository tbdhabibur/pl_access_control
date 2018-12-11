<?php

class Global_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db->query("SET time_zone='+6:00'"); // do not change this value
    }

    public function insert($table, $data = array()) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update($table, $data, $where) {
        $this->db->where($where);
        $this->db->update($table, $data);
        return TRUE;
    }

    public function delete($table, $where) {
        if ($this->db->delete($table, $where)) {
            return $this->db->affected_rows();
        } else {
            return FALSE;
        }
    }

    public function get_row($table, $where, $order_by = false) {

        $this->db->select('*')->from($table);

        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!empty($order_by)) {
            $this->db->order_by($order_by['filed'], $order_by['order']);
        }

        $query = $this->db->get();
        if ($query->result()) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function get($table, $where = false, $limit = false, $order_by = false) {
        $this->db->select('*')->from($table);

        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['start']);
        }

        if (!empty($order_by)) {
            $this->db->order_by($order_by['filed'], $order_by['order']);
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_count($table, $where) {
        $this->db->select('*')->from($table);
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    public function haveExists($table, $where) {
        $this->db->select('*')->from($table);
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function __destruct() {
        $this->db->close();
    }

}
