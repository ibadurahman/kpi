<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
foreach($DataMeasurement->result() as $row)
{
?>
<div class="m-form__section m-form__section--first">
	<div class="m-form__heading">
		<h4 class="m-form__heading-title"><?php echo $row->nm_measurement;?></h4>
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
                    <div class="form-group m-form__group m-form__group--sm row">
                        <label class="col-xl-3 col-lg-3 col-form-label"><?php echo $this->lang->line('type'); ?>:</label>
                        <div class="col-xl-9 col-lg-9">
                            <span class="m-form__control-static"><?php echo $ListType[$target[$row->kd_measurement]['type']]; ?></span>
                        </div>
                    </div>
                    <div class="form-group m-form__group m-form__group--sm row">
                        <label class="col-xl-3 col-lg-3 col-form-label"><?php echo $this->lang->line('stat_cal'); ?>:</label>
                        <div class="col-xl-9 col-lg-9">
                            <span class="m-form__control-static"><?php echo $ListStatCalculate[$target[$row->kd_measurement]['stat_cal']]; ?></span>
                        </div>
                    </div>
                    <div class="form-group m-form__group m-form__group--sm row">
                        <label class="col-xl-3 col-lg-3 col-form-label"><?php echo $this->lang->line('target_input'); ?>:</label>
                        <div class="col-xl-9 col-lg-9">
                            <span class="m-form__control-static"><?php echo $target[$row->kd_measurement]['target_input']; ?></span>
                        </div>
                    </div>
                    <div class="form-group m-form__group m-form__group--sm row">
                        <label class="col-xl-3 col-lg-3 col-form-label"><?php echo $this->lang->line('target_label'); ?>:</label>
                        <div class="col-xl-9 col-lg-9">
                            <span class="m-form__control-static"><?php echo $target[$row->kd_measurement]['target_label']; ?></span>
                        </div>
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
                                        <?php echo $ListOperator[$target[$row->kd_measurement]['formula'][$i]['formula_operator']]; ?>
                                    </td>               
                                    <td>
                                        <?php echo $target[$row->kd_measurement]['formula'][$i]['formula_value']; ?>
                                    </td>               
                                    <td>
                                        <?php echo $target[$row->kd_measurement]['formula'][$i]['formula_label']; ?>       
                                    </td>            
                                    <td>
                                        <?php echo $target[$row->kd_measurement]['formula'][$i]['formula_score']; ?>            
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