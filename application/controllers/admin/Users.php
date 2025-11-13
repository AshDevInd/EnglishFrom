<?php defined('BASEPATH') or exit('');
class Users extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
	}

    public function index () {
        $rows = $this->db->where('type', 2)->get('users')->result_array();
      
        $data['users'] = $rows;
        $data['page_title'] = 'users';
        $this->load->view('users/view', $data);
    }

	function add()
	{   

        $post = $this->input->post('data');
        $chk = $this->db->where('email', $post['email'])->get('users')->row_array();

        if(!empty($post))  {
            if(empty($chk)) {
                $post['password'] = sha1($post['password']);
                $id = $this->db->insert('users', $post);
                if($id > 0) {
                    $data['success'] = 1;
                }
            } else {
                $data['error'] = 2;
            }
        }
        $data['page_title'] = 'users';

        $this->load->view('users/add', $data);

    }

    function edit($id)
	{   
        $post = $this->input->post('data');
        if(!empty($post)) {
            
            if($post['password']) {
                $post['password'] = sha1($post['password']);
            }

            $last_id = $this->db->where('id', $id)->update('users', $post);
            if($last_id > 0) {
                $data['success'] = 1;
            }
        }
        $data['row'] = $this->db->where('id', $id)->get('users')->row_array();
        $data['page_title'] = 'users';

        $this->load->view('users/edit', $data);

    }

}