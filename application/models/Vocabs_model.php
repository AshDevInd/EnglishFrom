<?php
class Vocabs_model extends CI_Model
{

    protected $table = 'vocabs';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function insert_batch($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }
    public function getVocabById($id)
    {
        return $this->db->get_where('vocabs', ['id' => $id])->row_array();
    }

    public function updateVocab($id, $data)
    {
        return $this->db->where('id', $id)->update('vocabs', $data);
    }
    public function get_vocabs_by_serial()
    {
        $this->db->select('serial_number,vowel');
        $this->db->from('vocabs');
        $this->db->group_by('serial_number');
        $this->db->order_by('id', 'ASC');
        $qry = $this->db->get();
        $res = $qry->result_array();
        $final_res = [];
        foreach ($res as $row) {
            $this->db->where('serial_number', $row['serial_number']);
            $this->db->order_by('id', 'ASC');
            $qry2 = $this->db->get('vocabs');
            $res2 = $qry2->result_array();
            $final_res[] = [
                'serial_number' => $row['serial_number'],
                'vowel' => $row['vowel'],
                'data' => $res2
            ];
        }
        return $final_res;
    }

    public function get_vocabs_by_category()
    {
        $this->db->select('category');
        $this->db->from('vocabs');
        $this->db->group_by('category');

        // Prioritize series 1 & series 2, then sort others ASC
        $this->db->order_by("CASE 
                            WHEN category = 'Consonant(S1)' THEN 1
                            WHEN category = 'Consonant(S2)' THEN 2
                            ELSE 3 
                         END", 'ASC', false);
        $this->db->order_by('category', 'ASC'); // <--- IMPORTANT FIX

        $res = $this->db->get()->result_array();
        $final_res = [];

        foreach ($res as $row) {
            $final_res[] = [
                'category' => $row['category'],
                'data' => $this->db->where('category', $row['category'])
                    ->order_by('id', 'ASC')
                    ->get('vocabs')
                    ->result_array()
            ];
        }

        return $final_res;
    }



    public function get_vowel_group()
    {
        $this->db->select('vowel');
        $this->db->from('vocabs');
        $this->db->group_by('vowel');
        $this->db->order_by('id', 'ASC');
        $qry = $this->db->get();
        $res = $qry->result_array();
        return $res;
    }
}
