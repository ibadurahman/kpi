<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
    


    jQuery(document).ready(function() {

        $(".datepicker_custom").datetimepicker( {
            format: 'dd-mm-yyyy',
                todayHighlight: !0, autoclose: !0, startView: 2, minView: 2, forceParse: 0, pickerPosition: "bottom-left"
        }); 
        $('#m_table_1').on('click', '.delete-data', function(){
//            $('#menu').val('tes');
            var Id = $(this).attr("data-id");
            var UriDelete= "<?php echo site_url('organisasi/Pegawai/delete')?>";
            var DelMessage= "<?php echo $this->lang->line('sukses_delete');?>";
            var UriRedirect= "<?php echo site_url('organisasi/Pegawai/Index')?>";
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
	}, columnDefs:[
            // {
            //     targets:6, width:"70px"
            // },
            {
                targets:8, width:"83px"
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
            }
            ],
	"ajax": {
	        url: "<?php echo site_url('organisasi/Pegawai/get_list')?>",
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
                                window.location = '<?php echo site_url('organisasi/Pegawai/view_form/');?>'+response.nip;
                            }else{
                                window.location = '<?php echo site_url('organisasi/Pegawai');?>';
                            }
                            
                        }else{
                            window.location = '<?php echo site_url('organisasi/Pegawai/insert_form');?>';
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
    
    
    $(document.body).on('change',"#foto",function () {
        //doStuff
        //Get count of selected files
                var countFiles = $(this)[0].files.length;

                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#image-holder");
                image_holder.empty();

                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof (FileReader) != "undefined") {

                        //loop for each file selected for uploaded.
                        for (var i = 0; i < countFiles; i++) {

                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $("<img />", {
                                    "src": e.target.result,
                                        "class": "thumb-image",
                                        "style": "width: 200px; max-height: 150px;"
                                }).appendTo(image_holder);
                            }

                            image_holder.show();
                            reader.readAsDataURL($(this)[0].files[i]);
                        }

                    } else {
                        alert("This browser does not support FileReader.");
                    }
                } else {
                    alert("Pls select only images");
                }
     });
    
});
</script>