<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lbackend {

	public $instance;

	public $requestMethod;

	public function __construct() {
		global $instance,$request_method;
		$this->instance = &get_instance();
		$this->requestMethod = $this->instance->input->server('REQUEST_METHOD');
	}

	function activity()
	{
		//log user activity
		$logState = $this->instance->session->userdata('doNotLog');
		if(is_null($logState))
		{
			$logState = TRUE;
		}
		else
		{
			$logState = FALSE;
			$this->instance->session->unset_userdata('doNotLog');
		}
		switch ($this->requestMethod) {
			case 'GET':
				$getData = $this->instance->input->get();
                                if(count($getData)==0 and $this->instance->session->userdata('lbackend_data')!=NULL){
                                    $getData= $this->instance->session->userdata('lbackend_data');
                                    
                                }
				$cleanGetData = array();
				foreach($getData as $k=>$v)
				{
					if(strripos($k, 'pass') !== FALSE)
					{
						$v = 'No Peeping Password !';
					}
					$cleanGetData[$k]=$v;
				}
				if(!empty($cleanGetData))
				{
					$requestData = json_encode($cleanGetData,JSON_FORCE_OBJECT);
				}
				else
				{
                                    
					$requestData = 'No Request Data';
				}
                                $this->instance->session->unset_userdata('lbackend_data');
				break;
			case 'POST':
				$postData = $this->instance->input->post();
                                if(count($postData)==0 and $this->instance->session->userdata('lbackend_data')!=NULL){
                                    $postData= $this->instance->session->userdata('lbackend_data');
                                }
				$cleanPostData = array();
				foreach($postData as $k=>$v)
				{
					if(strripos($k, 'pass') !== FALSE)
					{
						$v = 'No Peeping Password !';
					}
					$cleanPostData[$k]=$v;
				}
				if(!empty($cleanPostData))
				{
					$requestData = json_encode($cleanPostData,JSON_FORCE_OBJECT);	
				}
				else
				{	
					$requestData = 'No Request Data';
				}
                                $this->instance->session->unset_userdata('lbackend_data');
				break;
			case 'PUT':
				parse_str(file_get_contents("php://input"),$input_array);
				$requestData = json_encode($input_array,JSON_FORCE_OBJECT);
				break;
			case 'DELETE':
				parse_str(file_get_contents("php://input"),$input_array);
				$requestData = json_encode($input_array,JSON_FORCE_OBJECT);
				break;
			default:
				$logState = FALSE;
				break;
		}
		if($logState)
		{
			//$logActivity = $this->requestMethod;
                        $logActivity="";
			$customLogActivity = $this->instance->session->userdata('lbackend_activity');
			if(!is_null($customLogActivity))
			{
				//$logActivity .= ' : '.$customLogActivity;
                                $logActivity .=$customLogActivity;
				$this->instance->session->unset_userdata('lbackend_activity');
			}
			$userId = $this->instance->session->userdata('Username');
                        $userIdEnd= substr(md5($userId),1,5);
			if(is_null($userId))
			{
				$userId = 0;
			}
                        $URL_SOURCE=$this->instance->session->userdata('lbackend_uri');
                        if(is_null($URL_SOURCE)){
                            $URL_SOURCE=current_url();
                        }
                        $this->instance->session->unset_userdata('lbackend_uri');
			$logData = array(
				'ID'=>$userIdEnd.date('ymdHis').  rand(1000, 9999),
				'USER_ID'=>$userId,
				'ACTIVITY'=>$logActivity,
				'URL_SOURCE'=>$URL_SOURCE,
				'REQUEST_DATA'=>$requestData,
				'IP_ADDRESS'=>$this->instance->input->ip_address(),
				'LOG_DATE'=>date('Y-m-d H:i:s')
			);
//                        echo "hook";
//                        die();
			$this->instance->db->insert('users_activity',$logData);
		}
	}
        
        function run_acitivity($logActivity,$data_code='',$new_data=array(),$old_data=array())
	{
		//log user activity
		$logState = $this->instance->session->userdata('doNotLog');
		if(is_null($logState))
		{
			$logState = TRUE;
		}
		else
		{
			$logState = FALSE;
			$this->instance->session->unset_userdata('doNotLog');
		}
		switch ($this->requestMethod) {
			case 'GET':
				$getData = $this->instance->input->get();
				$cleanGetData = array();
				foreach($getData as $k=>$v)
				{
					if(strripos($k, 'pass') !== FALSE)
					{
						$v = 'No Peeping Password !';
					}
					$cleanGetData[$k]=$v;
				}
				if(!empty($cleanGetData))
				{
					$requestData = json_encode($cleanGetData,JSON_FORCE_OBJECT);
				}
				else
				{
                                    
					$requestData = 'No Request Data';
				}
                                $requestDataGet=$requestData;
				break;
			case 'POST':
				$postData = $this->instance->input->post();
				$cleanPostData = array();
				foreach($postData as $k=>$v)
				{
					if(strripos($k, 'pass') !== FALSE)
					{
						$v = 'No Peeping Password !';
					}
					$cleanPostData[$k]=$v;
				}
				if(!empty($cleanPostData))
				{
					$requestData = json_encode($cleanPostData,JSON_FORCE_OBJECT);	
				}
				else
				{	
					$requestData = 'No Request Data';
				}
                                $requestDataPost=$requestData;
				break;
			case 'PUT':
				parse_str(file_get_contents("php://input"),$input_array);
				$requestData = json_encode($input_array,JSON_FORCE_OBJECT);
				break;
			case 'DELETE':
				parse_str(file_get_contents("php://input"),$input_array);
				$requestData = json_encode($input_array,JSON_FORCE_OBJECT);
				break;
			default:
				$logState = FALSE;
				break;
		}
		if($logState)
		{
			$userId = $this->instance->session->userdata('user_id');
                        $userIdEnd= substr(md5($userId),1,5);
			if(is_null($userId))
			{
				$userId = 0;
			}
                        $data = array(
                            'module' => $CI->uri->segment(1)."/".$CI->uri->segment(2),
                            'url' => current_url(),
                            'identity_user' => $this->instance->session->userdata('identity'),// pilihan dari akses user (email atau username)
                            'data_code' => $data_code,
                            'old_data' => $old_data,
                            'raw_user' => $new_data,
                            'raw_post' => $requestDataPost,
                            'raw_get' => $requestDataGet
                        );
			$logData = array(
				'ID'=>$userIdEnd.date('ymdHis').  rand(1000, 9999),
				'USER_ID'=>$userId,
				'ACTIVITY'=>$logActivity,
				'URL_SOURCE'=>current_url(),
				'REQUEST_DATA'=>$requestData,
				'IP_ADDRESS'=>$this->instance->input->ip_address(),
				'LOG_DATE'=>date('Y-m-d H:i:s'),
				'DATA'=>json_encode($data)
			);
//                        echo "hook";
//                        die();
			$this->instance->db->insert('users_activity',$logData);
		}
	}
}
