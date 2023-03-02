<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Login extends CI_Controller
{
    public $data = [];
    
    public function __construct()
    {
            parent::__construct();

            $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

            $this->lang->load('auth');
    }
    
    /**
	 * Log the user in
	 */
    public function index()
	{

		if (!$this->mion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('akses/Login/login', 'refresh');
		}
		else
		{
			redirect('dashboard/Home', 'refresh');
		}
	}
        
    public function login()
    {
            $this->data['title'] = $this->lang->line('login_heading');

                    // the user is not logging in so display the login page
                    // set the flash data error message if there is one
                    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                    $this->data['filejs']=$this->load->view('akses/login_vf/v_login_js', '', TRUE);


                    $this->_render_page('akses/login_vf/v_login', $this->data);
            
    }
    public function validasi()
    {
            $this->data['title'] = $this->lang->line('login_heading');
            $Data=["success"=>false,"messages"=>array()];
            // validate form input
            $this->form_validation->set_rules('email', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
            $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

            if ($this->form_validation->run() === TRUE)
            {
                    // check to see if the user is logging in
                    // check for "remember me"
                    $remember = (bool)$this->input->post('remember');

                    if ($this->mion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
                    {
                            //if the login is successful
                            //redirect them back to the home page
//                            $this->session->set_flashdata('message', $this->mion_auth->messages());
//                            redirect('dashboard/Home', 'refresh');
                            $this->load->model("dashboard/home_model");
                            $DataPegawai=$this->home_model->get_pegawai_by_userid_home($this->session->userdata('user_id'));
                            if($DataPegawai->num_rows()>0){
                                $this->turn_on_perusahaan($DataPegawai->row()->kd_perusahaan,$DataPegawai->row()->kd_departemen);
                            }
                            $Data['success'] = TRUE;
                            $this->useractivity->run_acitivity('Login',$this->input->post('email'));
                    }
                    else
                    {
                            // if the login was un-successful
                            // redirect them back to the login page
//                            $this->session->set_flashdata('message', $this->mion_auth->errors());
//                            redirect('akses/Login/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
                            $Data['messages'] = $this->mion_auth->errors();
                    }
            }
            else
            {
                    $Data['messages'] = 'error';
            }
            echo json_encode($Data);
    }
    /**
	 * @param string     $view
	 * @param array|null $data
	 * @param bool       $returnhtml
	 *
	 * @return mixed
	 */
	public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
	{

		$viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml)
		{
			return $view_html;
		}
	}
        /**
	 * Log the user out
	 */
	public function logout()
	{
		$this->data['title'] = "Logout";
                
                $this->useractivity->run_acitivity('Logout',$this->session->userdata('identity'));
		// log the user out
		$this->mion_auth->logout();
		// redirect them to the login page
		redirect('akses/Login/login', 'refresh');
	}
        
        //set perusahaan aktif di aplikasi
        public function turn_on_perusahaan($Kode,$kd_departemen)
        {
            $this->mion_auth->set_cookies_perusahaan($Kode,$kd_departemen);
        }
}

