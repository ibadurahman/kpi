<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Encryption extends CI_Encryption
{
    function Random_data($Encrypt=TRUE){
        if($Encrypt==TRUE){
            $return=hash('sha512',uniqid(mt_rand(1, mt_getrandmax()), true));
        }else if($Encrypt==FALSE){
            $return=uniqid(mt_rand(1, mt_getrandmax()), true);
        }
        return $return;
    }
    /** Encrypt data yang tidak dapat di decrypt
    *
    * @return string
    */
    function EncryptData($str='',$salt='',$addSalt=''){
        if($salt==''){
            $salt2=  Random_data();
        }else{
            $salt2=$salt;
        }
        $return=hash('sha512',$str .$salt2.$addSalt);
        return $return;
    }
    /**
    * Encrypt data yang dapat di decrypt
    *
    * @return string
    */
    function EncryptData2Layers($str,$passphrase){
        $Encrypt1Layers=cryptoJsAesEncrypt($passphrase, $str);
        $Encrypt2Layers=$this->encrypt($Encrypt1Layers);
        return $Encrypt2Layers;
    }
    /** Decrypt data untuk function EncryptData2Layers
    *
    * @return string
    */
    function DecryptData2Layers($str,$passphrase){
        $Decrypt2Layers=$this->decrypt($str);
        $Decrypt1Layers=cryptoJsAesDecrypt($passphrase, $Decrypt2Layers);
        return $Decrypt1Layers;
    }

    /**
    * Decrypt data from a CryptoJS json encoding string
    *
    * @param mixed $passphrase
    * @param mixed $jsonString
    * @return mixed
    */
    function cryptoJsAesDecrypt($passphrase, $jsonString){
        $jsondata = json_decode($jsonString, true);
        $salt = hex2bin($jsondata["s"]);
        $ct = base64_decode($jsondata["ct"]);
        $iv  = hex2bin($jsondata["iv"]);
        $concatedPassphrase = $passphrase.$salt;
        $md5 = array();
        $md5[0] = md5($concatedPassphrase, true);
        $result = $md5[0];
        for ($i = 1; $i < 3; $i++) {
            $md5[$i] = md5($md5[$i - 1].$concatedPassphrase, true);
            $result .= $md5[$i];
        }
        $key = substr($result, 0, 32);
        $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
        return json_decode($data, true);
    }
    /**
    * Encrypt value to a cryptojs compatiable json encoding string
    *
    * @param mixed $passphrase
    * @param mixed $value
    * @return string
    */
    function cryptoJsAesEncrypt($passphrase, $value){
        $salt = openssl_random_pseudo_bytes(8);
        $salted = '';
        $dx = '';
        while (strlen($salted) < 48) {
            $dx = md5($dx.$passphrase.$salt, true);
            $salted .= $dx;
        }
        $key = substr($salted, 0, 32);
        $iv  = substr($salted, 32,16);
        $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
        $data = array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt));
        return json_encode($data);
    }

}