<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData=$DataTargetPegawai->row();
?>
<div class="m-section__content " id="error_section_modal"></div>
<div class="m-form__section m-form__section--first">
    <div class="m-form__heading">
            <h3 class="m-form__heading-title"><?php echo $this->lang->line('nm_measurement'); ?></h3>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4 m-form__group-sub  isi_input">
            <?php echo form_label($this->lang->line('kd_bd'),'kd_bd',['class'=>' col-form-label m--font-boldest']);?>
            <p class="form-control-static"><?php echo $RowData->nm_bd; ?></p>
            <div class="error"></div>
        </div>
        <div class="col-lg-4 m-form__group-sub  isi_input">
            <?php echo form_label($this->lang->line('kd_measurement'),'kd_measurement',['class'=>' col-form-label m--font-boldest']);?>
            <p class="form-control-static"><?php echo $RowData->kd_measurement; ?></p>
            <?php echo form_hidden("kd_measurement",$RowData->kd_measurement);?>
            <?php echo form_hidden("kd_pk",$RowData->kd_pk);?>
            <?php echo form_hidden("kd_departemen",$RowData->kd_departemen);?>
            <?php echo form_hidden("bulan",$RowData->bulan);?>
            <?php echo form_hidden("tahun",$RowData->tahun);?>
            <?php echo form_hidden("nip",$RowData->nip);?>
            <div class="error"></div>
        </div>
        <div class="col-lg-4 m-form__group-sub  isi_input">
            <?php echo form_label($this->lang->line('nm_measurement'),'nm_measurement',['class'=>' col-form-label m--font-boldest']);?>
            <p class="form-control-static"><?php echo $RowData->nm_measurement; ?></p>
            <div class="error"></div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4 m-form__group-sub  isi_input">
            <?php echo form_label($this->lang->line('type'),'type',['class'=>' col-form-label m--font-boldest']);?>
            <p class="form-control-static"><?php echo $ListType[$RowData->type]; ?></p>
            <?php echo form_hidden("type",$RowData->type);?>
            <div class="error"></div>
        </div>
        <div class="col-lg-4 m-form__group-sub  isi_input">
            <?php echo form_label($this->lang->line('unit'),'unit',['class'=>' col-form-label m--font-boldest']);?>
            <p class="form-control-static"><?php echo $ListUnit[$RowData->unit]; ?></p>
            <?php echo form_hidden("unit",$RowData->unit);?>
            <div class="error"></div>
        </div>
        <div class="col-lg-4 m-form__group-sub  isi_input">
            <?php echo form_label($this->lang->line('period_target'),'period_target',['class'=>' col-form-label m--font-boldest']);?>
            <p class="form-control-static"><?php echo $ListPeriodAll[$RowData->period]; ?></p>
            <?php echo form_hidden("period",$RowData->period);?>
            <div class="error"></div>
        </div>
    </div>
</div>
<div class="m-form__section">
	<div class="m-form__heading">
		<h3 class="m-form__heading-title">
			<?php echo $this->lang->line('section_target2');?>
		</h3>
	</div>
	<div class="form-group m-form__group row">
            <?php  
            foreach($DataTargetPegawai->result() as $row)
            {
                $thnSkrg=date("Y");
                $blnSkrg=date("m");
                
            ?>
            <div class="col-lg-3 m-form__group-sub  isi_input">
                <?php echo form_label(getNamaBulan($row->bulan_target),'bulan_'.$row->bulan_target,['class'=>' col-form-label m--font-boldest']);?>
                <?php 
                    if($RowData->tahun==$thnSkrg and $row->bulan_target<=$blnSkrg){
                        echo form_input(array(
                                            'name'          => 'bulan_'.$row->bulan_target,
                                            'id'            => 'bulan_'.$row->bulan_target,
                                            'class'         => 'form-control m-input',
                                            'placeholder'    => getNamaBulan($row->bulan_target),
                                            'type'          =>'number',
                                            'readonly'          =>true
                                    ),set_value('bulan_'.$row->bulan_target,$row->target));
                    }else{
                        echo form_input(array(
                            'name'          => 'bulan_'.$row->bulan_target,
                            'id'            => 'bulan_'.$row->bulan_target,
                            'class'         => 'form-control m-input',
                            'placeholder'    => getNamaBulan($row->bulan_target),
                            'type'          =>'number'
                        ),set_value('bulan_'.$row->bulan_target,$row->target));
                    }
                ?>
                <div class="error"></div>
            </div>
            <?php
            }
            ?>
            
	</div>
        
</div>