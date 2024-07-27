<?php
class Payment_model extends CI_Model
{
    public function insert_payment($data)
    {
        $this->db->insert('transactions', $data);
    }

    public function update_payment($order_id, $data)
    {
        $this->db->where('order_id', $order_id);
        $this->db->update('transactions', $data);
    }

    public function get_payment_by_order_id($order_id)
    {
        $this->db->select('transactions.*');
        $this->db->from('transactions');       
        $this->db->where('transactions.order_id', $order_id);
        return $this->db->get()->row();
    }
}
