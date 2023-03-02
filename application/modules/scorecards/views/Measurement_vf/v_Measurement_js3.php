<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	

<script src="<?php echo base_url();?>assets/vendors/echarts/echarts.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
   $.validator.addMethod("validateBulanTahun", function(value, element)
    {
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
        var kd_measurement = $("#kd_measurement").val();

        // if(tahun==2020){
        //     return false
        // }else{
        //     return true
        // }
        var status=false;
        var data;
        $.ajax({
            type: "POST",
            data: {kd_measurement:kd_measurement,bulan:bulan,tahun:tahun},
            url: "<?php echo site_url('scorecards/Measurement/CekBulanTahunTarget'); ?>",
            dataType: 'json',
            async: false,
            success: function(msg){
                data=msg;
           },
            error: function(xhr, textStatus, errorThrown)
            {
                alert('ajax loading error... ... '+url + query);
                data={status:false};
            }
        });
        // console.log(data)
        return data.status;
    
    }, 'the efective month and year you selected is unavailable');
    
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
//                alert(r.getStep());
               
            }
            ),
            r.on("change", function(e) {
                mUtil.scrollTop()
            }
            ),
            r.on("change", function(e) {
                if(e.getStep()==2){
                    var target_setahun = parseInt($("#target_setahun").val());
                    var period = $("#period").val();
                    var type = $("#type").val();
                    var bulan = $("#bulan").val();
                    var tahun = $("#tahun").val();
                    var deskripsi = $("#deskripsi").val();
                    $(".target-content").html(target_setahun);
                    $(".deskripsi-content").html(deskripsi);
                    $(".tahun-content").html(tahun);
                    var dataTipe=[];
                    var dataBulan=[];
                    <?php
                      foreach(ListType() as $key=>$val){
                          echo 'dataTipe["'.$key.'"]="'.$val.'";';
                      }
                      foreach(ListBulan() as $key=>$val){
                          echo 'dataBulan["'.$key.'"]="'.$val.'";';
                      }
                      ?>
                    $(".bulan-content").html(dataBulan[bulan]);
                    $(".type-content").html(dataTipe[type]);
                    if(period=='m'){
                        $("#bulan_1").val(target_setahun);
                        $("#bulan_2").val(target_setahun);
                        $("#bulan_3").val(target_setahun);
                        $("#bulan_4").val(target_setahun);
                        $("#bulan_5").val(target_setahun);
                        $("#bulan_6").val(target_setahun);
                        $("#bulan_7").val(target_setahun);
                        $("#bulan_8").val(target_setahun);
                        $("#bulan_9").val(target_setahun);
                        $("#bulan_10").val(target_setahun);
                        $("#bulan_11").val(target_setahun);
                        $("#bulan_12").val(target_setahun);
                    }
                    else if(period=='y'){
                        var value=target_setahun/12;
                        $("#bulan_1").val(value);
                        $("#bulan_2").val(value);
                        $("#bulan_3").val(value);
                        $("#bulan_4").val(value);
                        $("#bulan_5").val(value);
                        $("#bulan_6").val(value);
                        $("#bulan_7").val(value);
                        $("#bulan_8").val(value);
                        $("#bulan_9").val(value);
                        $("#bulan_10").val(value);
                        $("#bulan_11").val(value);
                        $("#bulan_12").val(value);
                    }
                    else if(period=='q'){
                        var value=target_setahun/3;
                        $("#bulan_1").val(Math.round((value)*1));
                        $("#bulan_2").val(Math.round((value)*2));
                        $("#bulan_3").val(Math.round((value)*3));
                        $("#bulan_4").val(Math.round((value)*1));
                        $("#bulan_5").val(Math.round((value)*2));
                        $("#bulan_6").val(Math.round((value)*3));
                        $("#bulan_7").val(Math.round((value)*1));
                        $("#bulan_8").val(Math.round((value)*2));
                        $("#bulan_9").val(Math.round((value)*3));
                        $("#bulan_10").val(Math.round((value)*1));
                        $("#bulan_11").val(Math.round((value)*2));
                        $("#bulan_12").val(Math.round((value)*3));
                    }
                    else if(period=='ytd'){
                        var value=target_setahun/12;
                        $("#bulan_1").val(Math.round(value*1));
                        $("#bulan_2").val(Math.round(value*2));
                        $("#bulan_3").val(Math.round(value*3));
                        $("#bulan_4").val(Math.round(value*4));
                        $("#bulan_5").val(Math.round(value*5));
                        $("#bulan_6").val(Math.round(value*6));
                        $("#bulan_7").val(Math.round(value*7));
                        $("#bulan_8").val(Math.round(value*8));
                        $("#bulan_9").val(Math.round(value*9));
                        $("#bulan_10").val(Math.round(value*10));
                        $("#bulan_11").val(Math.round(value*11));
                        $("#bulan_12").val(Math.round(value*12));
                    }
                }else if(e.getStep()==3){
                    <?php 
                    for($i=1;$i<=12;$i++){
                        echo '$("#target-detail-'.$i.'").html($("#bulan_'.$i.'").val());';
                    }
                    ?>
                }
            }
            ),
            e=i.validate( {
                ignore:":hidden", rules: {
                    tahun: {
                        required: !0,
                        validateBulanTahun:true
                    }
                    , bulan: {
                        required: !0
                    }
                    , deskripsi: {
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
                                    window.location = '<?php echo site_url('scorecards/Measurement/index/');?>'+response.kode;
                                }else{
                                    window.location = '<?php echo site_url('scorecards/Measurement');?>';
                                }
                       }else{
                       var stat=0;
                        $.each(response.messages, function(key, value){
                           var element = $("#" + key);
                           //alert(key);
                           if(key == 'tahun')
                           {
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
                                mApp.unprogress(n), swal( {
                                    title: "", text: value, type: "error", confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                                }
                                )
                           }
                           
                           
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