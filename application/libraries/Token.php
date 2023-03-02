<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Token library
 *
 * @author  Anggy Trisnawan
 */
class Token{
   var $CI = NULL;
   function __construct()
   {
      // get CI's object
      $this->CI =& get_instance();
   }
   /*
     * function untuk merubah data menjadi token
     * 
     * param Data       Data Perupa array
     * param Key        key API yang di berikan kepada pengguna
     */
    public function generate_token_jwt($Data=array(), $Key='DSM01012020')
    {
        $this->CI->load->library('JWT');
        return  JWT::encode($Data, $Key);
         
    }
    
    /*
     * function untuk decode token menjadi data kembali
     * 
     * param $token     Token yang sudah di generate sebelumnya
     * param Key        key API yang di berikan kepada pengguna
     */
    public function decode_token_jwt($token, $Key)
    {
        $this->CI->load->library('JWT');
        try
        {
            $jwt = JWT::decode($token, $Key, array('HS256'));
//            $Data=(array)$jwt;
//            var_dump($jwt);
            return $jwt;
        }
        catch (Exception $e)
        {
//            http_response_code('401');
//            echo json_encode(array( "status" => false, "message" => $e->getMessage()));
            $msg=(object)["status_token" => false, "message" => $e->getMessage()];
//             var_dump($msg);
            return $msg;
//            exit;
        }
         
    }
}