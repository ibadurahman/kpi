<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_key_model extends CI_Model{
    protected $id;
    protected $key;
    protected $pengguna;
    protected $tgl_input;
    protected $DataDatabase;
    
    public function get_id() {
        return $this->id;
    }

    public function get_key() {
        return $this->key;
    }
    
    public function get_pengguna() {
        return $this->pengguna;
    }
    function get_tgl_input() {
        return $this->tgl_input;
    }

    function set_tgl_input($tgl_input) {
        if($tgl_input ==""){
            $tgl_input=date("Y-m-d H:i:s");
        }else{
            $tgl_input = convert_datetime($tgl_input);
        }
        $this->tgl_input = $tgl_input;
        $this->DataDatabase['tgl_input']=$this->tgl_input;
        
        return $this;
    
    }

    public function set_id($id) {
        if($id ==""){
            $id=NULL;
        }
        $this->id = $id;
        $this->DataDatabase['id']=$id;
        
        return $this;
    }

    public function set_key($key) {
        if($key ==""){
            $key=NULL;
        }
        $this->key = $key;
        $this->DataDatabase['key']=$key;
        
        return $this;
    }
    
    public function set_pengguna($pengguna) {
        if($pengguna ==""){
            $pengguna=NULL;
        }
        $this->pengguna = $pengguna;
        $this->DataDatabase['pengguna']=$pengguna;
        
        return $this;
    }

    public function resetVariabelDatabase(){
        $this->DataDatabase=NULL;
        return $this;
    }

    public function get_All_api_key($DataSearch=NULL,$Limit=NULL,$Offset=NULL){
        //$this->auth->akses_api_key();
        $this->searching->SetSerching($DataSearch);
        $query= $this->db->get('api_key',$Limit, $Offset);
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_Search_api_key($ParamSearch=''){
       
        $this->db->select("api_key.*");
        $this->db->from('api_key');
        if($ParamSearch!=""){
            $this->db->like('api_key.id',$ParamSearch);
            $this->db->or_like('api_key.key',$ParamSearch);
            $this->db->or_like('api_key.pengguna',$ParamSearch);
        }
        
        return $this->db->get();
    }
    public function insert_api_key(){
       $this->db->insert('api_key',$this->DataDatabase);
       return $this->db->affected_rows();
    }
    public function update_api_key($Field,$Value){
        $this->db->where($Field,$Value);
        $this->db->update('api_key',$this->DataDatabase);
       return $this->db->affected_rows();
//       $sql = $this->db->set($Data)->get_compiled_update('tipe_perusahaan');
//        echo $sql."---".$KodeTipePerusahaan;
//        die();
    }
    public function delete_api_key($Field,$Value){
       $this->db->where($Field,$Value);
       $this->db->delete('api_key');
       return $this->db->affected_rows();
    }
    public function search_list_data_api_key($ColumnOrder,$ColumnSearch){
       
        $this->searching->setColumnOrder($ColumnOrder);
        $this->searching->setColumnSearch($ColumnSearch);
        $this->db = $this->searching->generate();
        //$this->db = $this->searching->tes();
        return $this->get_All_api_key();
    }
    public function count_all_api_key($ColumnOrder,$ColumnSearch)
    {
        $this->searching->setColumnOrder($ColumnOrder);
        $this->searching->setColumnSearch($ColumnSearch);
        $this->searching->generate_nonpage();
        $this->select_All_api_key();
        return $this->db->count_all_results();
    }
    public function get_api_key_Id($Kode){
        return $this->db->get_where('api_key',['id'=>$Kode]);
    }
    public function get_api_key_Key($Key){
        return $this->db->get_where('api_key',['key'=>$Key]);
    }
}