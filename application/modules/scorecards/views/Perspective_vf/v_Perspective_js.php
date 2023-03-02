<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script src="<?php echo base_url();?>assets/vendors/echarts/echarts.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
    
    $(window).on("load", function(){

    // Set paths
    // ------------------------------

    require.config({
        paths: {
           // echarts: '../../../app-assets/vendors/js/charts/echarts'
            echarts: '<?php echo base_url();?>assets/vendors/echarts'
        }
    });


    // Configuration
    // ------------------------------

    require(
        [
            'echarts',
            'echarts/chart/radar',
            'echarts/chart/chord'
        ],


        // Charts setup
        function (ec) {
            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('m_amcharts_9'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Add tooltip
                tooltip: {
                    trigger: 'axis'
                },

                // Add legend
                legend: {
                    orient : 'vertical',
                    x : 'right',
                    y : 'bottom',
                    data:['Performance']
                },

                // Add polar
                polar : [
                   {
                       indicator : [
                           <?php 
                           if(isset($radar_perspective['Label'])){
                           foreach (explode(",", $radar_perspective['Label']) as $key=>$val){
                               if($val!=""){
                               echo"{ text: ".$val.", max: 4},";
                               }
                           }
                           }
                           ?>
                        ]
                    }
                ],

                // Add custom colors
                color: ['#00B5B8'],

                // Enable drag recalculate
                calculable: true,

                // Add series
                series : [
                    {
                        name: 'Performance',
                        type: 'radar',
                        data : [
                            {
                                value : [<?php echo (isset($radar_perspective['Label']))?$radar_perspective['Value']:0; ?>],
                                name : 'Performance'
                            }
                        ]
                    }
                ]
            };

            // Apply options
            // ------------------------------

            myChart.setOption(chartOptions);


            // Resize chart
            // ------------------------------

            $(function () {

                // Resize chart on menu width change and window resize
                $(window).on('resize', resize);
                $(".menu-toggle").on('click', resize);

                // Resize function
                function resize() {
                    setTimeout(function() {

                        // Resize chart
                        myChart.resize();
                    }, 200);
                }
            });
        }
        
    );
    require(
        [
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/line'
        ],


        // Charts setup
        function (ec) {
            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('m_amcharts_7'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    x: 40,
                    x2: 40,
                    y: 50,
                    y2: 25,
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis'
                },

                // Add legend
                legend: {
                    <?php
                        if(isset($line_perspective['legend'])){
                        $legend="'".implode("','", $line_perspective['legend'])."'";
                        echo "data: [".$legend."]";
                        }
                    ?>
                },

                // Add custom colors
                <?php
                        if(isset($line_perspective['color'])){
                        $color="'".implode("','", $line_perspective['color'])."'";
                        echo "color: [".$color."],";
                        }
                    ?>

                // Enable drag recalculate
                calculable: true,

                // Hirozontal axis
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    <?php
                        if(isset($line_perspective['bulan'])){
                        $bulan="'".implode("','", $line_perspective['bulan'])."'";
                        echo "data: [".$bulan."]";
                        }
                    ?>
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value'
                }],

                // Add series
                // Add series
                series: [
                    <?php
                    if(isset($line_perspective['data_grafik'])){
                    foreach($line_perspective['data_grafik'] as $key=>$val){
                        $score=implode(",", $val['score']);
                        echo"{
                            name:'".$val['nama']."',
                            type:'line',
                            data:[".$score."]
                        },";
                    }
                    }
                    ?>
                ]
            };

            // Apply options
            // ------------------------------

            myChart.setOption(chartOptions);



            // Resize chart
            // ------------------------------

            $(function () {

                // Resize chart on menu width change and window resize
                $(window).on('resize', resize);
                $(".menu-toggle").on('click', resize);

                // Resize function
                function resize() {
                    setTimeout(function() {

                        // Resize chart
                        myChart.resize();
                    }, 200);
                }
            });
        }
    );
});

    jQuery(document).ready(function() {
         
        $('#m_table_1').on('click', '.delete-data', function(){
//            $('#menu').val('tes');
            var Id = $(this).attr("data-id");
            var UriDelete= "<?php echo site_url('scorecards/Perspective/delete')?>";
            var DelMessage= "<?php echo $this->lang->line('sukses_delete');?>";
            var UriRedirect= "<?php echo site_url('scorecards/Perspective/Index/'.$DataTahun.'/'.$DataBulan)?>";
            var Title= "<?php echo $this->lang->line('title_delete');?>";
            var TextMessage= "<?php echo $this->lang->line('konfirmasi_delete');?>";
            
            deleteData(Id,UriDelete,DelMessage,UriRedirect,Title,TextMessage);
            
       });
 
            
    $("#m_table_1").DataTable({
        "sDom": 'frtp',
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
                targets:5, width:"60px"
            },
            {
                targets:1, visible: false
            },
            {
                targets:4, visible: false
            }
            
            ],
	"ajax": {
	        url: "<?php echo site_url('scorecards/Perspective/get_list/'.$DataTahun."/".$DataBulan)?>",
	        error: function (xhr, error, thrown) {
	       		alert("Cannot view log. Error database connection.");
	        }
	    }
							    
    });
    $("#m_table_2").DataTable({
        "sDom": 'frtp',
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
	}, 
        columnDefs:[ {
                targets:3, className: 'txt_align_right'
            },
            
            ],
	"ajax": {
	        url: "<?php echo site_url('scorecards/Perspective/get_list_bobot/'.$DataTahun)?>",
	        error: function (xhr, error, thrown) {
	       		alert("Cannot view log. Error database connection.");
	        }
	    }
							    
    });
