<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
    


    jQuery(document).ready(function() {

         
        $('#m_table_1').on('click', '.data-approve', function(){
            var Id = $(this).attr("data-id");
            var UriApprove= "<?php echo site_url('scorecards/Appraisal/Proses_complete_form')?>";
            var UriRedirect= "<?php echo site_url('scorecards/Appraisal/Index')?>";
            approveData(Id,UriApprove,UriRedirect);
        //swal("Oops!", "Something went wrong on the page!", "error");
      });
      $('#m_table_1').on('click', '.delete-data', function(){
//            $('#menu').val('tes');
            var Id = $(this).attr("data-id");
            var UriDelete= "<?php echo site_url('scorecards/Appraisal/delete')?>";
            var DelMessage= "<?php echo $this->lang->line('sukses_delete');?>";
            var UriRedirect= "<?php echo site_url('scorecards/Appraisal/Index')?>";
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
                targets:4, width:"80px"
            },
            {
                targets:1, visible: false
            }
            
            ],
	"ajax": {
	        url: "<?php echo site_url('scorecards/Appraisal/get_list/'.$DataTahun.'/'.$DataBulan)?>",
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
                        
                        window.location = '<?php echo site_url('scorecards/Appraisal');?>';
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
            var dataURL = "<?php echo site_url('scorecards/Appraisal/insert_form')?>";
            var action = "<?php echo site_url('scorecards/Appraisal/save')?>";
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
    
    //memunculkan modal apabila tombol edit di tekan
    $('#m_table_1').on('click', '.openPopupAdd', function(){
            var dataId = $(this).attr('data-id');
            var bulan = "<?php echo $DataBulan ?>";
            var tahun = "<?php echo $DataTahun ?>";
            var dataURL = "<?php echo site_url('scorecards/Appraisal/insert_form/')?>"+dataId+"/"+tahun+"/"+bulan;
            var action = "<?php echo site_url('scorecards/Appraisal/save/')?>"+dataId+"/"+tahun+"/"+bulan;
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
            var dataURL = "<?php echo site_url('scorecards/Appraisal/view_form/')?>"+dataId;
            $("#form_header").html("<?php echo $this->lang->line('view_header');?>");
            $("#form_input").attr("action", dataURL);
            $("#tombol_edit").attr("data-id", dataId);
            $("#form_input").removeClass('m-form m-form--state');
            $("#tombol_submit").hide();
            $("#tombol_edit").hide();
            $('.modal-body').load(dataURL,function(){
                $('#input_modal').modal({show:true});
            });
        });  
    
    //memunculkan modal apabila tombol edit di tekan
    $('#m_table_1').on('click', '.openPopupEdit', function(){
            var dataId = $(this).attr('data-id');
            var bulan = "<?php echo $DataBulan ?>";
            var tahun = "<?php echo $DataTahun ?>";
            var dataURL = "<?php echo site_url('scorecards/Appraisal/edit_form/')?>"+dataId+"/"+tahun+"/"+bulan;
            var action = "<?php echo site_url('scorecards/Appraisal/edit/')?>"+dataId+"/"+tahun+"/"+bulan;
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
            var dataURL = "<?php echo site_url('scorecards/Appraisal/edit_form/')?>"+dataId;
            var action = "<?php echo site_url('scorecards/Appraisal/edit/')?>"+dataId;
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
    
       $('#period_search').on('change', function(){
           var period=$(this).val();
           if(period=="m"){
                $(".select_bulan").show();
                $(".select_tahun").removeClass('col-md-12').addClass('col-md-5');
            }else{
                $(".select_bulan").hide();
                $(".select_tahun").removeClass('col-md-5').addClass('col-md-12');
            }
            
       });
    
});
function approveData(Id,UriApprove,UriRedirect) {
        
            var bulan = "<?php echo $DataBulan ?>";
            var tahun = "<?php echo $DataTahun ?>";
        swal({
            
                title: 'are you sure for complete this form?', 
                text: 'You will not be able to edit this form!',
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, complate form!",
                reverseButtons: !0
            }).then(function(e) {
                if(e.value){
                    //swal("Deleted!", "Your file has been deleted.", "success");
                    $.ajax({
                            url: UriApprove +"/"+ Id +"/"+tahun+"/"+bulan,
                            type: 'post'
                        }).done(function(data) {

                            swal({
                                title: "Success!",
                                text: 'Form KPI has been completed!',
                                type: "success",
                                confirmButtonText: "OK"
                            }).then(function(e) {
                                window.location = UriRedirect;
                            })
                        }).fail(function(data) {
                            swal("Oops", "We couldn't connect to the server!", "error");
                          });
                }
                //e.value ? swal("Deleted!", "Your file has been deleted.", "success") : "cancel" === e.dismiss && swal("Cancelled", "Your imaginary file is safe :)", "error")
            }) 
      }
</script>