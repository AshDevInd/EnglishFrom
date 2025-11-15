<?php
class Vocabs_model extends CI_Model {

    protected $table = 'vocabs';

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function insert_batch($data) {
        return $this->db->insert_batch($this->table, $data);
    }
    public function getVocabById($id) {
        return $this->db->get_where('vocabs', ['id' => $id])->row_array();
    }

    public function updateVocab($id, $data) {
        return $this->db->where('id', $id)->update('vocabs', $data);
    }
    public function get_vocabs_by_serial() {
        $this->db->select('serial_number,vowel');
        $this->db->from('vocabs');
        $this->db->group_by('serial_number');
        $this->db->order_by('id','ASC');
        $qry= $this->db->get();
        $res= $qry->result_array();
        $final_res = [];
        foreach($res as $row){
            $this->db->where('serial_number',$row['serial_number']);
            $this->db->order_by('id','ASC');
            $qry2= $this->db->get('vocabs');
            $res2= $qry2->result_array();
            $final_res[] = [
                'serial_number' => $row['serial_number'],
                'vowel' => $row['vowel'],
                'data' => $res2
            ];
        }
        return $final_res;
    }

    public function get_vowel_group()
    {
        $this->db->select('vowel');
        $this->db->from('vocabs');
        $this->db->group_by('vowel');
        $this->db->order_by('id','ASC');
        $qry= $this->db->get();
        $res= $qry->result_array();
        return $res;
    }
}
