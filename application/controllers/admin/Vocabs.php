<?php defined('BASEPATH') or exit('');
class Vocabs extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Vocabs_model');
        $this->load->helper(array('form', 'url'));
	}

	function index()
	{
		 // Get all records from the vocabs table
		 $query = $this->db->get('vocabs');
		 $data['vocabs'] = $query->result_array();
		 $data['page_title'] = 'vocabs';
		 // Load view and pass data
		 $this->load->view('vocabs', $data);
	}
	function importVocabs()
	{
		 // Get all records from the Vowels table
		 
		 // Load view and pass data
		 $this->load->view('import-vocabs');
	}

    public function import_csv() {
        $file_path = $_FILES['csv_file']['tmp_name'];

		if ($_FILES['csv_file']['name']) {
            $filename = $_FILES['csv_file']['tmp_name'];
            $file = fopen($filename, "r");

            // Skip header
            fgetcsv($file);

            while (($data = fgetcsv($file)) !== FALSE) {
                // Extract serial number and vowel from first column
                preg_match('/(\d+)[\)\s]*(\S*)/', $data[0], $matches);
                $serial_number = $matches[1] ?? '';
                $vowel = $matches[2] ?? '';
				$combination_raw = isset($data[1]) ? trim($data[1]) : '';
				$combination = preg_replace('/^\s*\(.*?\)\s*/', '', $combination_raw);
                $insertData = [
                    'serial_number' => $serial_number,
                    'vowel'         => $vowel,
                 	'combination'   => isset($combination) ? rtrim($combination, '= ') : '',
                    'khmer'         => $data[2] ?? '',
                    'devanagari'    => $data[3] ?? '',
                    'roman'         => $data[4] ?? '',
                    'ipa'           => $data[5] ?? ''
                ];

                $this->db->insert('vocabs', $insertData);
            }
            fclose($file);
            echo "CSV Imported Successfully!";
        } else {
            echo "Please upload a CSV file.";
        }
    }
    
	public function upload_audio() {
		if (isset($_FILES['audio_data']) && $_FILES['audio_data']['error'] === 0) {
			$upload_path = './uploads/audio/vocabs/';
			if (!is_dir($upload_path)) {
				mkdir($upload_path, 0777, true);
			}
	
			$field = $this->input->post('field_name');  // e.g., khmer, devanagari, roman
			$id = $this->input->post('vocabs_id');        // ID of the vowel row
			$filename = $field . '_' . $id . '_' . time() . '.mp3';
	
			$full_path = $upload_path . $filename;
	
			if (move_uploaded_file($_FILES['audio_data']['tmp_name'], $full_path)) {
				// Load database
				$this->load->database();
	
				// Determine column name based on field
				$audio_column = $field; // e.g., khmer_audio, devanagari_audio
	
				// Update the vowel row with new audio filename
				$this->db->where('id', $id);
				$this->db->update('vocabs', [ $audio_column => $filename ]);
				
				// Confirm if update was successful
				if ($this->db->affected_rows() > 0) {
					echo "Uploaded and updated successfully: " . $filename;
				} else {
					echo "Uploaded successfully, but DB update failed.";
				}
			} else {
				http_response_code(500);
				echo "Failed to move file.";
			}
		} else {
			http_response_code(400);
			echo "No file uploaded.";
		}
	}
	
	public function delete_audio()
{
    $vocabs_id  = $this->input->post('vocabs_id');
    $field_name = $this->input->post('field_name');

    if (!$vocabs_id || !$field_name) {
        show_error("Invalid request", 400);
        return;
    }

    $this->db->select($field_name);
    $this->db->where('id', $vocabs_id);
    $row = $this->db->get('vocabs')->row();

    if ($row && !empty($row->$field_name)) {
        $file_path = FCPATH . 'uploads/audio/vocabs/' . $row->$field_name;
        if (file_exists($file_path)) {
            @unlink($file_path);
        }

        $this->db->where('id', $vocabs_id)
                 ->update('vocabs', [ $field_name => null ]);

        echo "success";
        return;
    }

    show_error("Audio file not found", 404);
}
}