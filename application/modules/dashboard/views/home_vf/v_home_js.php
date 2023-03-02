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
                                value : [<?php echo (isset($radar_perspective['Label']))? $radar_perspective['Value']:0; ?>],
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
//                    orient: 'vertical', 
//                    right: 10,
                    <?php
                        if(isset($line_perspective['legend'])){
                        $legend="'".implode("','", $line_perspective['legend'])."'";
                        echo "data: [".$legend."],";
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
        <?php
        if (empty($this->session->userdata('ses_perusahaan')))
            {
            ?>
        $('#home_modal').modal({backdrop: 'static', keyboard: false,show:true});
        <?php
            }
        ?>
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
                        
                        window.location = '<?php echo site_url('organisasi/Perusahaan/turn_on/');?>'+response.kode;
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
</script>