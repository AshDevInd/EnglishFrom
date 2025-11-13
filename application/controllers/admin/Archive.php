<?php defined('BASEPATH') or exit('');
class Archive extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
	}

    public function index () {

        $rows = $this->db->get('tbl_archive')->result_array();
        foreach($rows as $row) {
            $cat = $this->db->where('id', $row['category'])->get('category')->row_array();
            $row['cat_name'] = $cat['cat_name'];
            $res[] = $row;
        }

        $data['archives'] = $res;

        $this->load->view('archive/view', $data);
    }

	function add()
	{   
        $uid = $this->session->userdata['LoginSession']['id'];
        $utype = $this->session->userdata['LoginSession']['type'];

        $post = $this->input->post('data');

        $cats = $this->db->where('parent', 0)->order_by('id', 'desc')->get('category')->result_array();

        foreach($cats as $cat) {
            $cat['sub'] = $this->db->where('parent', $cat['id'])->get('category')->result_array();
            $res[] = $cat;
        }

        // $chk = $this->where()->get()->

        if(!empty($post)) {

            if($_FILES['ufile']) {
                $file = $_FILES['ufile'];
                $name = $file['name'];
                $ext = pathinfo($name);
                $ext = $ext['extension'];
                $new_name = str_replace(' ','-',strtolower($name));
            
                $dir_name = pathinfo($new_name, PATHINFO_FILENAME);
                $dir_name = str_replace(' ', '-', strtolower($dir_name));  // Replace spaces with dashes
                
                if($this->session->userdata['LoginSession']['type'] == 2) {
                    $dir_path = './uploads/tmp/' . $dir_name;
                } else {
                    $dir_path = './' . $dir_name;
                }
                
                if (!is_dir($dir_path)) {
                    
                    move_uploaded_file($_FILES['ufile']['tmp_name'], './'.$new_name);
                    
                    $zip = new ZipArchive;
                        if($zip->open('./'.$new_name) === TRUE) {
                            $zip->extractTo($dir_path);
                            $zip->close();
                        } 
                    unlink($new_name);
                    $post['path_name'] = $dir_name;
                } else {
                    $data['error'] = 2;
                    $err = 1;
                }

            }

            if(!$err) {
                $post['uid'] = $uid;
                $post['utype'] = $utype;
                $post['verify_sts'] = $utype == 1 ? 1 : 0;
                $id = $this->db->insert('tbl_archive', $post);
                if($id > 0) {
                    $data['success'] = 1;
                }
            }

        }

        $data['cats'] = $res;

        $this->load->view('archive/add', $data);

    }

    function edit($id)
	{   

        
        $post = $this->input->post('data');

        $cats = $this->db->where('parent', 0)->order_by('id', 'desc')->get('category')->result_array();

        foreach($cats as $cat) {
            $cat['sub'] = $this->db->where('parent', $cat['id'])->get('category')->result_array();
            $res[] = $cat;
        }

         if(!empty($_FILES['ufile'])) {

            $file = $_FILES['ufile'];
            $name = $file['name'];
            $ext = pathinfo($name);
            $ext = $ext['extension'];
            $new_name = str_replace(' ','-',strtolower($name));
           
            $dir_name = pathinfo($new_name, PATHINFO_FILENAME);
            $dir_name = str_replace(' ', '-', strtolower($dir_name));  // Replace spaces with dashes
           
            if($this->session->userdata['LoginSession']['type'] == 2) {
                $dir_path = './uploads/tmp/' . $dir_name;
                $post['verify_sts'] = 0;
            } else {
                $dir_path = './' . $dir_name;
                $post['verify_sts'] = 1;
            }

            move_uploaded_file($_FILES['ufile']['tmp_name'], './'.$new_name);
            
            $zip = new ZipArchive;
            if($zip->open('./'.$new_name) === TRUE) {
                $zip->extractTo($dir_path);
                $zip->close();
            } 
                
            @unlink($new_name);
            $post['path_name'] = $dir_name;
        }

        if(!empty($post)) {
            
            $sid = $this->db->where('id', $id)->update('tbl_archive', $post);
            if($sid > 0) {
                $data['success'] = 1;
            }
        }

        $data['cats'] = $res;
        $data['row'] = $this->db->where('id', $id)->get('tbl_archive')->row_array();

        $this->load->view('archive/add', $data);

    }


    public function approve () {

        $id = $this->input->post('id');
        
        $data = $this->db->where('id', $id)->get('tbl_archive')->row_array();
        // print_r();
        if($id > 0 && $this->session->userdata['LoginSession']['type'] == 1) {
            $this->db->where('id', $id)->update('tbl_archive', ['verify_sts' => 1]);
            rename('./uploads/tmp/'.$data['path_name'], './'.$data['path_name']);
        }

    }

    public function delrow() {
        $id = $this->input->post('id');
        
        $data = $this->db->where('id', $id)->get('tbl_archive')->row_array();
        // print_r();
        if($id > 0 && $this->session->userdata['LoginSession']['type'] == 1) {
            if($data['verify_sts'] == 1) {
                $name = $data['path_name'];
            } else {
                $name = './uploads/tmp/'.$data['path_name'];
            }

            $this->deleteFolder($name);
            // rmdir($name);
            $this->db->where('id', $id)->delete('tbl_archive');
        }
    }

    public function deleteFolder($folderPath) {

        if (!is_dir($folderPath)) {
            return;
        }

        $files = array_diff(scandir($folderPath), array('.', '..'));

        foreach ($files as $file) {
            $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;

            if (is_dir($filePath)) {
                deleteFolder($filePath); 
            } else {
                unlink($filePath);  
            }
        }

        rmdir($folderPath);
    }

}