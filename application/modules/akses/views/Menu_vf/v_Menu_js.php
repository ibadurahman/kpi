<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
    var Treeview= {
    init:function() {
        $("#m_tree_1").on("select_node.jstree", function (e, data) {
                var x = $("#m_portlet_tools_1");
			if(data.selected.length) {
                            x.show();
                            $("#judul-form").html('<?php echo $this->lang->line('edit_header'); ?>');
                            $("#form_input").attr('action','<?php echo site_url('akses/Menu/edit/') ?>'+data.selected);
                            $(".delete-data").attr('data-id',data.selected);
                            $("#tombol-del").show();
                            $.ajax({
                                url: '<?php echo site_url('akses/Menu/get_data_menu/'); ?>'+data.selected,
                                type: 'post',
                                data: $("#form_input").serialize(),
                                dataType: 'json',
                                success: function(response){
                                    if(response.success == true){
                                        alert('sukses');
                                    }
                                    else{
                                        $(window).scrollTop(0);
                                        $.each(response.data, function(key, value){
                                            var element = $("#" + key);
                                            if(key == "status_show" || key == "quick_menu" || key == "stat_section"){
                                                if(value==1){
                                                    element.prop('checked', true);
                                                }else{
                                                    element.prop('checked', false);
                                                }
                                            }
                                            else if(key=="kd_menu_parent"){
                                                element.val(value).trigger('change');
                                            }
                                            else
                                            {
                                                element.val(value);
                                            }
//                                            element.closest('div.form-group')
//                                                    .removeClass('has-danger')
//                                                    .addClass(value.length>0 ?'has-danger':'')
//                                                    .find(".text-error")
//                                                    .remove();
//                                            element.after(value);
                                        });
                                    }
                                }
                            });
                            //alert('The selected node is: ' + data.instance.get_node(data.selected[0]).text);
			}
		}).jstree( {
            core: {
                themes: {
                    responsive: !1
                }
            }
            , types: {
                default: {
                    icon: "fa fa-folder"
                }
                , file: {
                    icon: "fa fa-file"
                }
            }
            , plugins:["types"]
        }
        ),
        function() {
                var e = $("#m_portlet_tools_1");
                e.hide();
                $("#button_add").on("click",function(){
                    e.show();
                    $("#judul-form").html('<?php echo $this->lang->line('input_header'); ?>');
                    $("#form_input").attr('action','<?php echo site_url('akses/Menu/save') ?>');
                    $("#form_input")[0].reset();
                    $("#tombol-del").hide();
                }),
                $("#tombol-cancel").on("click",function(){
                    e.hide();
                    $(window).scrollTop(0);
                    $(".form-group").removeClass("has-danger");         
                        $(".text-error").remove();
                        
                        //reset form
                        $("#form_input")[0].reset();
                })
            }()
    }
}

;
    jQuery(document).ready(function() {
        Treeview.init();
        
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
                       //setelah sukses halaman d scroll ke top
                        //$(window).scrollTop(0);
                        
                        window.location = '<?php echo site_url('akses/Menu');?>';
                        //hide form
//                        $("#m_portlet_tools_1").hide();
//                        
//                        //show massage & hilangkan pesan error
//                        $("#pesan").append('<div class="alert alert-success alert-dismissible fade show" role="alert">\n\
//                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n\
//                                        </button>'+'Data has been saved ' + '</div>');
//                        $(".form-group").removeClass("has-danger");         
//                        $(".text-error").remove();
//                        
//                        //reset form
//                        me[0].reset();
//                        
//                        // close pesan setelah beberapa detik
//                        $(".alert-success").delay(500).show(10,function(){
//                            $(this).delay(3000).hide(10,function(){
//                                $(this).remove();
//                            });
//                        });
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
        
        $('.delete-data').on('click', function(){
//            $('#menu').val('tes');
            var Id = $(this).attr("data-id");
            var UriDelete= "<?php echo site_url('akses/Menu/delete')?>";
            var DelMessage= "<?php echo $this->lang->line('sukses_delete');?>";
            var UriRedirect= "<?php echo site_url('akses/Menu/Index')?>";
            var Title= "<?php echo $this->lang->line('title_delete');?>";
            var TextMessage= "<?php echo $this->lang->line('konfirmasi_delete');?>";
            
            deleteData(Id,UriDelete,DelMessage,UriRedirect,Title,TextMessage);
            
            //get data menu, karena saat cancel data pada field terhapus
            $.ajax({
                url: '<?php echo site_url('akses/Menu/get_data_menu/'); ?>'+Id,
                type: 'post',
                data: $("#form_input").serialize(),
                dataType: 'json',
                success: function(response){
                    if(response.success == true){
                        alert('sukses');
                    }
                    else{
                        $(window).scrollTop(0);
                        $.each(response.data, function(key, value){
                            var element = $("#" + key);
                            if(key == "status_show" || key == "quick_menu" || key == "stat_section"){
                                if(value==1){
                                    element.prop('checked', true);
                                }else{
                                    element.prop('checked', false);
                                }
                            }
                            else if(key=="kd_menu_parent"){
                                element.val(value).trigger('change');
                            }
                            else
                            {
                                element.val(value);
                            }
//                            element.closest('div.form-group')
//                                    .removeClass('has-danger')
//                                    .addClass(value.length>0 ?'has-danger':'')
//                                    .find(".text-error")
//                                    .remove();
//                            element.after(value);
                        });
                    }
                }
            });
       });
    }

);
</script>