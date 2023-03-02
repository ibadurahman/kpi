<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData = $DataDepartemen->row();
?>
<div class="m-section__content " id="error_section"></div>

<div class="m-portlet m-portlet--full-height">

	<!--begin: Portlet Head-->
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					<?php echo $this->lang->line('input_header');?>
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
                                    <a href="<?php echo site_url("scorecards/DepartemenKpi/index/".$RowData->kd_departemen."/".$DataTahun."/".$DataBulan) ?>" class="btn btn-info m-btn  m-btn--custom m-btn--icon m-btn--air" id="button_delete" data-id="<?php echo $RowData->kd_departemen; ?>" data-id2="<?php echo $DataTahun; ?>">
                                                <span>
                                                        <i class="la la-arrow-left"></i>
                                                        <span><?php echo $this->lang->line('button_cancel');?></span>
                                                </span>
                                        </a>
                                </li>
			</ul>
		</div>
	</div>

	<!--end: Portlet Head-->

	<!--begin: Portlet Body-->
	<div class="m-portlet__body m-portlet__body--no-padding">

		<!--begin: Form Wizard-->
		<div class="m-wizard m-wizard--4 m-wizard--success" id="m_wizard">
			<div class="row m-row--no-padding">
				<div class="col-xl-3 col-lg-12 m--padding-top-20 m--padding-bottom-15">

					<!--begin: Form Wizard Head -->
					<div class="m-wizard__head">

						<!--begin: Form Wizard Nav -->
						<div class="m-wizard__nav">
							<div class="m-wizard__steps">
								<div class="m-wizard__step m-wizard__step--done" m-wizard-target="m_wizard_form_step_1">
									<div class="m-wizard__step-info">
										<a href="#" class="m-wizard__step-number">
											<span>
												<span>1</span>
											</span>
										</a>
										<div class="m-wizard__step-label">
											<?php echo $this->lang->line('wizard_menu1');?>
										</div>
										<div class="m-wizard__step-icon">
											<i class="la la-check"></i>
										</div>
									</div>
								</div>
								<div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
									<div class="m-wizard__step-info">
										<a href="#" class="m-wizard__step-number">
											<span>
												<span>2</span>
											</span>
										</a>
										<div class="m-wizard__step-label">
											<?php echo $this->lang->line('wizard_menu2');?>
										</div>
										<div class="m-wizard__step-icon">
											<i class="la la-check"></i>
										</div>
									</div>
								</div>
								<div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
									<div class="m-wizard__step-info">
										<a href="#" class="m-wizard__step-number">
											<span>
												<span>3</span>
											</span>
										</a>
										<div class="m-wizard__step-label">
											<?php echo $this->lang->line('wizard_menu3');?>
										</div>
										<div class="m-wizard__step-icon">
											<i class="la la-check"></i>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!--end: Form Wizard Nav -->
					</div>

					<!--end: Form Wizard Head -->
				</div>
				<div class="col-xl-9 col-lg-12">

					<!--begin: Form Wizard Form-->
					<div class="m-wizard__form">

						<!--
	1) Use m-form--label-align-left class to alight the form input lables to the right
	2) Use m-form--state class to highlight input control borders on form validation
