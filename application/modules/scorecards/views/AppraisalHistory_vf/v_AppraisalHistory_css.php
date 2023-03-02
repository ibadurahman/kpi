<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<style type="text/css">
    @media screen {
        #printSection {
            display: none;
        }
      }

      @media print {
        body * {
          visibility:hidden;
        }
        #printSection, #printSection * {
          visibility:visible;
        }
        #printSection {
          position:absolute;
          left:0;
          top:0;
        }
      }
      
      @page {
          size:A4; 
/*        size: 59.4cm 84.1cm;*/
        margin: 5mm 5mm 5mm 5mm; /* change the margins as you want them to be. */
    }

</style>
