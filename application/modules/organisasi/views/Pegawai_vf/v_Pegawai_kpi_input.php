<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData = $DataPegawai->row();
?>
<div class="m-section__content " id="error_section"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg" m-portlet="true">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('pegawaikpi_section1'); ?>
						</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
					<a href="<?php echo site_url("organisasi/Pegawai/view_form/".$RowData->nip."/".$DataTahun."/".$DataBulan) ?>" class="btn btn-accent m-btn  m-btn--custom m-btn--icon m-btn--air" >
						<span>
							<i class="la la-arrow-left"></i>
							<span><?php echo $this->lang->line('button_cancel');?></span>
						</span>
					</a>
		        </div>
            </div>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="m-form__section m-form__section--first">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo $this->lang->line('header_section'); ?></h3>
                            </div>
				            <div class="form-group m-form__group row">
                                <?php echo form_label($this->lang->line('nip'),'nip',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                <div class="col-7">
                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->nip; ?></span>
                                </div>
				            </div>
				            <div class="form-group m-form__group row">
                                <?php echo form_label($this->lang->line('nama'),'nama',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                <div class="col-7">
                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo ucwords(strtolower($RowData->nama)); ?></span>
                                </div>
				            </div>
                                
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="m-form__section m-form__section--first">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo $this->lang->line('header_section'); ?></h3>
                            </div>
				            <div class="form-group m-form__group row">
                                    <?php echo form_label($this->lang->line('kd_departemen'),'kd_departemen',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                   <div class="col-7">
                                       <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->nm_departemen; ?></span>
                                   </div>
                            </div>
                            <div class="form-group m-form__group row">
                                    <?php echo form_label($this->lang->line('kd_jabatan'),'kd_jabatan',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                   <div class="col-7">
                                       <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->nm_jabatan; ?></span>
                                   </div>
                            </div>
                        </div>
                    </div>
                </div>
                    
		    </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
		<div class="m-portlet m-portlet--full-height">

		<!--begin: Portlet Head-->
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						<?php echo $this->lang->line('input_kpi_header');?>
					</h3>
				</div>
			</div>
		</div>
		<div class="m-wizard m-wizard--2 m-wizard--success" id="m_wizard">

			<!--begin: Message container -->
			<div class="m-portlet__padding-x">

				<!-- Here you can put a message or alert -->
			</div>

			<!--end: Message container -->

			<!--begin: Form Wizard Head -->
			<div class="m-wizard__head m-portlet__padding-x">

				<!--begin: Form Wizard Progress -->
				<div class="m-wizard__progress">
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>

				<!--end: Form Wizard Progress -->

				<!--begin: Form Wizard Nav -->
				<div class="m-wizard__nav">
					<div class="m-wizard__steps">
						<div class="m-wizard__step m-wizard__step--current" m-wizard-target="m_wizard_form_step_1">
							<a href="#" class="m-wizard__step-number">
								<span>
									<i class="fa  flaticon-placeholder"></i>
								</span>
							</a>
							<div class="m-wizard__step-info">
								<div class="m-wizard__step-title">
									1. <?php echo $this->lang->line('wizard_menu1');?>
								</div>
								<!-- <div class="m-wizard__step-desc">
									Lorem ipsum doler amet elit
									<br> sed eiusmod tempors
								</div> -->
							</div>
						</div>
						<div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
							<a href="#" class="m-wizard__step-number">
								<span>
									<i class="fa  flaticon-layers"></i>
								</span>
							</a>
							<div class="m-wizard__step-info">
								<div class="m-wizard__step-title">
									2. <?php echo $this->lang->line('wizard_menu2');?>
								</div>
								<!-- <div class="m-wizard__step-desc">
									Lorem ipsum doler amet elit
									<br> sed eiusmod tempors
								</div> -->
							</div>
						</div>
						<div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
							<a href="#" class="m-wizard__step-number">
								<span>
									<i class="fa  flaticon-layers"></i>
								</span>
							</a>
							<div class="m-wizard__step-info">
								<div class="m-wizard__step-title">
									3. <?php echo $this->lang->line('wizard_menu3');?>
								</div>
								<!-- <div class="m-wizard__step-desc">
									Lorem ipsum doler amet elit
									<br> sed eiusmod tempors
								</div> -->
							</div>
						</div>
						<div class="m-wizard__step" m-wizard-target="m_wizard_form_step_4">
							<a href="#" class="m-wizard__step-number">
								<span>
									<i class="fa  flaticon-layers"></i>
								</span>
							</a>
							<div class="m-wizard__step-info">
								<div class="m-wizard__step-title">
									4. <?php echo $this->lang->line('wizard_menu4');?>
								</div>
								<!-- <div class="m-wizard__step-desc">
									Lorem ipsum doler amet elit
									<br> sed eiusmod tempors
								</div> -->
							</div>
						</div>
					</div>
				</div>

				<!--end: Form Wizard Nav -->
			</div>

			<!--end: Form Wizard Head -->

			<!--begin: Form Wizard Form-->
			<div class="m-wizard__form">
			<?php echo form_open('organisasi/Pegawai/pegawai_kpi_save/'.$RowData->nip.'/'.$Tahun,["class"=>"m-form m-form--label-align-left- m-form--state-","id"=>"m_form"]); ?>
				<!-- <form class="m-form m-form--label-align-left- m-form--state-" id="m_form"> -->

					<!--begin: Form Body -->
					<div class="m-portlet__body">

						<!--begin: Form Wizard Step 1-->
						<div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
							<div class="row">
								<div class="col-xl-8 offset-xl-2">
									<div class="m-form__section m-form__section--first">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title"><?php echo $this->lang->line('wizard_menu1_header1');?></h3>
										</div>
										<div class="form-group m-form__group row">
											<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('tahun_efektif'),'tahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<?php echo form_dropdown('tahun', 
															$ListTahun, 
															set_value('tahun'),
															"id='tahun' style='width: 100%' class='select2_non_clear form-control m-select2' 
															data-placeholder='".$this->lang->line('tahun_efektif')."'"); 

												?>
											</div>
										</div>
										<div class="form-group m-form__group row">
											<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('bulan_efektif'),'tahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<?php echo form_dropdown('bulan', 
																			$ListBulan, 
																			set_value('bulan'),
																			"id='bulan' style='width: 100%' class='select2 form-control m-select2' 
																			data-placeholder='".$this->lang->line('bulan_efektif')."'"); 

												?>
											</div>
										</div>
										<div class="form-group m-form__group row">
											<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('deskripsi'),'deskripsi',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<?php echo form_input(array(
																			'name'          => 'deskripsi',
																			'id'            => 'deskripsi',
																			'class'         => 'form-control m-input'
																	),set_checkbox('deskripsi'));

												?>
											</div>
										</div>
									</div>
									<div class="m-separator m-separator--dashed m-separator--lg"></div>
									<div class="m-form__section">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title">
												<?php echo $this->lang->line('wizard_menu1_header2');?>
												<!-- <i data-toggle="m-tooltip" data-width="auto" class="m-form__heading-help-icon flaticon-info" title="Some help text goes here"></i> -->
											</h3>
										</div>
										<div class="form-group m-form__group row">
											<?php //echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('measurement_section1'),'measurement_section1');?>
											<div class="m-section__content " id="alert_error_section"></div>
											<div class="table-responsive">
												<table class="table table-bordered table-hover custom-table">
													<thead>
															<tr>    
																	<th></th>
																	<th><b>#</b></th>
																	<th width="100"><b><?php echo $this->lang->line('kd_measurement');?></b></th>
																	<th><b><?php echo $this->lang->line('nm_measurement');?></b></th>
															</tr>
													</thead>
													<tbody>
														<?php
														$no=1;
														$KdDBTemp="";
														foreach($DataKPIDepartemen->result() as $row)
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
								</div>
							</div>
						</div>

						<!--end: Form Wizard Step 1-->

						<!--begin: Form Wizard Step 2-->
						<div class="m-wizard__form-step" id="m_wizard_form_step_2">
							<div class="row">
								<div class="col-xl-10 offset-xl-1">
									<div class="m-form__section m-form__section--first">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title"><?php echo $this->lang->line('wizard_menu2_header1');?></h3>
										</div>
										<div class="form-group m-form__group row" id="input-measurement"></div>
									</div>
								</div>
							</div>
						</div>

						<!--end: Form Wizard Step 2-->
						
						<!--begin: Form Wizard Step 3-->
						<div class="m-wizard__form-step" id="m_wizard_form_step_3">
							<div class="row">
								<div class="col-xl-12" id="input-target">
									
								</div>
							</div>
						</div>

						<!--end: Form Wizard Step 3-->

						<!--begin: Form Wizard Step 4-->
						<div class="m-wizard__form-step" id="m_wizard_form_step_4">
							<div class="row">
								<div class="col-xl-12">

									<ul class="nav nav-tabs m-tabs-line--2x m-tabs-line m-tabs-line--danger" role="tablist">
										<li class="nav-item m-tabs__item">
											<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_form_confirm_1" role="tab">1. <?php echo $this->lang->line('wizard_menu1');?></a>
										</li>
										<li class="nav-item m-tabs__item">
											<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_form_confirm_2" role="tab">2. <?php echo $this->lang->line('wizard_menu3');?></a>
										</li>
										<!-- <li class="nav-item m-tabs__item">
											<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_form_confirm_3" role="tab">3. Billing Setup</a>
										</li> -->
									</ul>
									<div class="tab-content m--margin-top-40">
										<div class="tab-pane active" id="m_form_confirm_1" role="tabpanel">
											<div class="m-form__section m-form__section--first">
												<div class="m-form__heading">
													<h4 class="m-form__heading-title"><?php echo $this->lang->line('wizard_menu1_header1');?></h4>
												</div>
												<div class="form-group m-form__group row">
														<?php echo form_label($this->lang->line('tahun_efektif'),'tahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
														<div class="col-xl-9 col-lg-9">
																<span class="m-form__control-static"><?php echo $Tahun; ?></span>
														</div>
												</div>
												<div class="form-group m-form__group row">
														<?php echo form_label($this->lang->line('bulan_efektif'),'bulan',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
														<div class="col-xl-9 col-lg-9">
															<span class="m-form__control-static" id="view_bulan"></span>
														</div>
												</div>
												<div class="form-group m-form__group row">
														<?php echo form_label($this->lang->line('deskripsi'),'deskripsi',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
														<div class="col-xl-9 col-lg-9">
															<span class="m-form__control-static" id="view_deskripsi"></span>
														</div>
												</div>
											</div>
											<div class="m-separator m-separator--dashed m-separator--lg"></div>
											<div class="m-form__section">
												<div class="m-form__heading">
													<h4 class="m-form__heading-title"><?php echo $this->lang->line('wizard_menu2_header1');?>
														<!-- <i data-toggle="m-tooltip" data-width="auto" class="m-form__heading-help-icon flaticon-info" title="Some help text goes here"></i> -->
													</h4>
												</div>
												<div class="form-group m-form__group row view_weightage">
																
												</div>
											</div>
										</div>
										<div class="tab-pane" id="m_form_confirm_2" role="tabpanel">
											
											
										</div>
										
									</div>
								</div>
							</div>
						</div>

						<!--end: Form Wizard Step 4-->
					</div>

					<!--end: Form Body -->

					<!--begin: Form Actions -->
					<div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
						<div class="m-form__actions">
							<div class="row">
								<div class="col-lg-2"></div>
								<div class="col-lg-4 m--align-left">
									<a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
										<span>
											<i class="la la-arrow-left"></i>&nbsp;&nbsp;
											<span>Back</span>
										</span>
									</a>
								</div>
								<div class="col-lg-4 m--align-right">
									<a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--icon" data-wizard-action="submit">
										<span>
											<i class="la la-check"></i>&nbsp;&nbsp;
											<span>Submit</span>
										</span>
									</a>
									<a href="#" class="btn btn-warning m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
										<span>
											<span>Save & Continue</span>&nbsp;&nbsp;
											<i class="la la-arrow-right"></i>
										</span>
									</a>
								</div>
								<div class="col-lg-2"></div>
							</div>
						</div>
					</div>

					<!--end: Form Actions -->
				<!-- </form> -->
				<?php echo form_close(); ?>
			</div>

								<!--end: Form Wizard Form-->
							</div>

							<!--end: Form Wizard-->
						</div>
		</div>
	</div>
</div>