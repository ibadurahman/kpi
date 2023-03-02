<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
    
jQuery(document).ready(function() {

        
   $(".data_hide").hide();
   $(".data_hide_pegawai").hide();
   var tipe=$('#report_type').val();
   if(tipe==1){
            $(".data_hide").show();
            $(".data_hide_pegawai").show();
        }else if(tipe==3){
            $(".data_hide").show();
            $(".data_hide_pegawai").hide();
        }else{
            $(".data_hide").hide();
            $(".data_hide_pegawai").hide();
        }
        
    $('#report_type').on('change', function(){
        var val=$(this).val();
        if(val==1){
            $(".data_hide").show();
            $(".data_hide_pegawai").show();
        }else if(val==3){
            $(".data_hide").show();
            $(".data_hide_pegawai").hide();
        }else{
            $(".data_hide").hide();
            $(".data_hide_pegawai").hide();
        }
    });
    $(".select2-ajax").select2({
                placeholder: "select an option",
                allowClear: true,
                ajax: {
                  url: "<?php echo site_url('report/ReportMeasurement/SearchAutocompletePegawai');?>",
                  dataType: 'json',
                  type: 'GET',
                  delay: 250,
                  data: function (params) {
                    return {
                      term: params.term, // search term
                      //page: params.page
                    };
                  },
                  processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.nama+" - "+item.nip,
                                    id: item.nip
                                }
                            })
                        };
                    },        
                  cache: true
                },
                minimumInputLength: 2,
                minimumResultsForSearch: 10
              });
});
</script>