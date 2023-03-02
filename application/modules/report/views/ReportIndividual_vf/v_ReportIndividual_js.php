<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
    
jQuery(document).ready(function() {
    $(".select2-ajax").select2({
                placeholder: "select an option",
                allowClear: true,
                ajax: {
                  url: "<?php echo site_url('report/ReportIndividual/SearchAutocompletePegawai');?>",
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
    $(".report_content").hide();
    $("#form_input").submit(function(e){
           e.preventDefault();
           
           var me = $(this);
           $.ajax({
               url: me.attr("action"),
               type: 'post',
               data: me.serialize(),
               dataType: 'json',
                beforeSend: function() {
                    //show spinner atau loading
                    mApp.blockPage({
                        overlayColor: "#000000",
                        type: "loader",
                        state: "primary",
                        message: "Processing..."
                    })
                },
               success: function(response){
                   //hide spinner atau loading
                   mApp.unblockPage();
                   if(response.success == true){
                       $(".report_content").show();
                       var dataURL = "<?php echo site_url('report/ReportIndividual/view_form/')?>"+response.data;
                        $('#isi').load(dataURL);
                        $('#button_print').attr('href','<?php echo site_url("report/ReportIndividual/cetak_kpi_pegawai_Pdf/"); ?>'+response.data);
                   }
                   else{
                       $(window).scrollTop(0);
                            $(".report_content").hide();
                       $.each(response.messages, function(key, value){
                           var element = $("#" + key);
                           //alert(key);
                           element.closest('div.form-group')
                                   .removeClass('has-danger')
                                   .addClass(value.length>0 ?'has-danger':'')
                                   .find(".text-error")
                                   .remove();
                           //element.after(value);
                           element.closest('div.form-group')
                                   .find(".error")
                                   .html(value);
                       });
                   }
               }
           });
        });
//        $("#button_print").on('click', function(){ 
//            //get the modal box content and load it into the printable div 
//            $(".printable").html(
//                    $(".data-print").html()
//             ); //fire the print method 
//            window.print();
//        });
});
</script>