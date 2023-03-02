<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
    


    jQuery(document).ready(function() {

         
        $('.delete-data').on('click', function(){
//            $('#menu').val('tes');
            var Id = $(this).attr("data-id");
//            alert(Id);
            var UriDelete= "<?php echo site_url('akses/UserRole/delete')?>";
            var DelMessage= "<?php echo $this->lang->line('sukses_delete');?>";
            var UriRedirect= "<?php echo site_url('akses/UserRole/Index')?>";
            var Title= "<?php echo $this->lang->line('title_delete');?>";
            var TextMessage= "<?php echo $this->lang->line('konfirmasi_delete');?>";
            
            deleteData(Id,UriDelete,DelMessage,UriRedirect,Title,TextMessage);
            
       });
 
    $("#input_modal").on("shown.bs.modal", function() {
            $("#kd_menu").select2( {
                placeholder: "Select an option",
                allowClear: true
            }
            )
        }
    );
    $('.tombol-save').on('click', function(){
        $("#StatusSave").val(1);
        $("#form_input").submit();
    });
    $('.tombol-save2').on('click', function(){
        $("#StatusSave").val(2);
        $("#form_input").submit();
    });
    $("#form_input").submit(function(e){
           e.preventDefault();
           
           var me = $(this);
           var stat=$("#StatusSave").val();
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
                       //setelah sukses halaman d scroll ke top
                        //$(window).scrollTop(0);
//                        alert("berhasil");
                        if(stat==1){
                            window.location = '<?php echo site_url('akses/UserRole');?>';
                        }else{
                            window.location = '<?php echo site_url('akses/UserRole/insert_form');?>';
                        }
                   }
                   else{
                       $(window).scrollTop(0);
                       $("#user_role_section").html('');
                       $.each(response.messages, function(key, value){
                           if(key=='permission')
                           {
                               var DataAlert='<div class="alert alert-danger alert-dismissible fade show" role="alert">\n\
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>'+value+'</div>';
                               //alert(DataAlert);
                               $("#user_role_section").html(DataAlert);
                           }
                           else
                           {
                                var element = $("#" + key);
                                element.closest('div.form-group')
                                        .removeClass('has-danger')
                                        .addClass(value.length>0 ?'has-danger':'')
                                        .find(".text-error")
                                        .remove();
                                element.after(value);
                            }
                       });
                   }
               }
           });
        });
    
    
    
});
</script>