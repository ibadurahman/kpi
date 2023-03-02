<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
    


    jQuery(document).ready(function() {

    $("#result").hide();
    $("#result_sukses").hide();
    $("#result_gagal").hide();
    $("#form_input").submit(function(e){
           e.preventDefault();
           
           var me = $(this);
           var stat=$("#StatusSave").val();
           var data = new FormData(me[0]);
           $.ajax({
               url: me.attr("action"),
                enctype: 'multipart/form-data',
               type: 'post',
               data: data,
                processData: false,
                contentType: false,
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
                    if(response.success == true && response.status == true){
                       //setelah sukses halaman d scroll ke top
                        //$(window).scrollTop(0);
                        
                            //window.location = '<?php //echo site_url('organisasi/PegawaiImport');?>';
                        $("#result").show();
                        $("#result_sukses").show();
                        $("#result_gagal").hide();
                        $("#list_error").html('');
                        $("#file").val('');
                            var element = $("#file");
                        element.closest('div.form-group')
                                    .removeClass('has-danger')
                                    .find(".text-error")
                                    .remove();
                            element.closest('div.form-group')
                                    .find(".error")
                                    .html('');
                        window.location.hash = '#result';
                    }else if(response.success == true && response.status == false){
                        $("#result").show();
                        $("#result_sukses").hide();
                        $("#result_gagal").show();
                        $("#list_error").html(response.data_upload);
                        $("#file").val('');
                            var element = $("#file");
                        element.closest('div.form-group')
                                    .removeClass('has-danger')
                                    .find(".text-error")
                                    .remove();
                            element.closest('div.form-group')
                                    .find(".error")
                                    .html('');
                        window.location.hash = '#result';
                    }
                    else{
                        $(window).scrollTop(0);
                        $("#file").val('');
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
               },
               error: function(xhr, status, error) {
                        $("#file").val('');
                    mApp.unblockPage();
                    var err = JSON.parse(xhr.responseText);
                    alert(err.Message);
                }
           });
        });
    
    
});
</script>