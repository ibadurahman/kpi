<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Lang extends MX_Lang {

    var $existing_langs = array();
    var $lang_path ;
    var $CI;

    function __construct(){
        parent::__construct();
        $this->lang_path = APPPATH . 'language';
        $this->existing_langs = $this->find();
    }
    
    function find($alt_path = '') {
        $results = scandir(($alt_path != '') ? $alt_path : $this->lang_path);
        
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            
            //if (is_dir(BASEPATH.'language' . '/' . $result)) {
            // diganti APPPATH karena bila menggunakan BASEPATH membaca folder lang yg ada di folder system
            if (is_dir(APPPATH.'language' . '/' . $result)) {
                $dirs[] = $result;
            }
        }
        return $dirs;
    }

    public function remove_line($line, $file, $lang = ''){

        $CI =& get_instance();
        $CI->load->helper('file');

        if($lang == ''){ //Apply to all languages

            foreach($this->existing_langs as $lang){

                $file_path = $this->lang_path.'/'.$lang.'/'.$file.'_lang.php';
                if(!file_exists($file_path)){

                    $file_path = BASEPATH.'language/'.$lang.'/'.$file.'_lang.php';
                    if(!file_exists($file_path)){

                        show_error("Could not find the requested language file.");

                    }

                }

                $lang_contents = read_file($file_path);

                $new_contents = preg_replace("^\n\\$"."lang\['$line'\] = '(.*?)';^", '', $lang_contents);

                write_file($file_path, $new_contents, 'w+');

            }

        } else { //Apply only to specified language

            $file_path = $this->lang_path.'/'.$lang.'/'.$file.'_lang.php';
            if(!file_exists($file_path)){

                $file_path = BASEPATH.'language/'.$lang.'/'.$file.'_lang.php';
                if(!file_exists($file_path)){

                    show_error("Could not find the requested language file.");

                }

            }

            $lang_contents = read_file($file_path);

            $new_contents = preg_replace("^\n\\$"."lang\['$line'\] = '(.*?)';^", '', $lang_contents);

            write_file($file_path, $new_contents, 'w+');

        }

    }

    public function add_line($line, $value, $file, $lang = ''){

        $CI =& get_instance();
        $CI->load->helper('file');

        if($lang == ''){ //Apply to all languages
           
            foreach($this->existing_langs as $lang){

                $file_path = $this->lang_path.'/'.$lang.'/'.$file.'_lang.php';
                if(!file_exists($file_path)){

                    $file_path = BASEPATH.'language/'.$lang.'/'.$file.'_lang.php';
                    if(!file_exists($file_path)){

                        show_error("Could not find the requested language file.");

                    }

                }

                $lang_contents = read_file($file_path);

                $new_contents = $lang_contents."\n".'$lang'."['".$line."'] = '".$value."';";

                write_file($file_path, $new_contents, 'w+');

            }

        } else { //Apply only to specified languages


            $file_path = $this->lang_path.'/'.$lang.'/'.$file.'_lang.php';
            if(!file_exists($file_path)){

                $file_path = BASEPATH.'language/'.$lang.'/'.$file.'_lang.php';
                if(!file_exists($file_path)){

                    show_error($file_path);

                }

            }

            $lang_contents = read_file($file_path);

            $new_contents = $lang_contents."\n".'$lang'."['".$line."'] = '".$value."';";

            write_file($file_path, $new_contents, 'w+');

        }

    }

    public function change_line($line, $value, $file, $lang = ''){

        $CI =& get_instance();
        $CI->load->helper('file');

        if($lang == ''){ //Apply to all languages

            foreach($this->existing_langs as $lang){

                $file_path = $this->lang_path.'/'.$lang.'/'.$file.'_lang.php';
                if(!file_exists($file_path)){

                    $file_path = BASEPATH.'language/'.$lang.'/'.$file.'_lang.php';
                    if(!file_exists($file_path)){

                        show_error("Could not find the requested language file.");

                    }

                }
                $lang_contents = read_file($file_path);
                $new_contents = preg_replace("^\\$"."lang\['$line'\] = '(.*?)';^", '$lang'."['".$line."'] = '$value';", $lang_contents);

                write_file($file_path, $new_contents, 'w+');
            }

        } else {

            $file_path = $this->lang_path.'/'.$lang.'/'.$file.'_lang.php';
            if(!file_exists($file_path)){

                $file_path = BASEPATH.'language/'.$lang.'/'.$file.'_lang.php';
                if(!file_exists($file_path)){

                    show_error("Could not find the requested language file.");

                }

            }
            $lang_contents = read_file($file_path);
            $new_contents = preg_replace("^\\$"."lang\['$line'\] = '(.*?)';^", '$lang'."['".$line."'] = '$value';", $lang_contents);

            write_file($file_path, $new_contents, 'w+');

        }

    }
}