//    $('.tombol-save').on('click', function(){
//        $("#StatusSave").val(1);
//        $("#form_input").submit();
//    });
//    $('.tombol-save2').on('click', function(){
//        $("#StatusSave").val(2);
//        $("#form_input").submit();
//    });
$("#input_modal").on("shown.bs.modal", function() {
            $("#tahun").select2( {
                placeholder: "Select an option",
                allowClear: true
            }
            );
            $('.list-weightage').keyup(function(){
                    var total = 0;
                $('.list-weightage').each(function() {
                    var nilai=$(this).val();
                    nilai=(nilai=="")?parseFloat(0):parseFloat(nilai);
                    total = total + nilai;
                });
                $("#total").html("<b>"+total+"</b>");
                    var no = 1;
                    var persen=0;
                    var total_persen=0;
                $('.list-weightage').each(function() {
                    var nilai=$(this).val();
                    nilai=(nilai=="")?parseFloat(0):parseFloat(nilai);
                    persen = parseFloat(((nilai / total)*100).toFixed(2));
                    total_persen=total_persen+persen;
                    $("#bobot"+no).html(persen+"%");
                    no++;
                });
                if(total_persen>100){
                    total_persen=100;
                }else{
                    total_persen=parseFloat(total_persen).toFixed(2); 
                }
                $("#total_persen").html("<b>"+total_persen+"%</b>");
                $("#total_bobot").val(total_persen);
            });
            $('.list-weightage').on('change',function(){
                    var total = 0;
                $('.list-weightage').each(function() {
                    var nilai=$(this).val();
                    nilai=(nilai=="")?parseFloat(0):parseFloat(nilai);
                    total = total + nilai;
                });
                $("#total").html("<b>"+total+"</b>");
                    var no = 1;
                    var persen=0;
                    var total_persen=0;
                $('.list-weightage').each(function() {
                    var nilai=$(this).val();
                    nilai=(nilai=="")?parseFloat(0):parseFloat(nilai);
                    persen = parseFloat(((nilai / total)*100).toFixed(2));
                    total_persen=total_persen+persen;
                    $("#bobot"+no).html(persen+"%");
                    no++;
                });
                if(total_persen>100){
                    total_persen=100;
                }else{
                    total_persen=parseFloat(total_persen).toFixed(2); 
                }
                $("#total_persen").html("<b>"+total_persen+"%</b>");
                $("#total_bobot").val(total_persen);
            });
        }
    );
    
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
                       if(response.kode !=""){
                            window.location = '<?php echo site_url('scorecards/Perspective/view_form/');?>'+response.kode+'<?php echo "/".$DataTahun.'/'.$DataBulan; ?>';
                        }else{
                            window.location = '<?php echo site_url('scorecards/Perspective/index/'.$DataTahun.'/'.$DataBulan);?>';
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
    
    //memunculkan modal apabila tombol new di tekan
    $('#button_add').on('click', function(){
            //alert('tes');
            
            var dataURL = "<?php echo site_url('scorecards/Perspective/insert_form/'.$DataTahun)?>";
            var action = "<?php echo site_url('scorecards/Perspective/save/'.$DataTahun)?>";
            $("#form_header").html("<?php echo $this->lang->line('input_header');?>");
            $("#form_input").attr("action", action);
            $("#form_input").addClass('m-form m-form--state');
            $("#tombol_submit").show();
            $("#tombol_edit").hide();
            $('.modal-body').load(dataURL,function(){
                $('#input_modal').modal({show:true});
            });
        });  
    $('#button_add_bobot').on('click', function(){
            //alert('tes');
            swal({
                title: "Do you want duplicate data from last year?",
                text: "You won't be able to revert this!",
                type: "question",
                showCancelButton: !0,
                confirmButtonText: "Yes, duplicate it!",
                cancelButtonText: "No, create new!",
                reverseButtons: !0
            }).then(function(e) {
                if(e.value){
                    //swal("Deleted!", "Your file has been deleted.", "success");
                    $.ajax({
                            url: "<?php echo site_url('scorecards/Perspective/copy_bobot/'.$DataTahun)?>",
                            type: 'post',
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
                                    swal({
                                        title: "Duplicated!",
                                        text: "<?php echo $this->lang->line('success_duplicate');?>",
                                        type: "success"
                                    }).then(function(e) {
                                        if(response.kode !=""){
                                         window.location = '<?php echo site_url('scorecards/Perspective/index/');?>'+response.kode;
                                     }else{
                                         window.location = '<?php echo site_url('scorecards/Perspective');?>';
                                         }
                                    })
                                    

                                }
                                else{
                                    $(window).scrollTop(0);
                                    swal("Cancelled", "<?php echo $this->lang->line('error_weightage_duplicate');?>", "error");
                                }
                            }
                        });
                }else{
                    var dataURL = "<?php echo site_url('scorecards/Perspective/bobot_insert_form/'.$DataTahun)?>";
                    var action = "<?php echo site_url('scorecards/Perspective/bobot_save')?>";
                    $("#form_header").html("<?php echo $this->lang->line('input_header_bobot');?>");
                    $("#form_input").attr("action", action);
                    $("#form_input").addClass('m-form m-form--state');
                    $("#tombol_submit").show();
                    $("#tombol_edit").hide();
                    $('.modal-body').load(dataURL,function(){
                        $("#tahun").select2( {
                            placeholder: "Select an option",
                            allowClear: true
                        }
                        );
                        $('#input_modal').modal({show:true});
                    });
                }
                //e.value ? swal("Deleted!", "Your file has been deleted.", "success") : "cancel" === e.dismiss && swal("Cancelled", "Your imaginary file is safe :)", "error")
            })
            
        });  
      //memunculkan modal apabila tombol new di tekan
    $('#button_edit').on('click', function(){
            var dataId = $(this).attr('data-id');
            //alert(dataId);
            var dataURL = "<?php echo site_url('scorecards/Perspective/edit_form/')?>"+dataId;
            var action = "<?php echo site_url('scorecards/Perspective/edit/')?>"+dataId;
            $("#form_header").html("<?php echo $this->lang->line('edit_header');?>");
            $("#form_input").attr("action", action);
            $("#form_input").addClass('m-form m-form--state');
            $("#tombol_submit").show();
            $("#tombol_edit").hide();
            $('.modal-body').load(dataURL,function(){
                $('#input_modal').modal({show:true});
            });
        });
    //memunculkan modal apabila tombol new di tekan
    $('#button_edit_bobot').on('click', function(){
            var dataId = $(this).attr('data-id');
            //alert(dataId);
            var dataURL = "<?php echo site_url('scorecards/Perspective/bobot_edit_form/')?>"+dataId;
            var action = "<?php echo site_url('scorecards/Perspective/bobot_edit/')?>"+dataId;
            $("#form_header").html("<?php echo $this->lang->line('edit_header_bobot');?>");
            $("#form_input").attr("action", action);
            $("#form_input").addClass('m-form m-form--state');
            $("#tombol_submit").show();
            $("#tombol_edit").hide();
            $('.modal-body').load(dataURL,function(){
                $('#input_modal').modal({show:true});
            });
        });
    $('#button_delete').on('click', function(){
//            $('#menu').val('tes');
            var Id = $(this).attr("data-id");
            var UriDelete= "<?php echo site_url('scorecards/Perspective/delete')?>";
            var DelMessage= "<?php echo $this->lang->line('sukses_delete');?>";
            var UriRedirect= "<?php echo site_url('scorecards/Perspective/Index')?>";
            var Title= "<?php echo $this->lang->line('title_delete');?>";
            var TextMessage= "<?php echo $this->lang->line('konfirmasi_delete');?>";
            
            deleteData(Id,UriDelete,DelMessage,UriRedirect,Title,TextMessage);
            
       });
       $('#button_delete_bobot').on('click', function(){
//            $('#menu').val('tes');
            var Id = $(this).attr("data-id");
            var UriDelete= "<?php echo site_url('scorecards/Perspective/delete_bobot')?>";
            var DelMessage= "<?php echo $this->lang->line('sukses_delete');?>";
            var UriRedirect= "<?php echo site_url('scorecards/Perspective/Index')?>";
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
       <?php
    if($DataBulan!=""){
        echo "$('.select_bulan').show();
                $('.select_tahun').removeClass('col-md-12').addClass('col-md-5');";
    }else{
        echo "$('#period_search').val('y').trigger('change');";
        echo "$('.select_bulan').hide();
                $('.select_tahun').removeClass('col-md-5').addClass('col-md-12');";
    }
    ?>
});
</script>