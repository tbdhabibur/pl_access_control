<?php
/**
 * Created by PhpStorm.
 * User: habibur
 * Date: 12/10/18
 * Time: 4:52 PM
 */

class Custom_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->db->query("SET time_zone='+6:00'"); // do not change this value
    }

    public function getUsers( $limit = false, $order_by = false) {
        $this->db->select('pl_user.*, pl_user_role.name as role_name')
            ->join('pl_user_role', 'pl_user_role.id=pl_user.pl_user_role_id')
            ->from('pl_user');

        if (!empty($order_by)) {
            $this->db->order_by($order_by['field'], $order_by['order']);
        }

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['start']);
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }


    function __destruct() {
        $this->db->close();
    }
}