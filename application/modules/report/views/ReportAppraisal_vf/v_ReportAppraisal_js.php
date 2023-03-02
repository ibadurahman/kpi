<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
    
jQuery(document).ready(function() {

        $( '.daterangecustom' ).daterangepicker({
                autoUpdateInput: false,
		locale: {
			format: 'DD/MM/YYYY',
                        cancelLabel: 'Clear'
		}
	});
         $('.daterangecustom').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('.daterangecustom').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        
   $(".report_content").hide();
   $(".report_content2").hide();
   $(".report_content3").hide();
    $(".report_content4").hide();
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
                    //    alert(response.bulan);
                       if(response.tipe==1 && response.bulan!=""){
                            $(".report_content").show();
                            $(".report_content2").hide();
                            $(".report_content3").hide();
                            $(".report_content4").hide();
                            $('#m_table_1').DataTable().clear().destroy();
                            $("#m_table_1").DataTable({
                                 "sDom": 'lBrtip',
                                 "iDisplayLength": 50,
                                 "order": [[ 0, "asc" ]],
                                 "scrollX": true,
                                 "processing": true,
                                 "serverSide": true,
                                 "pagingType": "full_numbers",
                                 "language": {
                                     "infoFiltered": "",
                                     "paginate": {
                                       "previous": "<",
                                       "next": ">"
                                     }
                                 }, columnDefs:[ {
                                         targets:3, width:"200px"
                                     },{
                                         targets:4, width:"200px"
                                     },
                                         {"sClass": "txt_align_right", "aTargets": [7]},
                                             {"sClass": "txt_align_center", "aTargets": [1,5,6]}
                                     ],
                                 "ajax": {
                                         url: "<?php echo site_url('report/ReportAppraisal/get_list/')?>"+response.data,
                                         error: function (xhr, error, thrown) {
                                                 alert("Cannot view log. Error database connection.");
                                         }
                                     }

                             });
                        }
                        else if(response.tipe==1 && response.bulan==""){
                            $(".report_content").hide();
                            $(".report_content2").hide();
                            $(".report_content3").show();
                            $(".report_content4").hide();
                            $('#m_table_3').DataTable().clear().destroy();
                            $("#m_table_3").DataTable({
                                 "sDom": 'lBrtip',
                                 "iDisplayLength": 50,
                                 "order": [[ 0, "asc" ]],
                                 "scrollX": true,
                                 "processing": true,
                                 "serverSide": true,
                                //  "autoWidth": false,
                                //     "scrollCollapse": true,
                                 "pagingType": "full_numbers",
                                 "language": {
                                     "infoFiltered": "",
                                     "paginate": {
                                       "previous": "<",
                                       "next": ">"
                                     }
                                 }, columnDefs:[ {
                                         targets:2, width:"500px"
                                     },{
                                         targets:3, width:"500px"
                                     },{
                                         targets:4, width:"500px"
                                     },
                                     ],
                                 "ajax": {
                                         url: "<?php echo site_url('report/ReportAppraisal/get_list_rekap/')?>"+response.data,
                                         error: function (xhr, error, thrown) {
                                                 alert("Cannot view log. Error database connection.");
                                         }
                                     }

                             });
                        }
                        else if(response.tipe==2 && response.bulan!=""){
                            $(".report_content").hide();
                            $(".report_content2").show();
                            $(".report_content3").hide();
                            $(".report_content4").hide();
                            $('#m_table_2').DataTable().clear().destroy();
                            $("#m_table_2").DataTable({
                                 "sDom": 'lBrtip',
                                 "iDisplayLength": 50,
                                 "order": [[ 0, "asc" ]],
                                 "scrollX": true,
                                 "processing": true,
                                 "serverSide": true,
                                 "pagingType": "full_numbers",
                                 "language": {
                                     "infoFiltered": "",
                                     "paginate": {
                                       "previous": "<",
                                       "next": ">"
                                     }
                                 }, columnDefs:[ {
                                         targets:2, width:"200px"
                                     },
                                         {"sClass": "txt_align_right", "aTargets": [5]},
                                             {"sClass": "txt_align_center", "aTargets": [1,3,4]}
                                     
                                     ],
                                 "ajax": {
                                         url: "<?php echo site_url('report/ReportAppraisal/get_list_dept/')?>"+response.data,
                                         error: function (xhr, error, thrown) {
                                                 alert("Cannot view log. Error database connection.");
                                         }
                                     }

                             });
                        }
                        else if(response.tipe==2 && response.bulan==""){
                            $(".report_content").hide();
                            $(".report_content2").hide();
                            $(".report_content3").hide();
                            $(".report_content4").show();
                            $('#m_table_4').DataTable().clear().destroy();
                            $("#m_table_4").DataTable({
                                 "sDom": 'lBrtip',
                                 "iDisplayLength": 50,
                                 "order": [[ 0, "asc" ]],
                                 "scrollX": true,
                                 "processing": true,
                                 "serverSide": true,
                                 "pagingType": "full_numbers",
                                 "language": {
                                     "infoFiltered": "",
                                     "paginate": {
                                       "previous": "<",
                                       "next": ">"
                                     }
                                 },
                                 "ajax": {
                                         url: "<?php echo site_url('report/ReportAppraisal/get_list_dept_rekap/')?>"+response.data,
                                         error: function (xhr, error, thrown) {
                                                 alert("Cannot view log. Error database connection.");
                                         }
                                     }

                             });
                        }
                   }
                   else{
                       $(window).scrollTop(0);
                            $(".report_content").hide();
                            $(".report_content2").hide();
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
});
</script>