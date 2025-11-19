<?php defined('BASEPATH') or exit('');
class Frontpage extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
        $this->load->model('Vocabs_model');
	}

	function index()
	{
	    
        $cats = $this->db->where('parent',0)->get('category')->result_array();
        // print_r($cats);
        foreach($cats as $cat) {
            $cat['sub'] = $this->db->where('parent', $cat['id'])->get('category')->result_array();
            $res[] = $cat;
        }

        // print_r($res);

        $data['cats'] = $res;

		$data['page_title'] = 'dashboard';
        $this->load->view('front/header',$data);
		$this->load->view('front/index',$data);
        $this->load->view('front/footer',$data);
	}

    function about()
    {   
        $data['page_title'] = 'About Us';
        $this->load->view('front/header',$data);
        $this->load->view('front/about',$data);
        $this->load->view('front/footer',$data);
    }

    function khmerscript()
    {   
        // $data['total_vocab'] = $this->Vocabs_model->get_vocabs_by_serial();
        $data['total_vocab'] = $this->Vocabs_model->get_vocabs_by_category();
        $data['vowel_grp'] = $this->Vocabs_model->get_vowel_group();
       
         
        $data['page_title'] = 'Khmer Script';
        $this->load->view('front/header',$data);
        $this->load->view('front/khmer-script',$data);
        $this->load->view('front/footer',$data);
    }

    public function category($id) {
        
        $cats = $this->db->where('parent',0)->get('category')->result_array();
        // print_r($cats);
        foreach($cats as $cat) {
            $cat['sub'] = $this->db->where('parent', $cat['id'])->get('category')->result_array();
            $res[] = $cat;
        }

        $data['cats'] = $res;
        $data['cat'] = $this->db->where('id', $id)->get('category')->row_array();

        $data['archive'] = $this->db->where(['category'=> $id, 'verify_sts' => 1])->get('tbl_archive')->result_array();


		$data['page_title'] = 'dashboard';
        $this->load->view('front/header',$data);
		$this->load->view('front/category',$data);
        $this->load->view('front/footer',$data);
    }

    public function archive($slug) {

    }
}