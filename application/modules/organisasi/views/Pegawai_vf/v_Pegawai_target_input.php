<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="m-section__content " id="error_section_modal"></div>
<?php
foreach($DataMeasurement->result() as $row)
{
    
?>
<div class="m-form__section m-form__section--first">
	<div class="m-form__heading">
		<h3 class="m-form__heading-title"><?php echo $row->nm_measurement;?></h3>
	</div>
    <div class="row">
        <div class="col-sm-5">
            <div class="m-portlet m-portlet--bordered m-portlet--bordered-semi m-portlet--rounded">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><?php echo $this->lang->line('wizard_menu3_header1'); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="form-group m-form__group">
                            <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('type'),'type'.$row->kd_measurement);?>
                            <?php echo form_dropdown('type'.$row->kd_measurement, 
                                                        $ListType, 
                                                        set_value('type'.$row->kd_measurement),
                                                        "id='type".$row->kd_measurement."' style='width: 100%' class='form-control m-input' 
                                                        data-placeholder='".$this->lang->line('type')."'"); 

                            ?>
                        <div class="error"></div>
                    </div>
                    <div class="form-group m-form__group">
                            <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('stat_cal'),'stat_cal'.$row->kd_measurement);?>
                            <?php echo form_dropdown('stat_cal'.$row->kd_measurement, 
                                                        $ListStatCalculate, 
                                                        set_value('stat_cal'.$row->kd_measurement),
                                                        "id='stat_cal".$row->kd_measurement."' style='width: 100%' class='form-control m-input' 
                                                        data-placeholder='".$this->lang->line('stat_cal')."'"); 

                            ?>
                        <div class="error"></div>
                    </div>
                    <div class="form-group m-form__group">
                            <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('target_input'),'target_input'.$row->kd_measurement);?>
                            <?php echo form_input(array(
                                                        'name'          => 'target_input'.$row->kd_measurement,
                                                        'id'            => 'target_input'.$row->kd_measurement,
                                                        'class'         => 'form-control m-input',
                                                        'type'          => 'numeric'
                                                ),set_value('target_input'.$row->kd_measurement));

                            ?>
                        <div class="error"></div>
                    </div>
                    <div class="form-group m-form__group">
                            <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('target_label'),'target_label'.$row->kd_measurement);?>
                            <?php echo form_input(array(
                                                        'name'          => 'target_label'.$row->kd_measurement,
                                                        'id'            => 'target_label'.$row->kd_measurement,
                                                        'class'         => 'form-control m-input'
                                                ),set_value('target_label'.$row->kd_measurement));

                            ?>
                        <div class="error"></div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-sm-7">
            <div class="m-portlet m-portlet--bordered m-portlet--bordered-semi m-portlet--rounded">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><?php echo $this->lang->line('wizard_menu3_header2'); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-section__content " id="alert_error_section"></div>
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
                                for($i=4;$i>0;$i--){
                                    if($i==4){
                                        $default=4;
                                    }else{
                                        $default=1;
                                    }
                                ?>
                                <tr>
                                    <td>
                                        <?php echo form_dropdown('formula_operator'.$i.$row->kd_measurement, 
                                                            $ListOperator, 
                                                            set_value('formula_operator'.$i.$row->kd_measurement,$default),
                                                            "id='formula_operator".$i.$row->kd_measurement."' style='width: 100%' class='form-control m-input' 
                                                            data-placeholder='".$this->lang->line('formula_operator')."'"); 

                                        ?>
                                    </td>               
                                    <td>
                                        <?php echo form_input(array(
                                                            'name'          => 'formula_value'.$i.$row->kd_measurement,
                                                            'id'            => 'formula_value'.$i.$row->kd_measurement,
                                                            'class'         => 'form-control m-input',
                                                            'type'          => 'numeric'
                                                    ),set_value('formula_value'.$i.$row->kd_measurement));

                                        ?>        
                                    </td>               
                                    <td>
                                        <?php echo form_input(array(
                                                            'name'          => 'formula_label'.$i.$row->kd_measurement,
                                                            'id'            => 'formula_label'.$i.$row->kd_measurement,
                                                            'class'         => 'form-control m-input'
                                                    ),set_value('formula_label'.$i.$row->kd_measurement));

                                        ?>        
                                    </td>            
                                    <td>
                                        <?php echo $i;?>            
                                        <?php echo form_input(array(
                                                            'name'          => 'formula_score'.$i.$row->kd_measurement,
                                                            'id'            => 'formula_score'.$i.$row->kd_measurement,
                                                            'type'         => 'hidden',
                                                    ),set_value('formula_score'.$i.$row->kd_measurement,$i));

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
        </div>
    </div>
</div>
<div class="m-separator m-separator--dashed m-separator--lg"></div>
<?php
}
?>