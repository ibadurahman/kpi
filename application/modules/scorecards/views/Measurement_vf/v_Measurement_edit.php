<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData=$DataMeasurement->row();
?>
<div class="m-section__content " id="error_section"></div>

<div class="row">
	<div class="col-lg-12">

		<!--begin::Portlet-->
		<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
			<div class="m-portlet__head">
				<div class="m-portlet__head-progress">

					<!-- here can place a progress bar-->
				</div>
				<div class="m-portlet__head-wrapper">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
<!--							<span class="m-portlet__head-icon">
								<i class="flaticon-map-location"></i>
							</span>-->
							<h3 class="m-portlet__head-text">
								<?php echo isset($input_header)?$input_header:""; ?>
							</h3>
						</div>
					</div>
					<div class="m-portlet__head-tools">
                                            <a href="<?php echo site_url('scorecards/Measurement/index/'.$RowData->kd_measurement); ?>" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
							<span>
								<i class="la la-arrow-left"></i>
								<span>Back</span>
							</span>
						</a>
						<div class="btn-group">
							<button type="button" class="btn btn-success  m-btn m-btn--icon m-btn--wide m-btn--md tombol-save">
								<span>
									<i class="la la-check"></i>
									<span>Save</span>
								</span>
							</button>
							<button type="button" class="btn btn-success  dropdown-toggle dropdown-toggle-split m-btn m-btn--md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							</button>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item tombol-save2" href="#">
									<i class="la la-plus"></i> Save & New</a>
								<a class="dropdown-item tombol-save" href="#">
									<i class="la la-undo"></i> Save & Close</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
                                <?php echo form_open_multipart('scorecards/Measurement/edit/'.$RowData->kd_measurement,["class"=>"-form m-form--label-align-right m-form--state-","id"=>"form_input"]);
                                            echo form_input(array(
                                                         'name'          => 'StatusSave',
                                                         'id'            => 'StatusSave',
                                                         'type'         =>'hidden'
                                                 ));
                                ?>

					<!--begin: Form Body -->
					<div class="m-portlet__body">
						<div class="row">
							<div class="col-12">
								<div class="m-form__section m-form__section--first">
                                                                        <div class="m-form__heading">
										<h3 class="m-form__heading-title"><?php echo $this->lang->line('measurement_section1'); ?></h3>
									</div>
                                                                        <div class="form-group m-form__group row">
                                                                            <div class="col-md-12 m-form__group-sub">
                                                                                <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_bd'),'kd_bd');?>
                                                                                <?php echo form_dropdown('kd_bd', 
                                                                                                            $ListBusinessDriver, 
                                                                                                            set_value('kd_bd',$RowData->kd_bd),
                                                                                                            "id='kd_bd' style='width: 100%' class='select2 form-control m-select2' 
                                                                                                            data-placeholder='".$this->lang->line('kd_bd')."'"); 

                                                                                ?>
                                                                                <div class="error"></div>
                                                                            </div>
									</div>
									<div class="form-group m-form__group row">
<!--                                                                            <div class="col-md-6 m-form__group-sub">
                                                                                <?php //echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_measurement'),'kd_measurement');?>
                                                                                     <?php /*echo form_input(array(
                                                                                                                'name'          => 'kd_measurement_baru',
                                                                                                                'id'            => 'kd_measurement_baru',
                                                                                                                'class'         => 'form-control m-input',
                                                                                                                'placeholder'    => $this->lang->line('kd_measurement')
                                                                                                        ),set_value('kd_measurement_baru',$RowData->kd_ms));
                                                                                     echo form_hidden("kd_measurement",$RowData->kd_ms);
                                                                                      * 
                                                                                      */
                                                                                    ?>
                                                                                <div class="error"></div>
                                                                            </div>-->
                                                                            <div class="col-md-12 m-form__group-sub">
                                                                                <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('nm_measurement'),'nm_measurement');?>
                                                                                    <?php echo form_input(array(
                                                                                                                'name'          => 'nm_measurement',
                                                                                                                'id'            => 'nm_measurement',
                                                                                                                'class'         => 'form-control m-input',
                                                                                                                'placeholder'    => $this->lang->line('nm_measurement')
                                                                                                        ),set_value('nm_measurement',$RowData->nm_measurement));
                                                                                    ?>
                                                                                <div class="error"></div>
                                                                            </div>
									</div>
                                                                        
								</div>
								<!-- <div class="m-separator m-separator--dashed m-separator--lg"></div>
								<div class="m-form__section">
                                                                        <div class="m-form__heading">
										<h3 class="m-form__heading-title"><?php //echo $this->lang->line('measurement_section2'); ?></h3>
									</div>
									<div class="form-group m-form__group row">
                                                                            <div class="col-md-6 m-form__group-sub">
                                                                                <?php //echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('unit'),'unit');?>
                                                                                <?php 
                                                                                        // echo form_dropdown('unit', 
                                                                                        //                     $ListUnit, 
                                                                                        //                     set_value('unit',$RowData->unit),
                                                                                        //                     "id='unit' style='width: 100%' class='select2 form-control m-select2' 
                                                                                        //                     data-placeholder='".$this->lang->line('unit')."'"); 

                                                                                ?>
                                                                                <div class="error"></div>
                                                                            </div>
                                                                            <div class="col-md-6 m-form__group-sub">
                                                                                <?php //echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('period'),'period');?>
                                                                                <?php 
                                                                                        // echo form_dropdown('period', 
                                                                                        //                     $ListPeriodAll, 
                                                                                        //                     set_value('period',$RowData->period),
                                                                                        //                     "id='period' style='width: 100%' class='select2 form-control m-select2' 
                                                                                        //                     data-placeholder='".$this->lang->line('period')."'"); 

                                                                                ?>
                                                                                <div class="error"></div>
                                                                            </div>
									</div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-md-6 m-form__group-sub">
                                            <?php //echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('aggregation'),'aggregation');?>
                                            <?php 
                                                    // echo form_dropdown('aggregation', 
                                                    //                     $ListAggregation, 
                                                    //                     set_value('aggregation',$RowData->aggregation),
                                                    //                     "id='aggregation' style='width: 100%' class='select2 form-control m-select2' 
                                                    //                     data-placeholder='".$this->lang->line('aggregation')."'"); 

                                            ?>
                                            <div class="error"></div>
                                        </div>
									</div>
                                                                        
								</div> -->
								
							</div>
						</div>
					</div>
                                <?php echo form_close(); ?>
			</div>
		</div>

		<!--end::Portlet-->
	</div>
</div>