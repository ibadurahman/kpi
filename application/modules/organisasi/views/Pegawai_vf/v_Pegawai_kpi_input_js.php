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
                if(r.getStep()==3){
                    var data=[];
                    var no=0;
                    var type="";
                    var stat_cal="";
                    var target_input="";
                    var target_label="";
                    var statusErr=0;
                    $('.data_measurement').each(function () {
                        if (this.checked) {
                            data[no]=$(this).val();
                            type=$("#type"+data[no]).val();
                            stat_cal=$("#stat_cal"+data[no]).val();
                            target_input=$("#target_input"+data[no]).val();
                            target_label=$("#target_label"+data[no]).val();
                            // alert(type);
                            if(type=="" || stat_cal=="" || target_input=="" ||  target_label==""){
                                statusErr=1;
                            }
                            for($i=4;$i>0;$i--){
                                var formula_operator = $("#formula_operator"+$i+data[no]).val();
                                var formula_value = $("#formula_value"+$i+data[no]).val();
                                var formula_label = $("#formula_label"+$i+data[no]).val();
                                if(formula_operator=="" || formula_value=="" || formula_label==""){
                                    statusErr=1;
                                }
                            }
                            no++;
                        }
                        
                                
                     });
                    //  alert("Akhir"+statusErr);    
                     if(statusErr==1){
                        mUtil.scrollTop(), swal( {
                            title: "", text: "all fields are required", type: "error", confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
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
                     var nip=$('#nip').val();
                     $.ajax({
                        type: "POST",
                        data: {data:data},
                        url: "<?php echo site_url('organisasi/Pegawai/get_list_measurement/'); ?>"+nip+"/"+tahun,
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
                                if(total_persen>100){
                                    total_persen=100;
                                }else{
                                    total_persen=parseFloat(total_persen).toFixed(2); 
                                }
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
                                if(total_persen>100){
                                    total_persen=100;
                                }else{
                                    total_persen=parseFloat(total_persen).toFixed(2); 
                                }
                                $("#total_persen").html("<b>"+total_persen+"%</b>");
                                $("#total_kpi").val(total_persen);
                            });
                        }
                     });
                }else if(e.getStep()==3){
                    var data=[];
                    var no=0;
                    $('.data_measurement').each(function () {
                        if (this.checked) {
                            data[no]=$(this).val();
                            no++;
                        }
                                
                     });
                     var tahun=$('#tahun').val();
                     var nip=$('#nip').val();
                     $.ajax({
                        type: "POST",
                        data: {data:data},
                        url: "<?php echo site_url('organisasi/Pegawai/target_insert_form/'); ?>"+nip+"/"+tahun,
                        success: function(msg){
                          $('#input-target').html(msg);
                          //alert(msg);
                          
                        }
                     });
                }else if(e.getStep()==4){
                    var weightage_kpi = {};
                    var weightage_bd = {};
                    var kd_measurement = [];
                    var target=new Array(1);
                    no=1;
                    
                    
                    $('.weightage_kpi').each(function () {
                        var kd_measurement_temp = $("#kd_measurement3"+no).val();
                        var weightage_bd_temp = $("#weightage_bd"+no).val();
                        weightage_kpi[kd_measurement_temp]=$(this).val();
                        weightage_bd[kd_measurement_temp]=weightage_bd_temp;
                        kd_measurement[no]=kd_measurement_temp;
                        // alert(kd_measurement_temp);
                        // alert($("#type"+kd_measurement_temp).val());
                        
                        // target[kd_measurement_temp]['stat_cal']=$("#stat_cal"+kd_measurement_temp).val();
                        // target[kd_measurement_temp]['target_input']=$("#target_input"+kd_measurement_temp).val();
                        // target[kd_measurement_temp]['target_label']=$("#target_label"+kd_measurement_temp).val();
                        var i;
                        var formula=[];
                        for(i=4;i>0;i--){
                        //     target[kd_measurement_temp]['formula'][i]['formula_operator'] = $("#formula_operator"+i+kd_measurement_temp).val();
                        //     target[kd_measurement_temp]['formula'][i]['formula_value'] = $("#formula_value"+i+kd_measurement_temp).val();
                        //     target[kd_measurement_temp]['formula'][i]['formula_label'] = $("#formula_label"+i+kd_measurement_temp).val();
                        //     target[kd_measurement_temp]['formula'][i]['formula_score'] = $("#formula_score"+i+kd_measurement_temp).val();
                            formula[i]={
                                "formula_operator": $("#formula_operator"+i+kd_measurement_temp).val(),
                                "formula_value"   : $("#formula_value"+i+kd_measurement_temp).val(),
                                "formula_label"   : $("#formula_label"+i+kd_measurement_temp).val(),
                                "formula_score"   : $("#formula_score"+i+kd_measurement_temp).val(),
                            }

                        }
                        var data={
                            [kd_measurement_temp]:{
                                "data":{
                                    "type" : $("#type"+kd_measurement_temp).val(),
                                    "stat_cal" : $("#stat_cal"+kd_measurement_temp).val(),
                                    "target_input" : $("#target_input"+kd_measurement_temp).val(),
                                    "target_label" : $("#target_label"+kd_measurement_temp).val(),
                                    "formula" : formula,
                                }
                            }
                        }
                        target[no]=data;
                        //alert(kd_measurement_temp);
                            no++;
                        
                    });
                    console.log(target);

                    //alert(weightage_bd.toString())
                     var tahun=$('#tahun').val();
                     var bulan=$('#bulan').val();
                     var deskripsi=$('#deskripsi').val();
                     $("#view_bulan").html(get_nama_bulan(bulan));
                     $("#view_deskripsi").html(deskripsi);
                     var kd_departemen=$('#kd_departemen').val();
                     $.ajax({
                        type: "POST",
                        data: {weightage_kpi:weightage_kpi,weightage_bd:weightage_bd,kd_measurement:kd_measurement},
                        url: "<?php echo site_url('organisasi/Pegawai/get_list_measurement_view/'); ?>"+kd_departemen+"/"+tahun,
                        success: function(msg){
                          $('.view_weightage').html(msg);
                          //alert(msg);
                          
                        }
                     });
                     $.ajax({
                        type: "POST",
                        data: {target:JSON.stringify(target),kd_measurement:kd_measurement},
                        url: "<?php echo site_url('organisasi/Pegawai/get_list_target_view/'); ?>",
                        success: function(msg){
                          $('#m_form_confirm_2').html(msg);
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
                    },
                    bulan: {
                        required: !0
                    },
                    deskripsi: {
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
                                    window.location = '<?php echo site_url('organisasi/Pegawai/view_form/');?>'+response.kode;
                                }else{
                                    window.location = '<?php echo site_url('organisasi/Pegawai');?>';
                                }
                       }else{
                       var stat=1;
                       var errorText="";
                       $(window).scrollTop(0);
                        $.each(response.messages, function(key, value){
                           var element = $("#" + key);
                           //alert(key);
//                           if(key == 'tahun')
//                           {
                                if(key == 'kd_pk')
                                {
                                    stat=0;
                                    errorText=value;
//                                     var DataAlert='<div class="alert alert-danger alert-dismissible fade show" role="alert">\n\
//                                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>'+value+'</div>';
//
//                                     $("#error_section").html(DataAlert);
                                }
                               //stat=1;
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
                            if(errorText==""){
                                errorText="There are some errors in your submission. Please correct them.";
                            }
                            mApp.unprogress(n), swal( {
                                title: "", text: errorText, type: "error", confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
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