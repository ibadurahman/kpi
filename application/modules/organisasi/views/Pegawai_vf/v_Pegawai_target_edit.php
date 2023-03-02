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
        <div class="col-lg-6 m-form__group-sub  isi_input">
            <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('type'),'type');?>
            <?php echo form_dropdown('type', 
                                        $ListType, 
                                        set_value('type',$RowData->tipe_target),
                                        "id='type' style='width: 100%' class='form-control m-input' 
                                        data-placeholder='".$this->lang->line('type')."'"); 

            ?>
            <div class="error"></div>
        </div>
        <div class="col-lg-6 m-form__group-sub  isi_input">
            <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('stat_cal'),'stat_cal');?>
            <?php echo form_dropdown('stat_cal', 
                                        $ListStatCalculate, 
                                        set_value('stat_cal',$RowData->status_calculate),
                                        "id='stat_cal' style='width: 100%' class='form-control m-input' 
                                        data-placeholder='".$this->lang->line('stat_cal')."'"); 

            ?>
            <div class="error"></div>
        </div>
        <div class="col-lg-6 m-form__group-sub  isi_input">
            <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('target_input'),'target_input');?>
            <?php echo form_input(array(
                                        'name'          => 'target_input',
                                        'id'            => 'target_input',
                                        'class'         => 'form-control m-input',
                                        'type'          => 'number',
                                        'step'          => 'any'
                                ),set_value('target_input',$RowData->target));

            ?>
            <div class="error"></div>
        </div>
        <div class="col-lg-6 m-form__group-sub  isi_input">
            <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('target_label'),'target_label');?>
            <?php echo form_input(array(
                                        'name'          => 'target_label',
                                        'id'            => 'target_label',
                                        'class'         => 'form-control m-input'
                                ),set_value('target_label',$RowData->target_label));

            ?>
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
                    $i=1;
                    krsort($formula);
                    foreach($formula as $row){
                    ?>
                    <tr>
                        <td>
                            <?php echo form_dropdown('formula_operator'.$row['score'], 
                                                $ListOperator, 
                                                set_value('formula_operator'.$row['score'],$row['operator']),
                                                "id='formula_operator".$row['score']."' style='width: 100%' class='form-control m-input' 
                                                data-placeholder='".$this->lang->line('formula_operator')."'"); 

                            ?>
                        </td>               
                        <td>
                            <?php echo form_input(array(
                                                'name'          => 'formula_value'.$row['score'],
                                                'id'            => 'formula_value'.$row['score'],
                                                'class'         => 'form-control m-input',
                                                'type'          => 'number',
                                                'step'          => 'any'
                                        ),set_value('formula_value'.$row['score'],$row['value']));

                            ?>        
                        </td>               
                        <td>
                            <?php echo form_input(array(
                                                'name'          => 'formula_label'.$row['score'],
                                                'id'            => 'formula_label'.$row['score'],
                                                'class'         => 'form-control m-input'
                                        ),set_value('formula_label'.$row['score'],$row['label']));

                            ?>        
                        </td>            
                        <td>
                            <?php echo $row['score'];?>            
                            <?php echo form_input(array(
                                                'name'          => 'formula_score'.$row['score'],
                                                'id'            => 'formula_score'.$row['score'],
                                                'type'         => 'hidden',
                                        ),set_value('formula_score'.$row['score'],$row['score']));

                            ?>             
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