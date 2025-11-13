<?php defined('BASEPATH') or exit('');
class Vowels extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		 // Get all records from the Vowels table
		//  $query = $this->db->get('vowels');
		//  $data['vowels'] = $query->result_array();

		$words = $this->db->get('tbl_words')->result_array();
		$res = [];

		foreach($words as $word) {
			$lang = $this->db->where('wid', $word['id'])->get('tbl_lang_words')->result_array();
			$word['langs'] = $lang;
			$res[] = $word;
		}
		 $data['page_title'] = 'vowels';
		 $data['vowels'] = $res;
		 // Load view and pass data
		 $this->load->view('vowels', $data);
	}
	function importVowels()
	{
		 // Get all records from the Vowels table
		 
		 // Load view and pass data
		 $this->load->view('import-vowels');
	}
	public function import_csv() {
        if ($_FILES['csv_file']['name']) {
            $filename = $_FILES['csv_file']['tmp_name'];

            if (($handle = fopen($filename, "r")) !== FALSE) {
                fgetcsv($handle); // skip header row

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $csvData = array(
                        'sound_no'   => trim($data[0]),
                        'combination'=> trim($data[1]),
                        'khmer'      => trim($data[2]),
                        'devanagari' => trim($data[3]),
                        'roman'      => trim($data[4])
                    );

                    $this->db->insert('vowels', $csvData);
                }

                fclose($handle);
                $this->session->set_flashdata('message', 'CSV imported successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to open the CSV file.');
            }
        }
        redirect('admin/import-vowels');
    }

	public function upload_audio() {
		if (isset($_FILES['audio_data']) && $_FILES['audio_data']['error'] === 0) {
			$upload_path = './uploads/audio/';
			if (!is_dir($upload_path)) {
				mkdir($upload_path, 0777, true);
			}
	
			$field = $this->input->post('field_name');  // e.g., khmer, devanagari, roman
			$id = $this->input->post('vowel_id');        // ID of the vowel row
			$filename = $field . '_' . $id . '_' . time() . '.mp3';
	
			$full_path = $upload_path . $filename;
	
			if (move_uploaded_file($_FILES['audio_data']['tmp_name'], $full_path)) {
				// Load database
				$this->load->database();
	
				// Determine column name based on field
				$audio_column = $field; // e.g., khmer_audio, devanagari_audio
	
				// Update the vowel row with new audio filename
				$this->db->where('id', $id);
				$this->db->update('vowels', [ $audio_column => $filename ]);
	
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
    $vowel_id   = $this->input->post('vowel_id');
    $field_name = $this->input->post('field_name');

    if (!$vowel_id || !$field_name) {
        show_error("Invalid request", 400);
        return;
    }

    $this->db->select($field_name);
    $this->db->where('id', $vowel_id);
    $row = $this->db->get('vowels')->row();

    if ($row && !empty($row->$field_name)) {
        $file_path = FCPATH . 'uploads/audio/vowels/' . $row->$field_name;
        if (file_exists($file_path)) {
            @unlink($file_path);
        }

        $this->db->where('id', $vowel_id)
                 ->update('vowels', [ $field_name => null ]);

        echo "success";
        return;
    }

    show_error("Audio file not found", 404);
}

	public function add() {
		$data['page_title'] = 'Add Vowel';

		$post = $this->input->post('data');
		if ($this->input->post()) {
			
			$vowelData = array(
				'eng_word' => $post['eng_word'],
				'rom_word' => $post['rom_word']
			);

			$file = $_FILES['english_audio'];

			if ($file['name']) {
				$vowelData['audio_file'] = $this->upload_file($file);
			}


			$this->db->insert('tbl_words', $vowelData);
			$id = $this->db->insert_id();

			if($id > 0) {
				$lang_ids = $this->input->post('lang_id');
				$langs = $this->input->post('lang');
				$words = $this->input->post('word');
				$roms = $this->input->post('roms');

				foreach($lang_ids as $index => $lang_id) {
					if($words[$index]) {
						$vowelLangData = [
							'wid' => $id,
							'lang_id' => $lang_id,
							'lang_name' => $langs[$index],
							'lang_word' => $words[$index],
							'rom_word' => $roms[$index]
						];

						$file = $_FILES['audio_'.$lang_id];
						if ($file && $file['name']) {
							$vowelLangData['audio_file'] = $this->upload_file($file);
						}
						$this->db->insert('tbl_lang_words', $vowelLangData);
					}
				}
				// $this->session->set_flashdata('message', 'Vowel added successfully.');
				// redirect('admin/vowels');
				$data['saved'] = 1;
			}

		}

		$data['languages'] = $this->db->where('status', 1)->get('tbl_language')->result_array();
		$this->load->view('add_vowel', $data);	
	}


		public function upload_file($file) {

			$allowed_types = array('audio/mpeg', 'audio/mp3', 'audio/wav');
        	// $max_size = 5242880; // 5MB in bytes

			if ($file['name']) {
				if (!in_array($file['type'], $allowed_types)) {
					return null; // Invalid file type
				}
				$upload_path = './uploads/audio/';

				$filename = 'audio_' . time() . '_' . preg_replace('/\s+/', '_', $file['name']);
				$full_path = $upload_path . $filename;
				if (move_uploaded_file($file['tmp_name'], $full_path)) {
					return $filename;
				}
			}

		}

	public function delrow () {

		 $id = $this->input->post('id');
		$row = $this->db->where('id', $id)->get('tbl_words')->row_array();
		// print_r($row);
		if($row) {
			unlink('./uploads/audio/'. $row['audio_file']);
			$this->db->where('id', $id)->delete('tbl_words');
			$langs = $this->db->where('wid', $id)->get('tbl_lang_words')->result_array();
			
			foreach($langs as $lang) {
				$this->db->where('id', $lang['id'])->delete('tbl_lang_words');
				unlink('./uploads/audio/'. $lang['audio_file']);
			}
		}
	}
}