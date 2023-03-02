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