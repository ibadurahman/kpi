<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
    


    jQuery(document).ready(function() {

         
        $('#m_table_1').on('click', '.delete-data', function(){
//            $('#menu').val('tes');
            var Id = $(this).attr("data-id");
            var UriDelete= "<?php echo site_url('organisasi/Level/delete')?>";
            var DelMessage= "<?php echo $this->lang->line('sukses_delete');?>";
            var UriRedirect= "<?php echo site_url('organisasi/Level/Index')?>";
            var Title= "<?php echo $this->lang->line('title_delete');?>";
            var TextMessage= "<?php echo $this->lang->line('konfirmasi_delete');?>";
            
            deleteData(Id,UriDelete,DelMessage,UriRedirect,Title,TextMessage);
            
       });
 
            
    $("#m_table_1").DataTable({
	"iDisplayLength": 50,
    "scrollX": true,
	"order": [[ 0, "asc" ]],
	"processing": true,
	"serverSide": true,
	// "bAutoWidth": false,
	"stateSave": false,
	"pagingType": "full_numbers",
	"language": {
            "infoFiltered": "",
            "paginate": {
              "previous": "<",
              "next": ">"
            }
	}, columnDefs:[ {
                targets:4, width:"80px"
            }
            
            ],
	"ajax": {
	        url: "<?php echo site_url('organisasi/Level/get_list')?>",
	        error: function (xhr, error, thrown) {
	       		alert("Cannot view log. Error database connection.");
	        }
	    }
							    
    });
    $("#input_modal").on("shown.bs.modal", function() {
            $("#kd_menu").select2( {
                placeholder: "Select an option",
                allowClear: true
            }
            )
        }
    );
    $("#form_input").submit(function(e){
           e.preventDefault();
           
           var me = $(this);
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
                    mApp.block("#input_modal .modal-content", {
                        overlayColor: "#000000",
                        type: "loader",
                        state: "primary",
                        message: "Processing..."
                    })
                },
               success: function(response){
                   //hide spinner atau loading
                   mApp.unblock("#input_modal .modal-content");
                   if(response.success == true){
                       //setelah sukses halaman d scroll ke top
                        //$(window).scrollTop(0);
                        
                        window.location = '<?php echo site_url('organisasi/Level');?>';
                   }
                   else{
                       $(window).scrollTop(0);
                       $.each(response.messages, function(key, value){
                           var element = $("#" + key);
                           element.closest('div.form-group')
                                   .removeClass('has-danger')
                                   .addClass(value.length>0 ?'has-danger':'')
                                   .find(".text-error")
                                   .remove();
                           element.after(value);
                       });
                   }
               }
           });
        });
    
    //memunculkan modal apabila tombol new di tekan
    $('#button_add').on('click', function(){
            //alert('tes');
            var dataURL = "<?php echo site_url('organisasi/Level/insert_form')?>";
            var action = "<?php echo site_url('organisasi/Level/save')?>";
            $("#form_header").html("<?php echo $this->lang->line('input_header');?>");
            $("#form_input").attr("action", action);
            $("#form_input").addClass('m-form m-form--state');
            $("#tombol_submit").show();
            $("#tombol_edit").hide();
            $('.modal-body').load(dataURL,function(){
                $("#kd_menu").select2( {
                    placeholder: "Select an option",
                    allowClear: true
                }
                );
                $('#input_modal').modal({show:true});
            });
        });  
    
    //memunculkan modal apabila tombol view di tekan
    $('#m_table_1').on('click', '.openPopupView', function(){
            var dataId = $(this).attr('data-id');
            var dataURL = "<?php echo site_url('organisasi/Level/view_form/')?>"+dataId;
            $("#form_header").html("<?php echo $this->lang->line('view_header');?>");
            $("#form_input").attr("action", dataURL);
            $("#tombol_edit").attr("data-id", dataId);
            $("#form_input").removeClass('m-form m-form--state');
            $("#tombol_submit").hide();
            <?php 
            if($this->mion_auth->is_allowed('edit_level')) 
            {
            ?>
            $("#tombol_edit").show();
            <?php } ?>
            $('.modal-body').load(dataURL,function(){
                $('#input_modal').modal({show:true});
            });
        });  
    
    //memunculkan modal apabila tombol edit di tekan
    $('#m_table_1').on('click', '.openPopupEdit', function(){
            var dataId = $(this).attr('data-id');
            var dataURL = "<?php echo site_url('organisasi/Level/edit_form/')?>"+dataId;
            var action = "<?php echo site_url('organisasi/Level/edit/')?>"+dataId;
            $("#form_header").html("<?php echo $this->lang->line('edit_header');?>");
            $("#form_input").attr("action", action);
            $("#form_input").addClass('m-form m-form--state');
            $("#tombol_submit").show();
            $("#tombol_edit").hide();
            $('.modal-body').load(dataURL,function(){
                $("#kd_menu").select2( {
                    placeholder: "Select an option",
                    allowClear: true
                }
                );
                $('#input_modal').modal({show:true});
            });
        });
    
    $('#tombol_edit').on('click', function(){
            var dataId = $(this).attr('data-id');
            var dataURL = "<?php echo site_url('organisasi/Level/edit_form/')?>"+dataId;
            var action = "<?php echo site_url('organisasi/Level/edit/')?>"+dataId;
            $("#form_header").html("<?php echo $this->lang->line('edit_header');?>");
            $("#form_input").attr("action", action);
            $("#form_input").addClass('m-form m-form--state');
            $("#tombol_submit").show();
            $("#tombol_edit").hide();
            $('.modal-body').load(dataURL,function(){
                $("#kd_menu").select2( {
                    placeholder: "Select an option",
                    allowClear: true
                }
                );
                $('#input_modal').modal({show:true});
            });
        });
    
    
});
</script>