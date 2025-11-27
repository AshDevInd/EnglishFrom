<?php defined('BASEPATH') or exit('');

class Vocabs extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Vocabs_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->library('upload');
	}

	function index()
	{
		$this->db->where('is_deleted', 0);
		$query = $this->db->get('vocabs');
		$data['vocabs'] = $query->result_array();
		$data['page_title'] = 'vocabs';
		$this->load->view('vocabs', $data);
	}

	public function create()
	{
		if ($this->input->method() != 'post') {
			$this->session->unset_userdata('message');
			$this->session->unset_userdata('error');
		}
		// Handle form submission
		if ($this->input->method() == 'post') {

			$serial_number = $this->input->post('serial_number');
			$category = $this->input->post('data')['parent'];
			$combination = $this->input->post('combination');
			$vowel = $this->input->post('vowel');
			$khmer = $this->input->post('khmer');
			$devanagari = $this->input->post('devanagari');
			$roman = $this->input->post('roman');
			$ipa = $this->input->post('ipa');

			$audio_option = $this->input->post('audio_option');

			$khmer_audio = '';
			$khmer_my_version_audio = '';
			$error = '';

			// Handle Khmer Main Audio
			if ($audio_option == 'upload' && !empty($_FILES['khmer_audio_file']['name'])) {
				$config['upload_path'] = './uploads/audio/vocabs/';
				$config['allowed_types'] = 'mp3|wav|ogg|m4a';
				$config['max_size'] = 10240;
				$config['encrypt_name'] = true;

				if (!is_dir($config['upload_path'])) {
					mkdir($config['upload_path'], 0777, true);
				}

				$this->upload->initialize($config);

				if ($this->upload->do_upload('khmer_audio_file')) {
					$upload_data = $this->upload->data();
					$khmer_audio = $upload_data['file_name'];
				} else {
					$error = $this->upload->display_errors();
				}
			} elseif ($audio_option == 'record') {
				// Get recorded filename from POST
				$khmer_audio = $this->input->post('khmer_audio');

				if (!empty($khmer_audio)) {
					$temp_path = './uploads/audio/vocabs/temp/' . $khmer_audio;
					$permanent_path = './uploads/audio/vocabs/' . $khmer_audio;

					if (file_exists($temp_path)) {
						if (!is_dir('./uploads/audio/vocabs/')) {
							mkdir('./uploads/audio/vocabs/', 0777, true);
						}
						rename($temp_path, $permanent_path);
					}
				}
			}

			// Handle Khmer My Version Audio - ALWAYS check POST data
			$khmer_my_version_audio = $this->input->post('khmer_my_version_audio');

			if (!empty($khmer_my_version_audio)) {
				$temp_path = './uploads/audio/vocabs/temp/' . $khmer_my_version_audio;
				$permanent_path = './uploads/audio/vocabs/' . $khmer_my_version_audio;

				if (file_exists($temp_path)) {
					if (!is_dir('./uploads/audio/vocabs/')) {
						mkdir('./uploads/audio/vocabs/', 0777, true);
					}
					rename($temp_path, $permanent_path);
				}
			}

			if (empty($error)) {
				$data_to_save = [
					'serial_number'          => $serial_number,
					'category'               => $category,
					'combination'            => $combination,
					'vowel'                  => $vowel,
					'khmer'                  => $khmer,
					'devanagari'             => $devanagari,
					'roman'                  => $roman,
					'ipa'                    => $ipa,
					'khmer_audio'            => $khmer_audio,
					'khmer_my_version_audio' => $khmer_my_version_audio,
				];

				// Debug - uncomment to check values
				// echo '<pre>'; print_r($data_to_save); die();

				$this->db->insert('vocabs', $data_to_save);
				$this->session->set_flashdata('message', 'Record saved successfully!');

				redirect(base_url('admin/vocabs/create'));
			} else {
				$this->session->set_flashdata('error', $error);
			}
		}

		// Load form data
		$data['cats'] = $this->db->order_by('id', 'asc')->get('khmer_category')->result_array();
		$data['temp_id'] = uniqid('temp_', true);
		$data['page_title'] = 'Add Vocab';

		$this->load->view('add_vocab', $data);
	}

	public function edit($id)
	{
		// Clear old flash on GET
		if ($this->input->method() != 'post') {
			$this->session->unset_userdata('message');
			$this->session->unset_userdata('error');
		}

		if ($this->input->method() == 'post') {
			$serial_number = $this->input->post('serial_number');
			$category      = $this->input->post('data')['parent'];
			$combination   = $this->input->post('combination');
			$vowel         = $this->input->post('vowel');
			$khmer         = $this->input->post('khmer');
			$devanagari    = $this->input->post('devanagari');
			$roman         = $this->input->post('roman');
			$ipa           = $this->input->post('ipa');

			// Get filenames from hidden inputs (may be existing or new temp ones)
			$khmer_audio            = $this->input->post('khmer_audio');
			$khmer_my_version_audio = $this->input->post('khmer_my_version_audio');

			// 1) Move MAIN audio from temp to final if it is a new temp file
			if (!empty($khmer_audio) && strpos($khmer_audio, 'temp_') !== false) {
				$src  = FCPATH . 'uploads/audio/vocabs/temp/' . $khmer_audio;
				$dest = FCPATH . 'uploads/audio/vocabs/' . $khmer_audio;
				if (file_exists($src)) {
					if (!is_dir(FCPATH . 'uploads/audio/vocabs/')) {
						mkdir(FCPATH . 'uploads/audio/vocabs/', 0777, true);
					}
					rename($src, $dest);
				}
			}

			// 2) Move MY VERSION audio from temp to final if it is a new temp file
			if (!empty($khmer_my_version_audio) && strpos($khmer_my_version_audio, 'temp_') !== false) {
				$src2  = FCPATH . 'uploads/audio/vocabs/temp/' . $khmer_my_version_audio;
				$dest2 = FCPATH . 'uploads/audio/vocabs/' . $khmer_my_version_audio;
				if (file_exists($src2)) {
					if (!is_dir(FCPATH . 'uploads/audio/vocabs/')) {
						mkdir(FCPATH . 'uploads/audio/vocabs/', 0777, true);
					}
					rename($src2, $dest2);
				}
			}

			// Now build data array – filenames are final at this point
			$data_to_save = [
				'serial_number'          => $serial_number,
				'category'               => $category,
				'combination'            => $combination,
				'vowel'                  => $vowel,
				'khmer'                  => $khmer,
				'devanagari'             => $devanagari,
				'roman'                  => $roman,
				'ipa'                    => $ipa,
				'khmer_audio'            => $khmer_audio,
				'khmer_my_version_audio' => $khmer_my_version_audio,
			];

			$this->db->where('id', $id);
			$this->db->update('vocabs', $data_to_save);

			$this->session->set_flashdata('message', 'Record updated successfully!');
			redirect(base_url('admin/vocabs/index'));
			exit;
		}

		// GET: load form with existing data
		$row = $this->Vocabs_model->getVocabById($id);
		if (!$row || (int)$row['is_deleted'] === 1) {
			show_404();
		}

		$data['row']       = $row;
		$data['cats']      = $this->db->order_by('id', 'asc')->get('khmer_category')->result_array();
		$data['temp_id']   = uniqid('temp_', true);
		$data['page_title'] = 'Edit Vocab';

		$this->load->view('add_vocab', $data);
	}


	public function soft_delete($id)
	{
		// set is_deleted = 1 instead of deleting row
		$this->db->where('id', $id);
		$this->db->update('vocabs', ['is_deleted' => 1]);

		$this->session->set_flashdata('message', 'Record deleted successfully!');
		redirect(base_url('admin/vocabs/index'));
		exit;
	}



	function importVocabs()
	{
		$this->load->view('import-vocabs');
	}

	public function import_csv()
	{
		if (empty($_FILES['csv_file']['name'])) {
			echo "Please upload a CSV file.";
			return;
		}

		$filename = $_FILES['csv_file']['tmp_name'];
		$file = fopen($filename, "r");

		// Skip header
		fgetcsv($file);

		$count = 0;
		while (($data = fgetcsv($file)) !== FALSE) {
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
			$count++;
		}
		fclose($file);

		$this->session->set_flashdata('message', $count . ' records imported successfully!');
		redirect(base_url('admin/vocabs/index'));
	}

	public function upload_audio_temp()
	{
		header('Content-Type: application/json');

		if (!isset($_FILES['audio_data']) || $_FILES['audio_data']['error'] !== 0) {
			http_response_code(400);
			echo json_encode([
				'success' => false,
				'message' => 'No file uploaded or upload error'
			]);
			return;
		}

		$upload_path = './uploads/audio/vocabs/temp/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0777, true);
		}

		$field = $this->input->post('field_name');
		$temp_id = $this->input->post('temp_id');

		if (!$field || !$temp_id) {
			http_response_code(400);
			echo json_encode([
				'success' => false,
				'message' => 'Missing field name or temp ID'
			]);
			return;
		}

		// Generate unique filename
		$filename = $field . '_' . $temp_id . '_' . time() . '.mp3';
		$full_path = $upload_path . $filename;

		if (move_uploaded_file($_FILES['audio_data']['tmp_name'], $full_path)) {
			echo json_encode([
				'success' => true,
				'filename' => $filename,
				'message' => 'Audio uploaded successfully'
			]);
		} else {
			http_response_code(500);
			echo json_encode([
				'success' => false,
				'message' => 'Failed to move uploaded file'
			]);
		}
	}

	public function upload_audio()
	{
		header('Content-Type: application/json');

		if (!isset($_FILES['audio_data']) || $_FILES['audio_data']['error'] !== 0) {
			http_response_code(400);
			echo json_encode([
				'success' => false,
				'message' => 'No file uploaded or upload error'
			]);
			return;
		}

		$upload_path = './uploads/audio/vocabs/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0777, true);
		}

		$field = $this->input->post('field_name');
		$id = $this->input->post('vocabs_id');

		if (!$field || !$id) {
			http_response_code(400);
			echo json_encode([
				'success' => false,
				'message' => 'Missing field name or ID'
			]);
			return;
		}

		// Generate unique filename
		$filename = $field . '_' . $id . '_' . time() . '.mp3';
		$full_path = $upload_path . $filename;

		if (move_uploaded_file($_FILES['audio_data']['tmp_name'], $full_path)) {
			// Update database with new filename
			$this->db->where('id', $id);
			$this->db->update('vocabs', [$field => $filename]);

			if ($this->db->affected_rows() >= 0) {
				echo json_encode([
					'success' => true,
					'filename' => $filename,
					'message' => 'Audio uploaded successfully'
				]);
			} else {
				echo json_encode([
					'success' => false,
					'message' => 'Database update failed'
				]);
			}
		} else {
			http_response_code(500);
			echo json_encode([
				'success' => false,
				'message' => 'Failed to move uploaded file'
			]);
		}
	}

	public function delete_audio()
	{
		$vocabs_id  = $this->input->post('vocabs_id');
		$field_name = $this->input->post('field_name');

		if (!$vocabs_id || !$field_name) {
			http_response_code(400);
			echo "Invalid request";
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
				->update('vocabs', [$field_name => null]);

			echo "success";
			return;
		}

		http_response_code(404);
		echo "Audio file not found";
	}
}
