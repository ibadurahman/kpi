<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GenerateMigration extends CI_Controller
{

        public function index()
        {
                $this->load->library('migration_lib');

                if ($this->migration_lib->generate() === FALSE)
                {
                        echo "Generate Unsuccess";
                }else{
                    echo "Generate Success";
                }
        }

}
