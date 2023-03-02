<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
    


    jQuery(document).ready(function() {

    $('#button_delete').on('click', function(){
//            $('#menu').val('tes');
            var Id = $(this).attr("data-id");
            var Id2 = $(this).attr("data-id2");
            var UriDelete= "<?php echo site_url('organisasi/Pegawai/pegawai_kpi_delete/')?>"+Id2;
            var DelMessage= "<?php echo $this->lang->line('sukses_delete');?>";
            var UriRedirect= "<?php echo site_url('organisasi/Pegawai/view_form/')?>"+Id;
            var Title= "<?php echo $this->lang->line('title_delete');?>";
            var TextMessage= "<?php echo $this->lang->line('konfirmasi_delete');?>";
            
            deleteData(Id,UriDelete,DelMessage,UriRedirect,Title,TextMessage);
            
       });
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
           var data = new FormData(me[0]);
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
                        if(stat==1){
                            window.location = '<?php echo site_url('organisasi/Pegawai');?>';
                        }else{
                            window.location = '<?php echo site_url('organisasi/Pegawai/insert_form');?>';
                        }
                        
                   }
                   else{
                       $(window).scrollTop(0);
                       $.each(response.messages, function(key, value){
                           var element = $("#" + key);
                           //alert(key);
                           element.closest('div.isi_input')
                                   .removeClass('has-danger')
                                   .addClass(value.length>0 ?'has-danger':'')
                                   .find(".text-error")
                                   .remove();
                           //element.after(value);
                           element.closest('div.isi_input')
                                   .find(".error")
                                   .html(value);
                       });
                   }
               }
           });
        });
});
</script>