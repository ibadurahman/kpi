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
        
    $("#m_table_1").DataTable({
        "sDom": 'lBrtip',
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
                targets:7, width:"80px"
            }
            , {
                targets:7, render:function(e, a, t, n) {
                    var s= {
                        1: {
                            title: "active", class: "m-badge--success"
                        }
                        , 2: {
                            title: "resign", class: " m-badge--danger"
                        }
                    }
                    ;
                    return void 0===s[e]?e:'<span class="m-badge '+s[e].class+' m-badge--wide">'+s[e].title+"</span>"
                }
            },
//                {"sClass": "txt_align_right", "aTargets": [6]},
                    {"sClass": "txt_align_center", "aTargets": [1,6]}
            ],
	"ajax": {
	        url: "<?php echo site_url('report/ReportPegawai/get_list')?>",
	        error: function (xhr, error, thrown) {
	       		alert("Cannot view log. Error database connection.");
	        }
	    }
							    
    });
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
                       $('#m_table_1').DataTable().clear().destroy();
                       $("#m_table_1").DataTable({
                            "sDom": 'lBrtip',
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
                                    targets:7, width:"80px"
                                }
                                , {
                                    targets:7, render:function(e, a, t, n) {
                                        var s= {
                                            1: {
                                                title: "active", class: "m-badge--success"
                                            }
                                            , 2: {
                                                title: "resign", class: " m-badge--danger"
                                            }
                                        }
                                        ;
                                        return void 0===s[e]?e:'<span class="m-badge '+s[e].class+' m-badge--wide">'+s[e].title+"</span>"
                                    }
                                },
                    //                {"sClass": "txt_align_right", "aTargets": [6]},
                                        {"sClass": "txt_align_center", "aTargets": [1,6]}
                                ],
                            "ajax": {
                                    url: "<?php echo site_url('report/ReportPegawai/get_list/')?>"+response.data,
                                    error: function (xhr, error, thrown) {
                                            alert("Cannot view log. Error database connection.");
                                    }
                                }

                        });
                   }
               }
           });
        });
});
</script>