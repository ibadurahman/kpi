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
<?php
if(isset($pegawai_bar) and count($pegawai_bar)>0)
{
?>
    // Configuration
    // ------------------------------
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
            var myChart = ec.init(document.getElementById('chart-bar-pegawai'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    x: 40,
                    x2: 40,
                    y: 45,
                    y2: 25
                },

                // Add tooltip
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // Axis indicator axis trigger effective
                        type : 'shadow'        // The default is a straight line, optionally: 'line' | 'shadow'
                    }
                },

                // Add legend
                legend: {
                    <?php
                        if(isset($pegawai_bar['legend'])){
                        $legend="'".implode("','", $pegawai_bar['legend'])."'";
                        echo "data: [".$legend."],";
                        }
                    ?>
                    //data: [ 'Direct access', 'Email marketing', 'Advertising alliance', 'Video ads', 'Search engine', 'Google', 'Safari', 'Opera', 'Firefox']
                },
                
                // Add custom colors
                    <?php
                        if(isset($pegawai_bar['color'])){
                        $color="'".implode("','", $pegawai_bar['color'])."'";
                        echo "color: [".$color."],";
                        }
                    ?>        
               // color: ['#00B5B8', '#FFA87D', '#FF9966', '#FA8E57', '#FF637b', '#5175E0', '#A147F0', '#16D39A', '#BABFC7'],

                // Enable drag recalculate
                calculable: true,

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    <?php
                        if(isset($pegawai_bar['bulan'])){
                        $bulan="'".implode("','", $pegawai_bar['bulan'])."'";
                        echo "data: [".$bulan."]";
                        }
                    ?>
                    //data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                }],

                // Add series
                series : [
                    {
                        name:'<?php echo $pegawai_bar['legend']['L']; ?>',
                        type:'bar',
                        stack: 'gender',
                        <?php
                            if(isset($pegawai_bar['value']['L'])){
                            $value="'".implode("','", $pegawai_bar['value']['L'])."'";
                            echo "data: [".$value."]";
                            }
                        ?>
                        //data:[320, 332, 301, 334, 390, 330, 320]
                    },
                    {
                        name:'<?php echo $pegawai_bar['legend']['P']; ?>',
                        type:'bar',
                        stack: 'gender',
                        <?php
                            if(isset($pegawai_bar['value']['P'])){
                            $value="'".implode("','", $pegawai_bar['value']['P'])."'";
                            echo "data: [".$value."]";
                            }
                        ?>
                        //data:[320, 332, 301, 334, 390, 330, 320]
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
<?php
}
?>
<?php
if(isset($turnover_bar) and count($turnover_bar)>0)
{
?>
    // Configuration
    // ------------------------------
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
            var myChart = ec.init(document.getElementById('chart-bar-turnover'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    x: 40,
                    x2: 40,
                    y: 45,
                    y2: 25
                },

                // Add tooltip
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // Axis indicator axis trigger effective
                        type : 'shadow'        // The default is a straight line, optionally: 'line' | 'shadow'
                    }
                },

                // Add legend
                legend: {
                    <?php
                        if(isset($turnover_bar['legend'])){
                        $legend="'".implode("','", $turnover_bar['legend'])."'";
                        echo "data: [".$legend."],";
                        }
                    ?>
                    //data: [ 'Direct access', 'Email marketing', 'Advertising alliance', 'Video ads', 'Search engine', 'Google', 'Safari', 'Opera', 'Firefox']
                },
                
                // Add custom colors
                    <?php
                        if(isset($turnover_bar['color'])){
                        $color="'".implode("','", $turnover_bar['color'])."'";
                        echo "color: [".$color."],";
                        }
                    ?>        
               // color: ['#00B5B8', '#FFA87D', '#FF9966', '#FA8E57', '#FF637b', '#5175E0', '#A147F0', '#16D39A', '#BABFC7'],

                // Enable drag recalculate
                calculable: true,

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    <?php
                        if(isset($turnover_bar['bulan'])){
                        $bulan="'".implode("','", $turnover_bar['bulan'])."'";
                        echo "data: [".$bulan."]";
                        }
                    ?>
                    //data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                }],

                // Add series
                series : [
                    {
                        name:'<?php echo $turnover_bar['legend']['H']; ?>',
                        type:'bar',
                        stack: 'gender',
                        <?php
                            if(isset($turnover_bar['value']['L'])){
                            $value="'".implode("','", $turnover_bar['value']['H'])."'";
                            echo "data: [".$value."]";
                            }
                        ?>
                        //data:[320, 332, 301, 334, 390, 330, 320]
                    },
                    {
                        name:'<?php echo $turnover_bar['legend']['L']; ?>',
                        type:'bar',
                        stack: 'gender',
                        <?php
                            if(isset($turnover_bar['value']['L'])){
                            $value="'".implode("','", $turnover_bar['value']['L'])."'";
                            echo "data: [".$value."]";
                            }
                        ?>
                        //data:[320, 332, 301, 334, 390, 330, 320]
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
<?php
}
?>
<?php
if(isset($pegawai_kpi) and count($pegawai_kpi)>0)
{
?>
    // Configuration
    // ------------------------------
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
            var myChart = ec.init(document.getElementById('chart-bar-kpi'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    x: 150,
                    x2: 40,
                    y: 45,
                    y2: 25
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis'
                },


                // Add custom colors
                color: ['#00B5B8'],

                // Horizontal axis
                xAxis: [{
                    type: 'value',
                    boundaryGap: [0, 0.01]
                }],

                // Vertical axis
                yAxis: [{
                    type: 'category',
                    // data: ['Apple', 'Samsung', 'HTC', 'Nokia', 'Sony', 'LG']
                    <?php
                        if(isset($pegawai_kpi['category'])){
                        $category="'".implode("','", $pegawai_kpi['category'])."'";
                        echo "data: [".$category."]";
                        }
                    ?>
                }],

                // Add series
                series : [
                    {
                        name:'Score',
                        type:'bar',
                        // data:[600, 450, 350, 268, 474, 315]
                        <?php
                        if(isset($pegawai_kpi['value'])){
                        $value="'".implode("','", $pegawai_kpi['value'])."'";
                        echo "data: [".$value."]";
                        }
                    ?>
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
<?php
}
?>
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
    
    $("#kelompok_umur_pie").length&&Morris.Donut( {
                element:"kelompok_umur_pie", data:[ 
                <?php
                if(isset($kelompok_umur_pie) and count($kelompok_umur_pie)>0){
                    foreach ($kelompok_umur_pie as $val){
                        echo '{label:"'.$val['label'].'", value:'.$val['value'].'},';
                    }
                }
                ?>
                ], 
                labelColor:"#a7a7c2", 
                colors:[
                    <?php
                if(isset($kelompok_umur_pie) and count($kelompok_umur_pie)>0){
                    foreach ($kelompok_umur_pie as $val){
                        echo '"'.$val['color_code'].'",';
                    }
                }
                ?>
                ]
            }
    );
    $("#jml_peg_dept_pie").length&&Morris.Donut( {
                element:"jml_peg_dept_pie", data:[ 
                <?php
                if(isset($tot_peg_dept_pie) and count($tot_peg_dept_pie)>0){
                    foreach ($tot_peg_dept_pie as $val){
                        echo '{label:"'.$val['label'].'", value:'.$val['value'].'},';
                    }
                }
                ?>
                ], 
                labelColor:"#a7a7c2", 
                colors:[
                    <?php
                if(isset($tot_peg_dept_pie) and count($tot_peg_dept_pie)>0){
                    foreach ($tot_peg_dept_pie as $val){
                        echo '"'.$val['color_code'].'",';
                    }
                }
                ?>
                ]
            }
    );

                <?php
                if(count($gender_pie['detail'])>0){
                    $label="";
                    foreach ($gender_pie['detail'] as $val){
                        $label.="'".$val['label']."',";
                    }
                }
                ?>
    $("#jml_peg_pie").length&&new Chartist.Pie("#jml_peg_pie", {
                series:[ 
                <?php
                if(count($gender_pie['detail'])>0){
                    foreach ($gender_pie['detail'] as $val){
                ?>
                {
                    value:<?php echo $val['value'] ?>, className:"custom", meta: {
                        color: "<?php echo $val['color_code'] ?>"
                    }
                },             
                <?php
                    }
                }
                ?>
                ], 
                labels:[<?php echo $label ?>]
            }
            , {
                donut: !0, donutWidth: 17, showLabel: !1
            }
            ).on("draw", function(e) {
                if("slice"===e.type) {
                    var t=e.element._node.getTotalLength();
                    e.element.attr( {
                        "stroke-dasharray": t+"px "+t+"px"
                    }
                    );
                    var a= {
                        "stroke-dashoffset": {
                            id: "anim"+e.index, dur: 1e3, from: -t+"px", to: "0px", easing: Chartist.Svg.Easing.easeOutQuint, fill: "freeze", stroke: e.meta.color
                        }
                    }
                    ;
                    0!==e.index&&(a["stroke-dashoffset"].begin="anim"+(e.index-1)+".end"), e.element.attr( {
                        "stroke-dashoffset": -t+"px", stroke: e.meta.color
                    }
                    ), e.element.animate(a, !1)
                }
            }
            );
 }); 
</script>