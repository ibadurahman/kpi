<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
    


    jQuery(document).ready(function() {

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
	        url: "<?php echo site_url('scorecards/AppraisalHistory/get_list/'.$DataTahun.'/'.$DataBulan)?>",
	        error: function (xhr, error, thrown) {
	       		alert("Cannot view log. Error database connection.");
	        }
	    }
							    
    });
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
                        
                        window.location = '<?php echo site_url('scorecards/AppraisalHistory');?>';
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
    
    //memunculkan modal apabila tombol view di tekan
    $('#m_table_1').on('click', '.openPopupView', function(){
            var dataId = $(this).attr('data-id');
            var dataURL = "<?php echo site_url('scorecards/AppraisalHistory/view_form/')?>"+dataId;
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
            var bulan = $(this).attr('data-bulan');
            // alert(bulan);
            // var bulan = "<?php //echo $DataBulan ?>";
            var tahun = "<?php echo $DataTahun ?>";
            var dataURL = "<?php echo site_url('scorecards/AppraisalHistory/edit_form/')?>"+dataId+"/"+tahun+"/"+bulan;
            var action = "<?php echo site_url('scorecards/AppraisalHistory/edit/')?>"+dataId+"/"+tahun+"/"+bulan;
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
        $('#m_table_1').on('click', '.delete-data', function(){
//            $('#menu').val('tes');
            var Id = $(this).attr("data-id");
            var UriDelete= "<?php echo site_url('scorecards/AppraisalHistory/delete')?>";
            var DelMessage= "<?php echo $this->lang->line('sukses_delete');?>";
            var UriRedirect= "<?php echo site_url('scorecards/AppraisalHistory/Index')?>";
            var Title= "<?php echo $this->lang->line('title_delete');?>";
            var TextMessage= "<?php echo $this->lang->line('konfirmasi_delete');?>";
            
            deleteData(Id,UriDelete,DelMessage,UriRedirect,Title,TextMessage);
            
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
//       $('#button_print').on('click', function(){
//           alert("tes");
//            
//       });
});
//document.getElementById("button_print").onclick = function () {
//    printElement(document.getElementById("print-area"));
//}
function ActionPrint(){
    //alert(document.getElementById("print-area"));
//    printElement(document.getElementById("print-area"));
    $('#print-area').printThis({
        debug: false,              
        importCSS: true,             
        importStyle: true,         
        printContainer: true,                
        removeInline: false,        
        printDelay: 333,            
        header: null,             
        formValues: true  
    });
}
//function printElement(elem) {
//    var domClone = elem.cloneNode(true);
//    
//    var $printSection = document.getElementById("printSection");
//    
//    if (!$printSection) {
//        var $printSection = document.createElement("div");
//        $printSection.id = "printSection";
//        document.body.appendChild($printSection);
//    }
//    
//    $printSection.innerHTML = "";
//    $printSection.appendChild(domClone);
//    window.print();
//}
</script>