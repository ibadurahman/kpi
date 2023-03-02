<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Siswa extends CI_Controller{
 
  function index()
  {
    // untuk menampilkan view dengan nama view_siswa
    $this->load->view('view_siswa');
  }
 
  function data_guru()
  {
    $this->load->view('view_guru');
  }
 
}