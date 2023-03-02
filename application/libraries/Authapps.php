<?php

class Authapps{
    var $CI = NULL;
    function __construct()
    {
       // get CI's object
       $this->CI =& get_instance();
    }
    /*
     *  function untuk membuat auth user bila login di mobile apps
     * 
     * param Username       Username saat login
     * param PasswordDB     Password yang di simpan dalam Database
     * param Key            key API yang di berikan kepada pengguna
     * param LoginAllDevice Status apakah user bisa login di semua device atau harus close disalah satunya. bila TRUE maka bisa login di semua device, FALSE harus login di salah satu device.
     */
    public function generate_user_auth($Username,$PasswordDB,$Key,$LoginAlldevice=TRUE)
    {
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        $EncriptPass=  md5($this->CI->encryption->EncryptData($PasswordDB, $Key));
        if($LoginAlldevice==TRUE)
        {
            // kode auth tidak random setiap login
            $KodeAuth=  $EncriptPass.$Username.$Key;
            $UserAuth= base64_encode($KodeAuth);
        }else{
            // kode auth random setiap login
            $KodeAuth=  rand(100, 999).$EncriptPass.$Username.$Key.date('Ymdhis');
            $UserAuth= base64_encode($KodeAuth);
        }
        return $UserAuth;
    }
    /*
     *  function untuk mengecek apakah user authentication benar
     * 
     * param Token  Token yang sudah di generate sebelumnya
     * param Key    key API yang di berikan kepada pengguna
     */
    public function verify_user_auth($Token,$Key)
    {
        
        $this->CI->load->model('api/apps_model');
        $DataUser= $this->CI->token->decode_token_jwt($Token, $Key);
//        var_dump($DataUser);
//        die();
        if(isset($DataUser->status_token))
        {
            //cek status true or false
            if($DataUser->status_token == TRUE)
            {
                //echo $DataUser->username."---".$DataUser->user_auth;
                // cek user auth
                if($this->CI->apps_model->verify_auth($DataUser->identity,$DataUser->user_auth))
                {
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
            }
            else
            {
                //kembalikan nilai false
                return FALSE;
            }
        }
        else 
        {
            //kembalikan nilai false
            return FALSE;
        }
        
    }
    
    /*
     *  function untuk mengecek apakah key yang di input benar
     * 
     * param Key    key API yang di berikan kepada pengguna
     */
    public function verify_api_key($Key)
    {   
        $this->CI->load->model('api/api_key_model');
        $DataKey = $this->CI->api_key_model->get_api_key_Key($Key);
        if($DataKey->num_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    /*
     *  function untuk mengecek apakah user authentication benar
     * 
     * param Token  Token yang sudah di generate sebelumnya
     * param Key    key API yang di berikan kepada pengguna
     */
    public function get_user_login($Token,$Key)
    {
        
        $DataUser= $this->CI->token->decode_token_jwt($Token, $Key);
        return $DataUser;
        
    }
}
