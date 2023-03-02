<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $this->template->temp_default();
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('akses/Menu',$siteLang);
            $this->lang->load('ListMenu',$siteLang);
            $this->load->model('menu_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/akses/Menu');
    }
    
    //list menu
    public function index()
    {
        $Data["title_web"]=$this->lang->line('title_web');
        $Data["subheader"]=$this->lang->line('subheader');
        $Data["list_header"]=$this->lang->line('list_header');
        $Data["input_header"]=$this->lang->line('input_header');
        $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
        $Data['AlertInput']=$this->session->flashdata('AlertInput');
        
        $DataMenu=$this->menu_model->get_menu_all();
        $Data['ListMenu']=  get_value_array($DataMenu,['kd_menu','level'],'menu',TRUE);
           
        $DataMenu2 = $this->menu_model->get_menu_parent();
        
        $ListMenuParent=array();
        foreach($DataMenu2->result() as $row)
        {
            $ListMenuParent[$row->kd_menu]['menu']=$this->lang->line('menu_'.$row->kd_menu);
            $ListMenuParent[$row->kd_menu]['section']=$row->stat_section;
            $ListMenuParent[$row->kd_menu]['link']=$row->link;
            $ListMenuParent[$row->kd_menu]['icon']=$row->icon;
        }
        $DataMenuChild = $this->menu_model->get_menu_child_all();
        
        $ListMenuChild=array();
        foreach($DataMenuChild->result() as $row)
        {
            $ListMenuChild[$row->kd_menu_parent][$row->kd_menu]['menu']=$this->lang->line('menu_'.$row->kd_menu);
            $ListMenuChild[$row->kd_menu_parent][$row->kd_menu]['section']=$row->stat_section;
            $ListMenuChild[$row->kd_menu_parent][$row->kd_menu]['link']=$row->link;
            $ListMenuChild[$row->kd_menu_parent][$row->kd_menu]['icon']=$row->icon;
        }
        
        $Data['ListMenuParent']=$ListMenuParent;
        $Data['ListMenuChild']=$ListMenuChild;
        
        //insert user activity
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
        
        $this->template->add_section('viewjs', 'akses/Menu_vf/v_Menu_js');
        $this->load->view('Menu_vf/v_Menu',$Data);
    }
    //get list menu json
    
    // insert menu
    public function save()
    {
        $this->template->unset_template();
        $Data=["success"=>false,"messages"=>array()];
        $this->form_validation->set_rules('menu', $this->lang->line('menu'), 'trim|required');
        $this->form_validation->set_rules('link', $this->lang->line('link'), 'trim|required');
        $this->form_validation->set_rules('order', $this->lang->line('order'), 'trim|required|numeric');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        if ($this->form_validation->run() == FALSE){
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
        }else{
            $MenuParent=$this->input->post('kd_menu_parent');
            $kd_menu_parent="";
            $level=1;
            if($MenuParent!=""){
                $tempArr= explode("|", $MenuParent);
                $kd_menu_parent=$tempArr[0];
                $level=$tempArr[1];
                $level=$level+1;
            }
            $Input=['menu'=>$this->input->post('menu'),
                    'order'=>$this->input->post('order'),
                    'kd_menu_parent'=>$kd_menu_parent,
                    'level'=>$level,
                    'icon'=>$this->input->post('icon'),
                    'link'=>$this->input->post('link'),
                    'status_show'=>$this->input->post('status_show'),
                    'quick_menu'=>$this->input->post('quick_menu'),
                    'icon_quick'=>$this->input->post('icon_quick'),
                    'stat_section'=>$this->input->post('stat_section')
                    ];
            
            $id=$this->menu_model->insert_menu($Input);
            // add text pada semua file lang ListMenu di semua folder language
            $this->lang->add_line('menu_'.$id, $this->input->post('menu'), 'ListMenu');
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            //insert user activity
            $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$id,$Input);
            //die();
            $Data["success"]=true;
        }
        
        echo json_encode($Data);
    }
    // view menu
    public function get_data_menu()
    {
        $this->template->unset_template();
        $Kode=$this->uri->segment(4);
        $DataMenu = $this->menu_model->get_menu_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array()];
        if($DataMenu->num_rows() > 0)
        {
            $Data['data']= $DataMenu->row_array();
            $Data['data']['kd_menu_parent']=$Data['data']['kd_menu_parent_real']."|".$Data['data']['parent_level'];
        }
        
        echo json_encode($Data);
    }
    // edit menu
    public function edit()
    {
        $this->template->unset_template();
        $Kode=$this->uri->segment(4);
        $DataMenu = $this->menu_model->get_menu_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array()];
        if($DataMenu->num_rows() > 0)
        {
            $this->form_validation->set_rules('menu', $this->lang->line('menu'), 'trim|required');
            $this->form_validation->set_rules('link', $this->lang->line('link'), 'trim|required');
            $this->form_validation->set_rules('order', $this->lang->line('order'), 'trim|required|numeric');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            if ($this->form_validation->run() == FALSE){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                    $Data['data']= $DataMenu->row_array();
                }
            }else{
                $MenuParent=$this->input->post('kd_menu_parent');
                $kd_menu_parent="";
                $level=1;
                if($MenuParent!=""){
                    $tempArr= explode("|", $MenuParent);
                    $kd_menu_parent=$tempArr[0];
                    $level=$tempArr[1];
                    $level=$level+1;
                }
                $Input=['menu'=>$this->input->post('menu'),
                        'order'=>$this->input->post('order'),
                        'kd_menu_parent'=>$kd_menu_parent,
                        'level'=>$level,
                        'icon'=>$this->input->post('icon'),
                        'link'=>$this->input->post('link'),
                        'status_show'=>$this->input->post('status_show'),
                        'quick_menu'=>$this->input->post('quick_menu'),
                        'icon_quick'=>$this->input->post('icon_quick'),
                        'stat_section'=>$this->input->post('stat_section')
                        ];

                $this->menu_model->update_menu($Kode,$Input);
                // ganti text pada semua file lang ListMenu di semua folder language
                $this->lang->change_line('menu_'.$Kode, $this->input->post('menu'), 'ListMenu');
                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                //insert user activity
                $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Input,$DataMenu->row_array());
                $Data["success"]=true;
            }

        }
            echo json_encode($Data);
    }
    //delete menu
    public function delete(){
        $DataDelete=$this->uri->segment(4);
//        var_dump($DataDelete);
        //get history data
        $DataMenu = $this->menu_model->get_menu_by_code($DataDelete);
        //delete data
        $this->menu_model->delete_menu($DataDelete);
        // delete text pada semua file lang ListMenu di semua folder language
        $this->lang->remove_line('menu_'.$DataDelete, 'ListMenu');
        $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
        //insert user activity
        $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataMenu->row_array());
        //redirect('akses/Menu');


    }
}

