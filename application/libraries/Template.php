<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template
{
    private $_CI;
    private $ListJs;
    private $ListCss;
    
    public function __construct()
    {
        $this->_CI =& get_instance();
    //    $this->_CI->load->library("firephp");
    }
    
    /*
     * temp_standard berfungsi untuk load template web default
     */
    public function temp_default()
    {
            $this->_CI->output->set_template('default');
            $this->get_js();
            $this->get_css();
            $Data['ListMenu']=$this->get_menu();
            $DataHeader = $this->get_data_header();
//            var_dump($Data['ListMenu']);
//            die();
            $this->_CI->load->section('t_header', 'themes/header',$DataHeader);
            $this->_CI->load->section('t_sidebar', 'themes/sidebar',$Data);
            $this->_CI->load->section('t_footer', 'themes/footer');
            
        //	$this->load->js('assets/themes/default/js/jquery-1.9.1.min.js');
        //	$this->load->js('assets/themes/default/hero_files/bootstrap-transition.js');
        //	$this->load->js('assets/themes/default/hero_files/bootstrap-collapse.js');
    }
    
    /*
     * set js berfungsi untuk menampung list file javascript d template
     * 
     * @param   String/array
     */
    public function set_js($fileJs="")
    {
        $DataJs=array();
        if($fileJs != "")
        {
            if(!is_array($fileJs))
            {
                $DataJs[]=$fileJs;
            }
            else
            {
                $DataJs=$fileJs;
            }
            $this->ListJs = $DataJs;
        }
    }
    
    /*
     * set css berfungsi untuk menampung list file CSS d template
     * 
     * @param   String/array
     */
    public function set_css($fileCss="")
    {
        $DataCss=array();
        if($fileCss != "")
        {
            if(!is_array($fileCss))
            {
                $DataCss[]=$fileCss;
            }
            else
            {
                $DataCss=$fileCss;
            }
            $this->ListCss = $DataCss;
        }
    }
    
    /*
     * get js berfungsi untuk load list file javascript d template
     * 
     */
    public function get_js()
    {
        $DataJs=array();
        if($this->ListJs != "" and count($this->ListJs)>0)
        {
            foreach($this->ListJs as $Val)
            {
                $this->_CI->load->js($Val);
            }
        }
    }
    
    /*
     * get css berfungsi untuk load list file css d template
     * 
     */
    public function get_css()
    {
        $DataCss=array();
        if($this->ListCss != "" and count($this->ListCss)>0)
        {
            foreach($this->ListCss as $Val)
            {
                $this->_CI->load->css($Val);
            }
        }
    }
    
    /*
     * get menu berfungsi untuk load list menu d template
     * 
     */
    public function get_menu()
    {
        $this->_CI->load->model("akses/menu_model");
        $siteLang = $this->_CI->session->userdata('site_lang');
        $this->_CI->lang->load('ListMenu',$siteLang);
        
        if ($this->_CI->mion_auth->is_admin()){
            $DataMenu = $this->_CI->menu_model->get_menu_parent_aktif();   
        }else{
            $DataMenu = $this->_CI->menu_model->get_menu_parent_aktif_permission($this->_CI->session->userdata('user_id'));
        }
        
        $ListMenuParent=array();
        foreach($DataMenu->result() as $row)
        {
            $ListMenuParent[$row->kd_menu]['menu']=$this->_CI->lang->line('menu_'.$row->kd_menu);
            $ListMenuParent[$row->kd_menu]['section']=$row->stat_section;
            $ListMenuParent[$row->kd_menu]['link']=$row->link;
            $ListMenuParent[$row->kd_menu]['icon']=$row->icon;
        }
        
        if ($this->_CI->mion_auth->is_admin()){
            $DataMenuChild = $this->_CI->menu_model->get_menu_child_aktif_all();
        }else{
            $DataMenuChild = $this->_CI->menu_model->get_menu_child_aktif_permission($this->_CI->session->userdata('user_id'));
        }
        
        $ListMenuChild=array();
        foreach($DataMenuChild->result() as $row)
        {
            $ListMenuChild[$row->kd_menu_parent][$row->kd_menu]['menu']=$this->_CI->lang->line('menu_'.$row->kd_menu);
            $ListMenuChild[$row->kd_menu_parent][$row->kd_menu]['section']=$row->stat_section;
            $ListMenuChild[$row->kd_menu_parent][$row->kd_menu]['link']=$row->link;
            $ListMenuChild[$row->kd_menu_parent][$row->kd_menu]['icon']=$row->icon;
        }
        
        $ListMenu['Parent']=$ListMenuParent;
        $ListMenu['Child']=$ListMenuChild;
        
        return $ListMenu;
    }
    
    public function add_section($section,$view,$data="")
    {
        $this->_CI->load->section($section, $view,$data);
    }
    
    public function unset_template()
    {
        $this->_CI->output->unset_template();
    }
    
    public function get_data_header()
    {
        
        $this->_CI->load->model("dashboard/home_model");
        $DataPerusahaan=$this->_CI->home_model->get_perusahaan_all_home();
        $Data['ListMenuPerusahaan']=  get_value_array($DataPerusahaan,'kd_perusahaan','nm_perusahaan',TRUE);
        $Data['ListQuickMenu']= $this->get_quick_menu();
        $Perusahaan = $this->_CI->home_model->get_perusahaan_by_code_home($this->_CI->session->userdata('ses_perusahaan'));
        $Data['ListReminder'] = $this->_CI->home_model->get_notifikasi($this->_CI->session->userdata('login_nip'));
        $Data['TotalReminder'] = $this->_CI->home_model->get_notifikasi_total($this->_CI->session->userdata('login_nip'));
        if($Perusahaan->num_rows() > 0){
            $Data['NamaPerusahaan'] = $Perusahaan->row()->nm_perusahaan;
        }
        return $Data;
    }
    public  function get_quick_menu(){
        if ($this->_CI->mion_auth->is_admin()){
            $DataMenu = $this->_CI->menu_model->get_quick_menu_aktif();   
        }else{
            $DataMenu = $this->_CI->menu_model->get_quick_menu_aktif_permission($this->_CI->session->userdata('user_id'));
        }
        $ListMenu=array();
        foreach($DataMenu->result() as $row)
        {
            $ListMenu[$row->kd_menu]['menu']=$this->_CI->lang->line('menu_'.$row->kd_menu);
            $ListMenu[$row->kd_menu]['section']=$row->stat_section;
            $ListMenu[$row->kd_menu]['link']=$row->link;
            $ListMenu[$row->kd_menu]['icon']=$row->icon_quick;
        }
        return $ListMenu;
    }
}