<?php defined('BASEPATH') or exit('');
class Languages extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
        $this->load->helper(array('form', 'url'));
	}

	function index()
	{   
        $data = $this->db->get('tbl_language')->result_array();
        $data['languages'] = $data;
        $data['page_title'] = 'languages';
        $this->load->view('language/language', $data);

    }

    function add()
	{
        $post = $this->input->post('data');
        
        if($post){
            $this->db->insert('tbl_language', $post);
            $last_id = $this->db->insert_id();
            if($last_id)
            {
                $this->session->set_flashdata('message', 'Language added successfully.');
            }
            else{
                $this->session->set_flashdata('error', 'Something went wrong, please try again.');
            }
            redirect(base_url('admin/languages'));
        }
        $data['page_title'] = 'languages';
        $this->load->view('language/add', $data);

    }

     function edit($id)
	{
        // echo $id;
        $post = $this->input->post('data');
        $data = $this->db->get_where('tbl_language', array('id' => $id))->row_array();
        if($post){
            $updt = $this->db->where('id', $id)->update('tbl_language', $post);
            // $last_id = $this->db->insert_id();
            if($updt)
            {
                $this->session->set_flashdata('message', 'Language added successfully.');
            }
            else{
                $this->session->set_flashdata('error', 'Something went wrong, please try again.');
            }
            redirect(base_url('admin/languages'));
        }   
        $data['page_title'] = 'languages';
        $this->load->view('language/add', $data);

    }
}