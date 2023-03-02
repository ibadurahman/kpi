<?php

/* 
 * Mion_auth (my ion auth)
 * class yang berisi method tambahan dari ion auth
 */

require APPPATH . 'libraries/Ion_auth.php';

class Mion_auth extends Ion_auth {
    public function __construct()
    {
        parent::__construct();
        
    }
    public function restrict($uri)
        {
            if(!$this->logged_in_new())
            {
//                die();
                redirect($uri, 'refresh');
            }
//                echo time()."<br/>";
//                echo date('Y-m-d H:i:s', time())."<br/>";
//                echo (time()+63072000)."<br/>";
//                echo date('Y-m-d H:i:s', (time()+63072000))."<br/>";
//                die();
        }
    /**
	 * Auto logs-in the user if they are remembered
	 * @return bool Whether the user is logged in
	 * @author Mathew
	 **/
	public function logged_in_new()
	{
		$this->ion_auth_model->trigger_events('logged_in');

		$recheck = $this->ion_auth_model->recheck_session();
                //var_dump(get_cookie($this->config->item('remember_cookie_name', 'ion_auth')));
		// auto-login the user if they are remembered
		if (!$recheck && get_cookie($this->config->item('remember_cookie_name', 'ion_auth')))
		{
                        $recheck = $this->check_session_perusahaan();
//                        echo $recheck."--2";
			$recheck = $this->ion_auth_model->login_remembered_user();
//                        echo $recheck."--3";
		}

		return $recheck;
	}
        
    public function check_session_perusahaan()
    {

            $recheck = $this->recheck_session_perusahaan();

            // auto-login the user if they are remembered
            if (!$recheck && get_cookie($this->config->item('remember_cookie_name', 'ion_auth')))
            {
                if(get_cookie($this->config->item('perusahaan_cookie_name', 'ion_auth')))
                {
                    $SesPerusahaan = get_cookie($this->config->item('perusahaan_cookie_name', 'ion_auth'));
                    
                    $this->session->set_userdata('ses_perusahaan', $SesPerusahaan);
                    
                    $recheck=TRUE;
                }else{
                    $recheck = FALSE;
                }
            }

            return $recheck;
    }    
    public function recheck_session_perusahaan()
    {
            if (empty($this->session->userdata('ses_perusahaan')))
            {
                    return FALSE;
            }


            return (bool)$this->session->userdata('ses_perusahaan');
    }
    
    public function set_cookies_perusahaan($kd_perusahaan,$kd_departemen='')
    {
        // if the user_expire is set to zero we'll set the expiration two years from now.
	if($this->config->item('user_expire', 'ion_auth') === 0)
	{
		//$expire = self::MAX_COOKIE_LIFETIME;
                // angka di ambil dri ion_auth_model MAX_COOKIE_LIFETIME
                $expire = 63072000;
	}
	// otherwise use what is set
	else
	{
		$expire = $this->config->item('user_expire', 'ion_auth');
	}

	set_cookie([
		'name'   => $this->config->item('perusahaan_cookie_name', 'ion_auth'),
		'value'  => $kd_perusahaan,
		'expire' => time()+$expire
	]);
        $this->session->set_userdata('ses_perusahaan', $kd_perusahaan);
        if($kd_departemen!=""){
            $this->session->set_userdata('ses_departemen', $kd_departemen);
        }
        return TRUE;
    }
    
    public function is_allowed($kd_permission)
    {
        
        if (!$this->is_admin())
        {
            $this->load->model("akses/menu_model");
            $user_id = $this->session->userdata('user_id');
            $permission = $this->menu_model->get_permission_menu($user_id,$kd_permission);
            if($permission->num_rows() > 0)
            {
                return true;
            }else{
                return false;
            }
            
        }else{
            return TRUE;
        }
    }
}
