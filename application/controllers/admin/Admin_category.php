<?php
defined('BASEPATH') or exit('');
class Admin_category extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Khmer_category_model');
    }

    public function index()
    {
        $data['categories'] = $this->Khmer_category_model->get_all();
        $this->load->view('category_list', $data);
        
    }

    public function create()
    {
        if ($this->input->post()) {
            $cat = [
                'name' => $this->input->post('name', true),
                'vowel' => $this->input->post('vowel', true)
            ];
            $this->Khmer_category_model->insert($cat);
            redirect('admin/admin_category');
        }
        $this->load->view('category_form');
    }

    public function edit($id)
    {
        $data['cat'] = $this->Khmer_category_model->get($id);
        if ($this->input->post()) {
            $cat = [
                'name' => $this->input->post('name', true),
                'vowel' => $this->input->post('vowel', true)
            ];
            $this->Khmer_category_model->update($id, $cat);
            redirect('admin/admin_category');
        }
        $this->load->view('category_form', $data);
        
    }

    public function delete($id)
    {
        $this->Khmer_category_model->delete($id);
        redirect('admin_category');
    }
}
