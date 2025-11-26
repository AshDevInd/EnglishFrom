<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Khmer_category_model extends CI_Model
{
    protected $table = 'khmer_category';

    public function get_all()
    {
        return $this->db->order_by('name', 'ASC')->get($this->table)->result_array();
    }

    public function get($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}

?>
