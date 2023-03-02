<?php 
$RowData = $DataMeasurementTarget->row();
        
?>
<div class="m-form__heading">
	<h4 class="m-form__heading-title"><?php echo $this->lang->line('target_data')." ".$RowData->nm_measurement." (".$RowData->kd_ms.")"; ?></h4>
</div>
<div class="form-group m-form__group m--margin-top-20 row">
    <div class="col-md-6">
	<?php echo form_label($this->lang->line('bulan'),'bulan',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo getNamaBulan($RowData->bulan); ?></p>
    </div>
    <div class="col-md-6">
	<?php echo form_label($this->lang->line('tahun'),'tahun',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->tahun; ?></p>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6">
	<?php echo form_label($this->lang->line('deskripsi'),'deskripsi',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->deskripsi; ?></p>
    </div>
    <div class="col-md-6">
	<?php echo form_label($this->lang->line('type'),'type',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $ListType[$RowData->type]; ?></p>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6">
	<?php echo form_label($this->lang->line('unit'),'unit',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $ListUnit[$RowData->unit]; ?></p>
    </div>
    <div class="col-md-6">
	<?php echo form_label($this->lang->line('period'),'period',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $ListPeriodAll[$RowData->period]; ?></p>
    </div>
</div>
<div class="m-form__heading">
	<h4 class="m-form__heading-title"><?php echo $this->lang->line('target_setahun')." ".$RowData->nm_measurement." (".$RowData->kd_ms.")"; ?></h4>
</div>
<div class="row">
    <div class="col-md-6">
        <?php
        $TotalData=$DataMeasurementTarget->num_rows();
        $Data=$DataMeasurementTarget->result_array();
        for($i=0;$i<$TotalData;$i++){
        ?>
            <?php
            if(($i % 2) ==0){
            ?>
        <div class="form-group m-form__group row">
            <?php echo form_label(getNamaBulan($Data[$i]['bulan_target']),'bulan'.$Data[$i]['bulan_target'],array("class"=>"col-4 col-form-label m--font-boldest txt_align_right"));?>
           <div class="col-8">
               <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $Data[$i]['target']." ".$ListUnitSimbol[$Data[$i]['unit']]; ?></span>
           </div>
        </div>
            <?php
            }
            ?>
        <?php
        }
        ?>
    </div>
    <div class="col-md-6">
        <?php
        for($i=0;$i<$TotalData;$i++){
        ?>
            <?php
            if(($i % 2) ==1){
            ?>
        <div class="form-group m-form__group row">
            <?php echo form_label(getNamaBulan($Data[$i]['bulan_target']),'bulan'.$Data[$i]['bulan_target'],array("class"=>"col-4 col-form-label m--font-boldest txt_align_right"));?>
           <div class="col-8">
               <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $Data[$i]['target']." ".$ListUnitSimbol[$Data[$i]['unit']]; ?></span>
           </div>
        </div>
            <?php
            }
            ?>
        <?php
        }
        ?>
    </div>
</div>