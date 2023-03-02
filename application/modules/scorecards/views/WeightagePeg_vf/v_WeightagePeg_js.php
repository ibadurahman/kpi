<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
    


    jQuery(document).ready(function() {
        $('.tombol-save').on('click', function(){
            $("#StatusSave").val(1);
            $("#form_input2").submit();
        });
        $(".datepicker_custom").datetimepicker( {
            format: 'dd-mm-yyyy',
                todayHighlight: !0, autoclose: !0, startView: 2, minView: 2, forceParse: 0, pickerPosition: "bottom-left"
        }); 
        $('#m_table_1').on('click', '.delete-data', function(){
//            $('#menu').val('tes');
            var Id = $(this).attr("data-id");
            var UriDelete= "<?php echo site_url('scorecards/WeightagePeg/weightage_peg_delete')?>";
            var DelMessage= "<?php echo $this->lang->line('sukses_delete');?>";
            var UriRedirect= "<?php echo site_url('scorecards/WeightagePeg/Index')?>";
            var Title= "<?php echo $this->lang->line('title_delete');?>";
            var TextMessage= "<?php echo $this->lang->line('konfirmasi_delete');?>";
            
            deleteData(Id,UriDelete,DelMessage,UriRedirect,Title,TextMessage);
            
       });
 
    $("#m_table_1").DataTable({
	"iDisplayLength": 50,
	"order": [[ 0, "asc" ]],
	"processing": true,
	"serverSide": true,
	"bAutoWidth": false,
	"stateSave": false,
	"pagingType": "full_numbers",
	"language": {
            "infoFiltered": "",
            "paginate": {
              "previous": "<",
              "next": ">"
            }
	}, columnDefs:[ {
                targets:6, visible: false
            },{
                targets:7, width:"80px"
            }
            
            ],
	"ajax": {
	        url: "<?php echo site_url('scorecards/WeightagePeg/get_list')?>",
	        error: function (xhr, error, thrown) {
	       		alert("Cannot view log. Error database connection.");
	        }
	    }
							    
    });        
   
    $('.tombol-save').on('click', function(){
        $("#StatusSave").val(1);
        $("#form_input").submit();
    });
    $('.tombol-save2').on('click', function(){
        $("#StatusSave").val(2);
        $("#form_input").submit();
    });
    $('#tgl_keluar').on('change', function(){
        var tgl=$('#tgl_keluar').val();
        if(tgl!=""){
            $("#status2").prop("checked", true);
        }else{
            $("#status").prop("checked", true);
        }
    });
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
                   if(response.success == true){
                       //setelah sukses halaman d scroll ke top
                        //$(window).scrollTop(0);
                        if(stat==1){
                            if(response.status=='edit'){
                                window.location = '<?php echo site_url('scorecards/WeightagePeg/view_form/');?>'+response.nip;
                            }else{
                                window.location = '<?php echo site_url('scorecards/WeightagePeg');?>';
                            }
                            
                        }else{
                            window.location = '<?php echo site_url('scorecards/WeightagePeg/insert_form');?>';
                        }
                        
                   }
                   else{
                       $(window).scrollTop(0);
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
        $("#form_input2").submit(function(e){
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
                   if(response.success == true){
                       //setelah sukses halaman d scroll ke top
                        //$(window).scrollTop(0);
                        if(stat==1){
                            window.location = '<?php echo site_url('scorecards/WeightagePeg/');?>'+response.link;
                            
                            
                        }else{
                            window.location = '<?php echo site_url('scorecards/WeightagePeg/insert_form');?>';
                        }
                        
                   }
                   else{
                       $(window).scrollTop(0);
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
        $('.button_view_target').on('click', function(){
            var dataId = $(this).attr('data-id');
            var dataId2 = $(this).attr('data-id2');
            var dataURL = "<?php echo site_url('scorecards/WeightagePeg/target_view_form/')?>"+dataId+"/"+dataId2
            $("#form_header").html("<?php echo $this->lang->line('header_target_title');?>");
            $("#form_input_modal").attr("action", dataURL);
            $("#tombol_edit").attr("data-id", dataId);
            $("#tombol_edit").attr("data-id2", dataId2);
            $("#form_input_modal").addClass('m-form m-form--state');
            $("#tombol_submit").hide();
            $("#tombol_edit").show();
            $('.modal-body').load(dataURL,function(){
                $('#input_modal').modal({show:true});
            });
        });
        $('#tombol_edit').on('click', function(){
            var dataId = $(this).attr('data-id');
            var dataId2 = $(this).attr('data-id2');
            var dataURL = "<?php echo site_url('scorecards/WeightagePeg/target_edit_form/')?>"+dataId+"/"+dataId2
            var action = "<?php echo site_url('scorecards/WeightagePeg/target_edit/')?>"+dataId;
            $("#form_header").html("<?php echo $this->lang->line('header_target_title');?>");
            $("#form_input_modal").attr("action", action);
            $("#form_input").addClass('m-form m-form--state');
            $("#tombol_submit").show();
            $("#tombol_edit").hide();
            $('.modal-body').load(dataURL,function(){
                $('#input_modal').modal({show:true});
            });
        });
        $("#form_input_modal").submit(function(e){
           e.preventDefault();
           
           var me = $(this);
           $.ajax({
               url: me.attr("action"),
               type: 'post',
               data: me.serialize(),
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
                            if('kode' in response){
                                window.location = '<?php echo site_url('scorecards/WeightagePeg/view_form/');?>'+response.kode;
                            }else{
                                window.location = '<?php echo site_url('scorecards/WeightagePeg');?>';
                            }
                   }
                   else{
                       $(window).scrollTop(0);
                       $.each(response.messages, function(key, value){
                           var element = $("#" + key);
                           //alert(key);
                           if(key == 'error_total_bobot' || key == 'weightage' || key == 'kd_perspective')
                           {
                                var DataAlert='<div class="alert alert-danger alert-dismissible fade show" role="alert">\n\
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>'+value+'</div>';
                                
                                $("#alert_error_section").html(DataAlert);
                           }
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
});
</script>