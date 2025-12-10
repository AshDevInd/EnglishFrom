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

    // public function get_vocabs_by_category()
    // {
    //     $this->db->select('category');
    //     $this->db->from('vocabs');
    //     $this->db->group_by('category');

    //     // Prioritize series 1 & series 2, then sort others ASC
    //     $this->db->order_by("CASE 
    //                         WHEN category = 'Consonant(S1)' THEN 1
    //                         WHEN category = 'Consonant(S2)' THEN 2
    //                         ELSE 3 
    //                      END", 'ASC', false);
    //     $this->db->order_by('category', 'ASC'); // <--- IMPORTANT FIX

    //     $res = $this->db->get()->result_array();
    //     $final_res = [];

    //     foreach ($res as $row) {
    //         $final_res[] = [
    //             'category' => $row['category'],
    //             'data' => $this->db->where('category', $row['category'])
    //                 ->order_by('id', 'ASC')
    //                 ->get('vocabs')
    //                 ->result_array()
    //         ];
    //     }

    //     return $final_res;
    // }

    public function get_vocabs_by_category()
    {
        $this->db->select('kc.id as category_id, kc.name as category');
        $this->db->from('vocabs v');
        $this->db->join('khmer_category kc', 'kc.id = v.category', 'left');
        $this->db->group_by('kc.id, kc.name');

        $this->db->order_by("
        CASE 
            WHEN kc.name = 'Consonant(S1)' THEN 1
            WHEN kc.name = 'Consonant(S2)' THEN 2
            ELSE 3
        END
    ", 'ASC', false);
        $this->db->order_by('kc.name', 'ASC');

        $res = $this->db->get()->result_array();
        $final_res = [];

        foreach ($res as $row) {
            $final_res[] = [
                'category_id'   => $row['category_id'],
                'category' => $row['category'],
                'data' => $this->db
                    ->select('v.*, kc.name as category')
                    ->from('vocabs v')
                    ->join('khmer_category kc', 'kc.id = v.category', 'left')
                    ->where('v.category', $row['category_id'])
                    ->order_by('v.id', 'ASC')
                    ->get()
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


    public function get_vocabs_grouped_for_sidebar()
    {
        $categoryGroups = $this->get_vocabs_by_category(); // original method
        $main = [];
        foreach ($categoryGroups as $cat) {
            $vowel = ''; // default empty if no data
            if (!empty($cat['data'])) {
                $vowel = $cat['data'][0]['vowel'] ?? '';
            }

            if (in_array($cat['category'], ['Consonant(S1)', 'Consonant(S2)'])) {
                $cat['vowel'] = $vowel;
                $main[] = $cat;
            } else {
                $serials = [];
                $bySerial = [];
                foreach ($cat['data'] as $row) {
                    $bySerial[$row['serial_number']][] = $row;
                }
                foreach ($bySerial as $serial => $rows) {
                    $serials[] = [
                        'serial_number' => $serial,
                        'vowel' => $rows[0]['vowel'] ?? '',
                        'data' => $rows,
                    ];
                }
                $main[] = [
                    'category' => $cat['category'],
                    'vowel' => $vowel,
                    'serials' => $serials,
                ];
            }
        }
        return $main;
    }
}
