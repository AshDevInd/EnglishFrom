<?php defined('BASEPATH') or exit('');
class Category extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
	}

    public function index () {
        $cats = $this->db->get('category')->result_array();
        foreach($cats as $cat) {
            $ct = $this->db->where('id', $cat['parent'])->get('category')->row_array();
            $cat['pname'] = $ct['cat_name'];
            $rows[] = $cat;
        }
        $data['cats'] = $rows;
        $data['page_title'] = 'category';
        $this->load->view('category/view', $data);
    }

	function add()
	{   

        $post = $this->input->post('data');
        $data['cats'] = $this->db->where('parent', 0)->order_by('id', 'desc')->get('category')->result_array();

        if(!empty($post)) {
            $id = $this->db->insert('category', $post);
            if($id > 0) {
                $data['success'] = 1;
            }
        }
        $data['page_title'] = 'category';

        $this->load->view('category/add', $data);

    }

    function edit($id)
	{   

        $post = $this->input->post('data');
        $data['cats'] = $this->db->where('parent', 0)->order_by('id', 'desc')->get('category')->result_array();

        if(!empty($post)) {
            $lid = $this->db->where('id', $id)->update('category', $post);
            if($lid > 0) {
                $data['success'] = 1;
            }
        }
        $data['row'] = $this->db->where('id', $id)->get('category')->row_array();
        $data['page_title'] = 'category';

        $this->load->view('category/add', $data);

    }

}