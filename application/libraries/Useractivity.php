<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Useractivity {

	public $instance;

	public $requestMethod;

	public function __construct() {
		global $instance,$request_method;
		$this->instance = &get_instance();
		$this->requestMethod = $this->instance->input->server('REQUEST_METHOD');
	}

        
        function run_acitivity($logActivity,$data_code='',$new_data=array(),$old_data=array())
	{
            $requestDataGet="";
            $requestDataPost="";
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
                            'module' => $this->instance->uri->segment(1)."/".$this->instance->uri->segment(2),
                            'url' => current_url(),
                            'identity_user' => $this->instance->session->userdata('identity'),// pilihan dari akses user (email atau username)
                            'data_code' => $data_code,
                            'old_data' => $old_data,
                            'new_data' => $new_data,
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
				'LOG_DATE'=>strtotime(date('Y-m-d H:i:s')),
				'DATA'=>json_encode($data)
			);
//                        echo "hook";
//                        die();
			$this->instance->db->insert('users_activity',$logData);
		}
	}
}
