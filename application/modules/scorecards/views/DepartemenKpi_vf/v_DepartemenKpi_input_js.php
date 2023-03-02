<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script language="javascript" type="text/javascript">
   
   var WizardDemo=function() {
    $("#m_wizard");
    var e,
    r,
    i=$("#m_form");
    return {
        init:function() {
            var n;
            $("#m_wizard"),
            i=$("#m_form"),
            (r=new mWizard("m_wizard", {
                startStep: 1
            }
            )).on("beforeNext", function(r) {
                !0!==e.form()&&r.stop();
                var status = 0;
                if(r.getStep()==1){
                    $('.data_measurement').each(function () {
                                   if (this.checked) {
                                       status = 1;
                                       //alert($(this).val());
                                   }
                        });
                   if(status==0){
                        mUtil.scrollTop(), swal( {
                           title: "", text: "please select minimum 1 measurement", type: "error", confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                       }
                       );
                       r.stop();
                   }
                }
                if(r.getStep()==2){
                    var total_persen =$("#total_kpi").val();
                    if(total_persen!=100){
                        mUtil.scrollTop(), swal( {
                            title: "", text: "total weightage must be 100%", type: "error", confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                        }
                        );
                        r.stop();
                    }
                }
            }
            ),
            r.on("change", function(e) {
                mUtil.scrollTop()
            }
            ),
            r.on("change", function(e) {
                if(e.getStep()==2){
                    var data=[];
                    var no=0;
                    $('.data_measurement').each(function () {
                        if (this.checked) {
                            data[no]=$(this).val();
                            no++;
                        }
                                
                     });
                     var tahun=$('#tahun').val();
                     var kd_departemen=$('#kd_departemen').val();
                     $.ajax({
                        type: "POST",
                        data: {data:data},
                        url: "<?php echo site_url('scorecards/DepartemenKpi/get_list_measurement/'); ?>"+kd_departemen+"/"+tahun,
                        success: function(msg){
                          $('#input-measurement').html(msg);
                          //alert(msg);
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
                            total_persen = (total_persen>100)?100:total_persen;
                            $("#total_persen").html("<b>"+total_persen+"%</b>");
                            $("#total_kpi").val(total_persen);
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
                            total_persen = (total_persen>100)?100:total_persen;
                            $("#total_persen").html("<b>"+total_persen+"%</b>");
                            $("#total_kpi").val(total_persen);
                        });
                        }
                     });
                }else if(e.getStep()==3){
                    var weightage_kpi = {};
                    var weightage_bd = {};
                    var kd_measurement = [];
                    no=1;
                    $('.kd_measurement').each(function () {
                        //alert($(this).val());
                        var kd_measurement_temp = $(this).val();
                        var weightage_bd_temp = $("#weightage_bd"+no).val();
                        weightage_kpi[kd_measurement_temp]=$("#weightage_kpi"+no).val();
                        weightage_bd[kd_measurement_temp]=weightage_bd_temp;
                        kd_measurement[no]=kd_measurement_temp;
                        no++;
                        
                    });
                    // $('.weightage_kpi').each(function () {
                    //     var kd_measurement_temp = $("#kd_measurement2"+no).val();
                    //     var weightage_bd_temp = $("#weightage_bd"+no).val();
                    //     weightage_kpi[kd_measurement_temp]=$(this).val();
                    //     weightage_bd[kd_measurement_temp]=weightage_bd_temp;
                    //     kd_measurement[no]=kd_measurement_temp;
                    //         no++;
                        
                    // });
                    //alert(weightage_bd.toString())
                     var tahun=$('#tahun').val();
                     var kd_departemen=$('#kd_departemen').val();
                     $.ajax({
                        type: "POST",
                        data: {weightage_kpi:weightage_kpi,weightage_bd:weightage_bd,kd_measurement:kd_measurement},
                        url: "<?php echo site_url('scorecards/DepartemenKpi/get_list_measurement_view/'); ?>"+kd_departemen+"/"+tahun,
                        success: function(msg){
                          $('.view_weightage').html(msg);
                          //alert(msg);
                          
                        }
                     });
                }
            }
            ),
            e=i.validate( {
                ignore:":hidden", rules: {
                    tahun: {
                        required: !0
                    }
                    , target_setahun: {
                        required: !0
                    }
                }
                , invalidHandler:function(e, r) {
                    mUtil.scrollTop(), swal( {
                        title: "", text: "There are some errors in your submission. Please correct them.", type: "error", confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    }
                    )
                }
                , submitHandler:function(e) {}
            }
            ),
            (n=i.find('[data-wizard-action="submit"]')).on("click", function(r) {
                r.preventDefault();
                var me = $("#m_form");
                //alert(me.attr("action"));
                e.form()&&(mApp.progress(n), i.ajaxSubmit( {
                    url: me.attr("action"),
                    dataType:"json",
                    success:function(response) {
                        if(response.success == true){
                       
                                if('kode' in response){
                                    window.location = '<?php echo site_url('scorecards/DepartemenKpi/index/');?>'+response.kode+'<?php echo '/'.$DataTahun.'/'.$DataBulan; ?>';
                                }else{
                                    window.location = '<?php echo site_url('scorecards/DepartemenKpi');?>';
                                }
                       }else{
                       var stat=0;
                        $.each(response.messages, function(key, value){
                           var element = $("#" + key);
                           //alert(key);
//                           if(key == 'tahun')
//                           {
                               stat=1;
                               element.closest('div.form-group')
                                        .removeClass('has-danger')
                                        .addClass(value.length>0 ?'has-danger':'')
                                        .find(".text-error")
                                        .remove();
                                //element.after(value);
                                element.closest('div.form-group')
                                        .find(".error")
                                        .html(value);
//                                mApp.unprogress(n), swal( {
//                                    title: "", text: value, type: "error", confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
//                                }
//                                )
//                           }
                           
                           
                       });
                        if(stat==0){
                            mApp.unprogress(n), swal( {
                                title: "", text: "There are some errors in your submission. Please correct them.", type: "error", confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                            }
                            )
                        }
                       }
                    }
                }
                ))
            }
            )
        }
    }
}

();
    jQuery(document).ready(function() {
         WizardDemo.init();
         
    
});
</script>