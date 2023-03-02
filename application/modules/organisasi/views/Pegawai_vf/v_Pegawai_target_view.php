<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData=$DataTargetPegawai->row();
?>
<div class="m-section__content " id="error_section_modal"></div>
<div class="m-form__section m-form__section--first">
    <div class="m-form__heading">
            <h3 class="m-form__heading-title"><?php echo $this->lang->line('section_target2'); ?></h3>
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
            <?php echo form_hidden("kd_pkd",$RowData->kd_pkd);?>
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
            <?php echo form_label($this->lang->line('target_label'),'target_label',['class'=>' col-form-label m--font-boldest']);?>
            <p class="form-control-static"><?php echo$RowData->target_label; ?></p>
            <div class="error"></div>
        </div>
        <div class="col-lg-4 m-form__group-sub  isi_input">
            <?php echo form_label($this->lang->line('type'),'type',['class'=>' col-form-label m--font-boldest']);?>
            <p class="form-control-static"><?php echo $ListType[$RowData->tipe_target]; ?></p>
            <div class="error"></div>
        </div>
        <div class="col-lg-4 m-form__group-sub  isi_input">
            <?php echo form_label($this->lang->line('stat_cal'),'stat_cal',['class'=>' col-form-label m--font-boldest']);?>
            <p class="form-control-static"><?php echo $ListStatCalculate[$RowData->status_calculate]; ?></p>
            <div class="error"></div>
        </div>
    </div>
</div>
<div class="m-form__section">
	<div class="m-form__heading">
		<h3 class="m-form__heading-title">
			<?php echo $this->lang->line('formula');?>
		</h3>
	</div>
	<div class="form-group m-form__group row">
        <div class="table-responsive">
            <table class="table table-bordered table-hover custom-table">
                <thead>
                    <tr>    
                        <th width="100"><?php echo $this->lang->line('formula_operator');?></th>
                        <th><?php echo $this->lang->line('formula_value');?></th>
                        <th><?php echo $this->lang->line('formula_label');?></th>
                        <th><?php echo $this->lang->line('formula_score');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $formula=json_decode($RowData->formula,true);
                    krsort($formula);
                    foreach($formula as $row){
                    ?>
                    <tr>
                        <td>
                            <?php echo $ListOperator[$row['operator']]; ?>
                        </td>               
                        <td>
                            <?php echo $row['value']; ?>
                        </td>               
                        <td>
                            <?php echo $row['label']; ?>       
                        </td>            
                        <td>
                            <?php echo $row['score']; ?>          
                        </td>               
                    </tr>
                    <?php
                    }
                    ?>
                
                </tbody>
            </table>
        </div>
            
	</div>
        
</div>