-->
                                                
                                                <?php echo form_open('scorecards/DepartemenKpi/save/'.$RowData->kd_departemen.'/'.$Tahun,["class"=>"m-form m-form--label-align-left- m-form--state-","id"=>"m_form"]); ?>    
							<!--begin: Form Body -->
							<div class="m-portlet__body m-portlet__body--no-padding">

								<!--begin: Form Wizard Step 1-->
								<div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
									<div class="m-form__section m-form__section--first">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title"><?php echo $this->lang->line('departemenkpi_section1');?></h3>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_departemen'),'kd_departemen',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $RowData->kd_departemen; ?></span>
                                                                                                <?php echo form_input(array(
                                                                                                                               'name'          => 'kd_departemen',
                                                                                                                               'id'            => 'kd_departemen',
                                                                                                                               'value'         => $RowData->kd_departemen,
                                                                                                                               'type'          => 'hidden'
                                                                                                                       ),set_checkbox('kd_departemen'));
                                                                                                ?>
											</div>
										</div>
                                                                                <div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('nm_departemen'),'nm_departemen',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $RowData->nm_departemen; ?></span>
											</div>
										</div>
									</div>
									<div class="m-separator m-separator--dashed m-separator--lg"></div>
									<div class="m-form__section">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title">
												<?php echo $this->lang->line('departemenkpi_section2');?>
											</h3>
										</div>
                                                                                <div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('tahun'),'tahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $Tahun; ?></span>
                                                                                                <?php echo form_input(array(
                                                                                                                                                'name'          => 'tahun',
                                                                                                                                                'id'            => 'tahun',
                                                                                                                                                'value'         => $Tahun,
                                                                                                                                                'type'          => 'hidden'
                                                                                                                                        ),set_checkbox('tahun'));
                                                                                                                 ?>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('measurement_section1'),'measurement_section1');?>
                                                                                        <div class="m-section__content " id="alert_error_section"></div>
                                                                                        <table class="table table-bordered table-hover custom-table">
                                                                                            <thead>
                                                                                                    <tr>    
                                                                                                            <th></th>
                                                                                                            <th><b>#</b></th>
                                                                                                            <th width="100"><b><?php echo $this->lang->line('kd_measurement');?></b></th>
                                                                                                            <th><b><?php echo $this->lang->line('nm_measurement');?></b></th>
                                                                                                            <!--<th width="100"><b><?php //echo $this->lang->line('remaining_persentage')." (%)";?></b></th>-->
                                                                                                    </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php
                                                                                                $no=1;
                                                                                                $KdDBTemp="";
                                                                                                foreach($DataMeasurement->result() as $row)
                                                                                                {
                                                                                                    if($row->kd_bd!=$KdDBTemp){
                                                                                                        $KdDBTemp=$row->kd_bd;
                                                                                                ?>
                                                                                                <tr>
                                                                                                    <td colspan="5"><b><?php echo $row->nm_bd;?></b></td>
                                                                                                </tr>
                                                                                                <?php
                                                                                                    }
                                                                                                ?>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <?php echo form_checkbox(array(
                                                                                                                                                'name'          => 'kd_measurement'.$no,
                                                                                                                                                'id'            => 'kd_measurement'.$no,
                                                                                                                                                'value'         => $row->kd_measurement,
                                                                                                                                                'class'         => 'data_measurement'
                                                                                                                                        ),set_checkbox('kd_measurement'.$no));
                                                                                                                 ?>
                                                                                                        </td>
                                                                                                        <td scope="row"><?php echo $no; ?></td>
                                                                                                        <td><?php echo $row->kd_ms;?></td>
                                                                                                        <td><?php echo $row->nm_measurement;?></td>
<!--                                                                                                        <td>
                                                                                                            <?php 
                                                                                                                       /* $clsWeightage="m-badge--success";
                                                                                                                        if($row->remaining_pesen > 0){
                                                                                                                            $clsWeightage="m-badge--danger";
                                                                                                                        }
                                                                                                                        * 
                                                                                                                        */
                                                                                                            ?>
                                                                                                            <span class="m-badge <?php //echo $clsWeightage; ?> m-badge--wide"><?php //echo $row->remaining_pesen."%"; ?></span>
                                                                                                        </td>-->
                                                                                                    </tr>
                                                                                                <?php 
                                                                                                        $no++;
                                                                                                    }
                                                                                                ?>
                                                                                            </tbody>
                                                                                        </table>
										</div>
										
									</div>
								</div>

								<!--end: Form Wizard Step 1-->

								<!--begin: Form Wizard Step 2-->
								<div class="m-wizard__form-step" id="m_wizard_form_step_2">
                                                                        <div class="m-form__section m-form__section--first">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title"><?php echo $this->lang->line('departemenkpi_section1');?></h3>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_departemen'),'kd_departemen',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $RowData->kd_departemen; ?></span>
											</div>
										</div>
                                                                                <div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('nm_departemen'),'nm_departemen',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $RowData->nm_departemen; ?></span>
											</div>
										</div>
									</div>
									<div class="m-separator m-separator--dashed m-separator--lg"></div>
									<div class="m-form__section">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title"><?php echo $this->lang->line('measurement_section2');?></h3>
										</div>
                                                                            <div class="form-group m-form__group row" id="input-measurement"></div>
									</div>
									
								</div>

								<!--end: Form Wizard Step 2-->


								<!--begin: Form Wizard Step 3-->
								<div class="m-wizard__form-step" id="m_wizard_form_step_3">

									<!--begin::Section-->
									<div class="m-accordion m-accordion--default" id="m_accordion_1" role="tablist">

										<!--begin::Item-->
										<div class="m-accordion__item active">
											<div class="m-accordion__item-head" role="tab" id="m_accordion_1_item_1_head" data-toggle="collapse" href="#m_accordion_1_item_1_body" aria-expanded="  false">
												<span class="m-accordion__item-icon">
													<i class="fa fa-ruler"></i>
												</span>
												<span class="m-accordion__item-title">1. <?php echo $this->lang->line('measurement_section3');?></span>
												<span class="m-accordion__item-mode"></span>
											</div>
											<div class="m-accordion__item-body collapse show" id="m_accordion_1_item_1_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_1_head" data-parent="#m_accordion_1">
                                                                                            
												<!--begin::Content-->
												<div class="tab-content active  m--padding-30">
													<div class="m-form__section m-form__section--first">
                                                                                                                <div class="m-form__heading">
                                                                                                                        <h3 class="m-form__heading-title"><?php echo $this->lang->line('departemenkpi_section1');?></h3>
                                                                                                                </div>
                                                                                                                <div class="form-group m-form__group row">
                                                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_departemen'),'kd_departemen',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
                                                                                                                        <div class="col-xl-9 col-lg-9">
                                                                                                                                <span class="m-form__control-static"><?php echo $RowData->kd_departemen; ?></span>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                                <div class="form-group m-form__group row">
                                                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('nm_departemen'),'nm_departemen',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
                                                                                                                        <div class="col-xl-9 col-lg-9">
                                                                                                                                <span class="m-form__control-static"><?php echo $RowData->nm_departemen; ?></span>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
													<div class="m-separator m-separator--dashed m-separator--lg"></div>
													<div class="m-form__section">
                                                                                                            <div class="m-form__heading">
                                                                                                                <h3 class="m-form__heading-title">
                                                                                                                        <?php echo $this->lang->line('departemenkpi_section2');?>
                                                                                                                </h3>
                                                                                                            </div>
                                                                                                            <div class="form-group m-form__group row">
                                                                                                                    <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('tahun'),'tahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
                                                                                                                    <div class="col-xl-9 col-lg-9">
                                                                                                                            <span class="m-form__control-static"><?php echo $Tahun; ?></span>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="form-group m-form__group row view_weightage">
                                                                                                                    
                                                                                                            </div>
													</div>
                                                                                                        
												</div>

												<!--end::Section-->
											</div>
										</div>

										<!--end::Item-->


									</div>

									<!--end::Section-->

									<!--end::Section-->
								</div>

								<!--end: Form Wizard Step 4-->
							</div>

							<!--end: Form Body -->

							<!--begin: Form Actions -->
							<div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
								<div class="m-form__actions">
									<div class="row">
										<div class="col-lg-6 m--align-left">
											<a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
												<span>
													<i class="la la-arrow-left"></i>&nbsp;&nbsp;
													<span>Back</span>
												</span>
											</a>
										</div>
										<div class="col-lg-6 m--align-right">
											<a href="#" class="btn btn-success m-btn m-btn--custom m-btn--icon" data-wizard-action="submit">
												<span>
													<i class="la la-check"></i>&nbsp;&nbsp;
													<span>Submit</span>
												</span>
											</a>
											<a href="#" class="btn btn-success m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
												<span>
													<span>Save &amp; Continue</span>&nbsp;&nbsp;
													<i class="la la-arrow-right"></i>
												</span>
											</a>
										</div>
									</div>
								</div>
							</div>

							<!--end: Form Actions -->
                                                <?php echo form_close(); ?>
					</div>

					<!--end: Form Wizard Form-->
				</div>
			</div>
		</div>

		<!--end: Form Wizard-->
	</div>

	<!--end: Portlet Body-->
</div>