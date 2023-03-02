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
                                offsetCenter:[0,-90],
                                color:'#888',
                                fontWeight:'bold',
                                fontSize:20 
                                },
                            clockwise:true,
                            startAngle:180,
                            endAngle:0,
                            axisLine: {            // Coordinate axis
                                lineStyle: {       // Attribute lineStyle control line style
                                    width: 15,
                                    color: [[0.25, '#f4516c'], [0.75, '#ffb822'], [1, '#00c5dc']]
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
                            //name:'Business Indicators',
                            type:'gauge',
                            min:0,
                            max:4,
                            splitNumber: 4,
                            detail : {
                                offsetCenter:[0,30],
                                formatter:'{value}'
                                },
                            data:[{value: <?php echo $score_perusahaan; ?>, name: 'Score'}]
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
//
//    // Set paths
//    // ------------------------------
//
//    require.config({
//        paths: {
//           // echarts: '../../../app-assets/vendors/js/charts/echarts'
//            echarts: '<?php //echo base_url();?>assets/vendors/echarts'
//        }
//    });
//
//
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
                                value : [<?php  echo (isset($radar_perspective['Label']))? $radar_perspective['Value']:0; ?>],
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
                    orient: 'vertical', 
                    right: 10,
                    <?php
                        if(isset($chart_company['legend'])){
                        $legend="'".implode("','", $chart_company['legend'])."'";
                        echo "data: [".$legend."],";
                        }
                    ?>
                },

                // Add custom colors
                <?php
                    if(isset($chart_company['color'])){
                        $color="'".implode("','", $chart_company['color'])."'";
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
                        if(isset($chart_company['bulan'])){
                        $bulan="'".implode("','", $chart_company['bulan'])."'";
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
                    if(isset($chart_company['data_grafik'])){
                    foreach($chart_company['data_grafik'] as $key=>$val){
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
            var myChart = ec.init(document.getElementById('chart-line-perspective'));

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
 $(document).ready(function(){
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
    <?php
    if(isset($data_perspective))
    {
        $ListColor=['brand','accent','warning'];
        foreach($data_perspective->result() as $row)
        {
            if($row->gross_point<=1){
            //$Color=$ListColor[array_rand($ListColor,1)];
                $Color="danger";
            }else if($row->gross_point<=3){
                $Color="warning";
            }else if($row->gross_point>3){
                $Color="accent";
            }
    ?>
    var e = new Chartist.Pie("#m_chart_<?php echo $row->kd_perspective; ?>", {
                    series: [{
                        value: <?php echo $row->gross_point; ?>,
                        className: "<?php echo $row->nm_perspective; ?>",
                        meta: {
                            color: mApp.getColor("<?php echo $Color; ?>")
                        }
                    }, 
//                    {
//                        value: 1,
//                        className: "custom",
//                        meta: {
//                            color: mApp.getColor("accent")
//                        }
//                    }, {
//                        value: 1,
//                        className: "custom",
//                        meta: {
//                            color: mApp.getColor("warning")
//                        }
//                    }
                    ],
                    labels: [1, 2, 3]
                }, {
                    donut: !0,
                    donutWidth: 17,
                    total:4,
                    showLabel: !1
                }).on("draw", function(e) {
                    if ("slice" === e.type) {
                        var t = e.element._node.getTotalLength();
                        e.element.attr({
                            "stroke-dasharray": t + "px " + t + "px"
                        });
                        var a = {
                            "stroke-dashoffset": {
                                id: "anim" + e.index,
                                dur: 1e3,
                                from: -t + "px",
                                to: "0px",
                                easing: Chartist.Svg.Easing.easeOutQuint,
                                fill: "freeze",
                                stroke: e.meta.color
                            }
                        };
                        0 !== e.index && (a["stroke-dashoffset"].begin = "anim" + (e.index - 1) + ".end"), e.element.attr({
                            "stroke-dashoffset": -t + "px",
                            stroke: e.meta.color
                        }), e.element.animate(a, !1)
                    }
                });
    <?php
        }
    }
    ?>
 }); 
</script>