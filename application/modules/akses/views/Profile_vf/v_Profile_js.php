<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
    <?php 
    if(isset($DataIdProfile))
    {
    ?>
$(function() {
    var start = moment([]);
    var end = moment([]);

    function cb(start, end) {
        var text;
        if(start.format('MMM D, YYYY') == moment().format('MMM D, YYYY')){
            text='today : '+start.format('MMM D');
        }else if(start.startOf('day').unix() == moment().subtract(1, 'days').startOf('day').unix()){
            text='Yesterday : '+start.format('MMM D');;
        }else{
            text =start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY');
        }
        $('#reportrange span').html(text);
         var dataURL = "<?php echo site_url('akses/Profile/list_acitivity/'.$DataIdProfile."/")?>"+start.startOf('day').unix()+"/"+end.endOf('day').unix();
            $('#list-timeline').load(dataURL);
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        useCurrent:'day',
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});
    <?php } ?>

    jQuery(document).ready(function() {
    var nip = $("#nip").val();
    if(nip!=""){
        $(".data_hidden").show();
    }else{
        $(".data_hidden").hide();
    }
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
               enctype: 'multipart/form-data',
               type: 'post',
               data: data,
               processData: false,
               contentType: false,
               dataType: 'json',
                beforeSend: function() {
                    mApp.blockPage({
                        overlayColor: "#000000",
                        type: "loader",
                        state: "primary",
                        message: "Processing..."
                    })
                },
               success: function(response){
                   mApp.unblockPage();
                   if(response.success == true){
                       //setelah sukses halaman d scroll ke top
                        //$(window).scrollTop(0);
                        if(stat==1){
                            window.location = '<?php echo site_url('akses/Profile/index/');?>'+response.kode;
                        }else{
                            window.location = '<?php echo site_url('akses/Profile/index');?>';
                        }
                        
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
                           element.closest('div.form-group')
                                   .find(".error")
                                   .html(value);
                       });
                   }
               }
           });
        });
    $("#form_edit").submit(function(e){
           e.preventDefault();
           
           var me = $(this);
           
           $.ajax({
               url: me.attr("action"),
               type: 'post',
               data: me.serialize(),
               dataType: 'json',
                beforeSend: function() {
                    mApp.blockPage({
                        overlayColor: "#000000",
                        type: "loader",
                        state: "primary",
                        message: "Processing..."
                    })
                },
               success: function(response){
                   mApp.unblockPage();
                   if(response.success == true){
                       //setelah sukses halaman d scroll ke top
                        //$(window).scrollTop(0);
                        
                        window.location = '<?php echo site_url('akses/Profile/index/');?>'+response.kode;
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
                           element.closest('div.form-group')
                                   .find(".error")
                                   .html(value);
                       });
                   }
               }
           });
        });
    
    $(".select2-ajax").select2({
                placeholder: "Loading remote data",
                allowClear: true,
                ajax: {
                  url: "<?php echo site_url('akses/Profile/search_detail_pegawai_ajax');?>",
                  dataType: 'json',
                  type: 'GET',
                  delay: 250,
                  data: function (params) {
                    return {
                      term: params.term, // search term
                      //page: params.page
                    };
                  },
                  processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                //alert(item.NIP);
                                
                                return {
                                    text: item.nama+" - "+item.nip,
                                    id: item.nip
                                }
                            })
                        };
                    },         
                  cache: true
                },
                minimumInputLength: 2,
                minimumResultsForSearch: 10
              });
    $('#nip').change(function() {
                var NIP= $( "#nip" ).val();
                $.ajax({
                    type:'GET',
                    url: '<?php echo site_url('akses/Profile/search_detail_pegawai_ajax');?>',
                    dataType: 'json',
                    data: {term:NIP},
                    success: function(data) {
                        $( "#username" ).val(data[0].nip);
                        $( "#first_name" ).val(data[0].nama);
                        $( "#company" ).val(data[0].nm_perusahaan);
                    }
		});
            });    
    $("#form_change_pass").submit(function(e){
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
                       //setelah sukses halaman d scroll ke top
                        //$(window).scrollTop(0);
                        
                        window.location = '<?php echo site_url('akses/Profile/index/');?>'+response.kode;
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
                           element.closest('div.form-group')
                                   .find(".error")
                                   .html(value);
                       });
                   }
               }
           });
        });
        $("#form_reset_pass").submit(function(e){
           e.preventDefault();
           
           var me = $(this);
           
           $.ajax({
               url: me.attr("action"),
               type: 'post',
               data: me.serialize(),
               dataType: 'json',
                beforeSend: function() {
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
                        
                        window.location = '<?php echo site_url('akses/Profile/view_form/');?>'+response.kode;
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