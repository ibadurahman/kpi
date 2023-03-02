<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<style type="text/css">
    /*general styles*/
    .printable{
        visibility:hidden;
    }
    /* print styles*/
    @media print { 
        .printable {
            position:absolute;
            left:0;
            top:0;
        } 
        .printable, .printable * {
            visibility:visible;
        }
        body * {
        visibility:hidden;
        }
    }
</style>
