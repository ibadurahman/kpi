<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script src="<?php echo base_url();?>assets/vendors/echarts/echarts.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
 $(window).on("load", function(){

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
            'echarts/chart/funnel',
            'echarts/chart/gauge'
        ],


        // Charts setup
        function (ec) {

            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('basic-gauge'));

            // Chart Options
            // ------------------------------
            basicgaugeOptions = {

                // Add tooltip
                tooltip : {
                    formatter: "{a} <br/>{b} : {c}"
                },

                // Add toolbox
//                toolbox: {
//                    show : true,
//                    feature : {
//                        mark : {show: true},
//                        restore : {show: true},
//                        saveAsImage : {show: true}
//                    }
//                },

                // Enable drag recalculate
                calculable: true,

                // Add series
                 series : [
                        { 
                            title:{
                                show:true,
                                offsetCenter:[0,-130],
                                color:'#888',
                                fontWeight:'bold',
                                fontSize:24 
                                },
                            clockwise:true,
                            startAngle:180,
                            endAngle:0,
                            axisLine: {            // Coordinate axis
                                lineStyle: {       // Attribute lineStyle control line style
                                    width: 20,
                                    color: [[0.25, '#f4516c'], [0.75, '#ffb822'], [1, '#34bfa3']]
                                }
                            },
                            color: {
                                type: 'radial',
                                x: 0.5,
                                y: 0.5,
                                r: 0.5,
                                colorStops: [{
                                    offset: 0, color: 'red' // color at 0% position
                                }, {
                                    offset: 1, color: 'blue' // color at 100% position
                                }],
                                global: false // false by default
                            },
                            pointer:{show:true},
                            axisTick:{show:true},
                            splitLine:{show:true},
                            name:'Business Indicators',
                            type:'gauge',
                            min:0,
                            max:4,
                            splitNumber: 4,
                            detail : {
                                offsetCenter:[0,40],
                                formatter:'{value}'
                                },
                            data:[{value: <?php echo $GaugePegawai; ?>, name: 'Score'}]
                        }]
            };

            // Apply options
            // ------------------------------

            myChart.setOption(basicgaugeOptions);



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

//                clearInterval(timeTicket);
//                var timeTicket = setInterval(function (){
//                    basicgaugeOptions.series[0].data[0].value = (Math.random()*100).toFixed(2) - 0;
//                    myChart.setOption(basicgaugeOptions, true);
//                },2000);
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
                    y: 15,
                    y2: 25
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis'
                },

                

                // Add custom colors
                <?php
                        $color="'".implode("','", $ChartPegawai['color'])."'";
                        echo "color: [".$color."],";
                    ?>

                // Enable drag recalculate
                calculable: true,

                // Hirozontal axis
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    <?php
                        $bulan="'".implode("','", $ChartPegawai['bulan'])."'";
                        echo "data: [".$bulan."]";
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
                    foreach($ChartPegawai['data_grafik'] as $key=>$val){
                        $score=implode(",", $val['score']);
                        echo"{
                            name:'".$val['nama']."',
                            type:'line',
                            stack:'Total',
                            data:[".$score."]
                        },";
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
    $('#button_delete').on('click', function(){
//            $('#menu').val('tes');
            var Id = $(this).attr("data-id");
            var Id2 = $(this).attr("data-id2");
            var Id3 = $(this).attr("data-id3");
            var UriDelete= "<?php echo site_url('organisasi/Pegawai/pegawai_kpi_delete/')?>"+Id2+"/"+Id3;
            var DelMessage= "<?php echo $this->lang->line('sukses_delete');?>";
            var UriRedirect= "<?php echo site_url('organisasi/Pegawai/view_form/')?>"+Id2+"/"+Id3;
            var Title= "<?php echo $this->lang->line('title_delete');?>";
            var TextMessage= "<?php echo $this->lang->line('konfirmasi_delete');?>";
            
            deleteData(Id,UriDelete,DelMessage,UriRedirect,Title,TextMessage);
            
       });
    $('#tbl_measurement').on('click', '.delete-data', function(){
//            $('#menu').val('tes');
            var Id = $(this).attr("data-id");
            var Id2 = $(this).attr("data-id2");
            var Id3 = $(this).attr("data-id3");
            var UriDelete= "<?php echo site_url('organisasi/Pegawai/pegawai_kpi_delete/')?>"+Id2+"/"+Id3;
            var DelMessage= "<?php echo $this->lang->line('sukses_delete');?>";
            var UriRedirect= "<?php echo site_url('organisasi/Pegawai/view_form/')?>"+Id2+"/"+Id3;
            var Title= "<?php echo $this->lang->line('title_delete');?>";
            var TextMessage= "<?php echo $this->lang->line('konfirmasi_delete');?>";
            
            deleteData(Id,UriDelete,DelMessage,UriRedirect,Title,TextMessage);
            
       });
    $('#button_add_bobot').on('click', function(){
            //alert('tes');
            var dataId = $(this).attr('data-id');
            var tahun = "<?php echo $DataTahun; ?>";
            swal({
                title: "Do you want duplicate data from last year?",
                text: "You won't be able to revert this!",
                type: "question",
                showCancelButton: !0,
                confirmButtonText: "Yes, duplicate it!",
                cancelButtonText: "create new!",
                reverseButtons: !0
            }).then(function(e) {
                if(e.value){
                    //swal("Deleted!", "Your file has been deleted.", "success");
                    $.ajax({
                            url: "<?php echo site_url('organisasi/Pegawai/copy_bobot/'.$DataTahun."/")?>"+dataId,
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
                                         window.location = '<?php echo site_url('organisasi/Pegawai/view_form/');?>'+response.kode+"/"+tahun;
                                     }else{
                                         window.location = '<?php echo site_url('organisasi/Pegawai');?>';
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
                    window.location="<?php echo site_url("organisasi/Pegawai/kpi_insert_form/") ?>"+dataId+"/"+tahun;
                }
                //e.value ? swal("Deleted!", "Your file has been deleted.", "success") : "cancel" === e.dismiss && swal("Cancelled", "Your imaginary file is safe :)", "error")
            })
            
        });
    $('.button_bobot_bd').on('click', function(){
            var dataId = $(this).attr('data-id');
            var dataId2 = $(this).attr('data-id2');
            var dataId3 = $(this).attr('data-id3');
            var dataURL = "<?php echo site_url('organisasi/Pegawai/bobot_insert_form/'.$DataTahun."/")?>"+dataId+"/"+dataId2;
            var action = "<?php echo site_url('organisasi/Pegawai/bobot_save/'.$DataTahun."/")?>"+dataId+"/"+dataId2+"/"+dataId3;
            $("#form_header").html("<?php echo $this->lang->line('input_header_bobot');?>");
            $("#form_input_modal").attr("action", action);
            $("#form_input_modal").addClass('m-form m-form--state');
            $("#tombol_submit").show();
            $("#tombol_edit").hide();
            $('.modal-body').load(dataURL,function(){
                $('#input_modal').modal({show:true});
            });
    });
    $('.button_view_kpi').on('click', function(){
            var dataId = $(this).attr('data-id');
            var dataURL = "<?php echo site_url('organisasi/Pegawai/kpi_view_form/')?>"+dataId;
            var action = "<?php echo site_url('organisasi/Pegawai/kpi_view_form/')?>"+dataId;
            $("#form_header").html("<?php echo $this->lang->line('header_kpi_view');?>");
            $("#form_input_modal").attr("action", action);
            $("#form_input_modal").addClass('m-form m-form--state');
            $("#tombol_submit").hide();
            $("#tombol_edit").hide();
            $('.modal-body').load(dataURL,function(){
                $('#input_modal').modal({show:true});
            });
    });
    $('.button_input_target').on('click', function(){
            var dataId = $(this).attr('data-id');
            var dataId2 = $(this).attr('data-id2');
            var tahun = $(this).attr('data-thn');
            var bulan = $(this).attr('data-bln');
            var dataURL = "<?php echo site_url('organisasi/Pegawai/target_insert_form/')?>"+dataId+"/"+tahun+"/"+bulan
            var action = "<?php echo site_url('organisasi/Pegawai/target_save/')?>"+dataId+"/"+dataId2;
            $("#form_header").html("<?php echo $this->lang->line('header_target_title');?>");
            $("#form_input_modal").attr("action", action);
            $("#form_input_modal").addClass('m-form m-form--state');
            $("#tombol_submit").show();
            $("#tombol_edit").hide();
            $('.modal-body').load(dataURL,function(){
                $('#input_modal').modal({show:true});
            });
    });
    $('.button_view_target').on('click', function(){
            var dataId = $(this).attr('data-id');
            // var dataId2 = $(this).attr('data-id2');
            // var dataId3 = $(this).attr('data-id3');
            var tahun = "<?php echo $DataTahun; ?>";
            var dataURL = "<?php echo site_url('organisasi/Pegawai/target_view_form/')?>"+dataId
            $("#form_header").html("<?php echo $this->lang->line('header_target_title');?>");
            $("#form_input_modal").attr("action", dataURL);
            $("#tombol_edit").attr("data-id", dataId);
            // $("#tombol_edit").attr("data-id2", dataId2);
            // $("#tombol_edit").attr("data-id3", dataId3);
            $("#form_input_modal").addClass('m-form m-form--state');
            $("#tombol_submit").hide();
            $("#tombol_edit").show();
            $('.modal-body').load(dataURL,function(){
                $('#input_modal').modal({show:true});
            });
    });
    
    $('#tombol_edit').on('click', function(){
            var dataId = $(this).attr('data-id');
            var tahun = "<?php echo $DataTahun; ?>";
            var dataURL = "<?php echo site_url('organisasi/Pegawai/target_edit_form/')?>"+dataId
            var action = "<?php echo site_url('organisasi/Pegawai/target_edit/')?>"+dataId;
            $("#form_header").html("<?php echo $this->lang->line('header_target_title');?>");
            $("#form_input_modal").attr("action", action);
            $("#form_input").addClass('m-form m-form--state');
            $("#tombol_submit").show();
            $("#tombol_edit").hide();
            $('.modal-body').load(dataURL,function(){
                $('#input_modal').modal({show:true});
            });
        });
    $("#input_modal").on("shown.bs.modal", function() {
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
                        var tahun="<?php echo $DataTahun ;?>";
                        var bulan="<?php echo $DataBulan ;?>";
                            if('kode' in response){
                                window.location = '<?php echo site_url('organisasi/Pegawai/view_form/');?>'+response.kode+"/"+tahun+"/"+bulan;
                            }else{
                                window.location = '<?php echo site_url('organisasi/Pegawai');?>';
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