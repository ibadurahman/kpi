<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<?php 
$RowData = $DataMeasurement->row();
  ?>
<div class="m-section__content " id="error_section"></div>

<div class="m-portlet m-portlet--full-height">

	<!--begin: Portlet Head-->
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					<?php echo $this->lang->line('input_target_header');?>
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
                                    <a href="<?php echo site_url("scorecards/Measurement/index/".$RowData->kd_measurement) ?>" class="btn btn-info m-btn  m-btn--custom m-btn--icon m-btn--air" >
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
                                                <?php echo form_open('scorecards/Measurement/target_save/'.$RowData->kd_measurement,["class"=>"m-form m-form--label-align-left- m-form--state-","id"=>"m_form"]); ?>    
							<!--begin: Form Body -->
							<div class="m-portlet__body m-portlet__body--no-padding">

								<!--begin: Form Wizard Step 1-->
								<div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
									<div class="m-form__section m-form__section--first">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title"><?php echo $this->lang->line('target_section1');?></h3>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_measurement'),'kd_measurement',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $RowData->kd_ms; ?></span>
                                                                                                <?php echo form_input(array(
                                                                                                                            'name'          => 'kd_measurement',
                                                                                                                            'id'            => 'kd_measurement',
                                                                                                                            'class'         => 'form-control m-input',
                                                                                                                            'placeholder'    => $this->lang->line('kd_measurement'),
                                                                                                                            'type'          =>'hidden'
                                                                                                                    ),set_value('kd_measurement',$RowData->kd_measurement));
                                                                                                ?>
											</div>
										</div>
                                                                                <div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('nm_measurement'),'nm_measurement',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $RowData->nm_measurement; ?></span>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_bd'),'kd_bd',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $RowData->nm_bd; ?></span>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('unit'),'unit',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $ListUnit[$RowData->unit]; ?></span>
                                                                                                <?php echo form_input(array(
                                                                                                                            'name'          => 'unit',
                                                                                                                            'id'            => 'unit',
                                                                                                                            'class'         => 'form-control m-input',
                                                                                                                            'placeholder'    => $this->lang->line('unit'),
                                                                                                                            'type'          =>'hidden'
                                                                                                                    ),set_value('unit',$RowData->unit));
                                                                                                ?>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('period'),'period',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $ListPeriodAll[$RowData->period]; ?></span>
                                                                                                <?php echo form_input(array(
                                                                                                                            'name'          => 'period',
                                                                                                                            'id'            => 'period',
                                                                                                                            'class'         => 'form-control m-input',
                                                                                                                            'placeholder'    => $this->lang->line('period'),
                                                                                                                            'type'          =>'hidden'
                                                                                                                    ),set_value('period',$RowData->period));
                                                                                                ?>
											</div>
										</div>
									</div>
									<div class="m-separator m-separator--dashed m-separator--lg"></div>
									<div class="m-form__section">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title">
												<?php echo $this->lang->line('target_section2');?>
											</h3>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('bulan'),'bulan',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<?php echo form_dropdown('bulan', 
                                                                                                                            $ListBulan, 
                                                                                                                            set_value('bulan'),
                                                                                                                            "id='bulan' style='width: 100%' class='select2 form-control m-select2' 
                                                                                                                            data-placeholder='".$this->lang->line('bulan')."'"); 

                                                                                                ?>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('tahun'),'tahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<?php echo form_dropdown('tahun', 
                                                                                                                            $ListTahun, 
                                                                                                                            set_value('tahun'),
                                                                                                                            "id='tahun' style='width: 100%' class='select2 form-control m-select2' 
                                                                                                                            data-placeholder='".$this->lang->line('tahun')."'"); 

                                                                                                ?>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('deskripsi'),'deskripsi',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<?php echo form_input(array(
                                                                                                                            'name'          => 'deskripsi',
                                                                                                                            'id'            => 'deskripsi',
                                                                                                                            'class'         => 'form-control m-input',
                                                                                                                            'placeholder'    => $this->lang->line('deskripsi')
                                                                                                                    ),set_value('deskripsi'));
                                                                                                ?>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('type'),'type',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<?php echo form_dropdown('type', 
                                                                                                                            $ListType, 
                                                                                                                            set_value('type'),
                                                                                                                            "id='type' style='width: 100%' class='select2 form-control m-select2' 
                                                                                                                            data-placeholder='".$this->lang->line('type')."'"); 

                                                                                                ?>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('target_setahun'),'target_setahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<?php echo form_input(array(
                                                                                                                            'name'          => 'target_setahun',
                                                                                                                            'id'            => 'target_setahun',
                                                                                                                            'class'         => 'form-control m-input',
                                                                                                                            'placeholder'    => $this->lang->line('target_setahun'),
                                                                                                                            'type'          =>'number'
                                                                                                                    ),set_value('target_setahun'));
                                                                                                ?>
											</div>
										</div>
									</div>
								</div>

								<!--end: Form Wizard Step 1-->

								<!--begin: Form Wizard Step 2-->
								<div class="m-wizard__form-step" id="m_wizard_form_step_2">
									<div class="m-form__section m-form__section--first">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title"><?php echo $this->lang->line('target_section1');?></h3>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_measurement'),'kd_measurement',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $RowData->kd_ms; ?></span>
											</div>
										</div>
                                                                                <div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('nm_measurement'),'nm_measurement',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $RowData->nm_measurement; ?></span>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_bd'),'kd_bd',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $RowData->nm_bd; ?></span>
											</div>
										</div>
									</div>
									<div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                                        <div class="m-form__section">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title"><?php echo $this->lang->line('target_section2');?></h3>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('bulan'),'bulan',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
                                                                                            <span class="m-form__control-static " ><span class="bulan-content"></span></span>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('tahun'),'tahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
                                                                                            <span class="m-form__control-static " ><span class="tahun-content"></span></span>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('deskripsi'),'deskripsi',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
                                                                                            <span class="m-form__control-static " ><span class="deskripsi-content"></span></span>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('type'),'type',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
                                                                                            <span class="m-form__control-static " ><span class="type-content"></span></span>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('unit'),'unit',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $ListUnit[$RowData->unit]; ?></span>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('period'),'period',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
												<span class="m-form__control-static"><?php echo $ListPeriodAll[$RowData->period]; ?></span>
											</div>
										</div>
										<div class="form-group m-form__group row">
                                                                                        <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('target_setahun'),'target_setahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
											<div class="col-xl-9 col-lg-9">
                                                                                            <span class="m-form__control-static " ><span class="target-content"></span>&nbsp;<?php echo $ListUnitSimbol[$RowData->unit]." / ".$ListPeriodAll[$RowData->period]; ?></span>
											</div>
										</div>
									</div>
									<div class="m-separator m-separator--dashed m-separator--lg"></div>
									<div class="m-form__section">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title">
												<?php echo $this->lang->line('target_section3');?>
											</h3>
										</div>
										<div class="form-group m-form__group row">
                                                                                    <div class="col-lg-6 m-form__group-sub">
                                                                                        <?php echo form_label(getNamaBulan(1),'bulan_1');?>
											<?php echo form_input(array(
                                                                                                                    'name'          => 'bulan_1',
                                                                                                                    'id'            => 'bulan_1',
                                                                                                                    'class'         => 'form-control m-input',
                                                                                                                    'placeholder'    => getNamaBulan(1),
                                                                                                                    'type'          =>'number'
                                                                                                            ),set_value('bulan_1'));
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="col-lg-6 m-form__group-sub">
                                                                                         <?php echo form_label(getNamaBulan(2),'bulan_2');?>
											<?php echo form_input(array(
                                                                                                                    'name'          => 'bulan_2',
                                                                                                                    'id'            => 'bulan_2',
                                                                                                                    'class'         => 'form-control m-input',
                                                                                                                    'placeholder'    => getNamaBulan(2),
                                                                                                                    'type'          =>'number'
                                                                                                            ),set_value('bulan_2'));
                                                                                        ?>
                                                                                    </div>
										</div>
                                                                                <div class="form-group m-form__group row">
                                                                                    <div class="col-lg-6 m-form__group-sub">
                                                                                        <?php echo form_label(getNamaBulan(3),'bulan_3');?>
											<?php echo form_input(array(
                                                                                                                    'name'          => 'bulan_3',
                                                                                                                    'id'            => 'bulan_3',
                                                                                                                    'class'         => 'form-control m-input',
                                                                                                                    'placeholder'    => getNamaBulan(3),
                                                                                                                    'type'          =>'number'
                                                                                                            ),set_value('bulan_3'));
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="col-lg-6 m-form__group-sub">
                                                                                         <?php echo form_label(getNamaBulan(4),'bulan_4');?>
											<?php echo form_input(array(
                                                                                                                    'name'          => 'bulan_4',
                                                                                                                    'id'            => 'bulan_4',
                                                                                                                    'class'         => 'form-control m-input',
                                                                                                                    'placeholder'    => getNamaBulan(4),
                                                                                                                    'type'          =>'number'
                                                                                                            ),set_value('bulan_4'));
                                                                                        ?>
                                                                                    </div>
										</div>
                                                                                <div class="form-group m-form__group row">
                                                                                    <div class="col-lg-6 m-form__group-sub">
                                                                                        <?php echo form_label(getNamaBulan(5),'bulan_5');?>
											<?php echo form_input(array(
                                                                                                                    'name'          => 'bulan_5',
                                                                                                                    'id'            => 'bulan_5',
                                                                                                                    'class'         => 'form-control m-input',
                                                                                                                    'placeholder'    => getNamaBulan(5),
                                                                                                                    'type'          =>'number'
                                                                                                            ),set_value('bulan_5'));
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="col-lg-6 m-form__group-sub">
                                                                                         <?php echo form_label(getNamaBulan(6),'bulan_6');?>
											<?php echo form_input(array(
                                                                                                                    'name'          => 'bulan_6',
                                                                                                                    'id'            => 'bulan_6',
                                                                                                                    'class'         => 'form-control m-input',
                                                                                                                    'placeholder'    => getNamaBulan(6),
                                                                                                                    'type'          =>'number'
                                                                                                            ),set_value('bulan_6'));
                                                                                        ?>
                                                                                    </div>
										</div>
                                                                                <div class="form-group m-form__group row">
                                                                                    <div class="col-lg-6 m-form__group-sub">
                                                                                        <?php echo form_label(getNamaBulan(7),'bulan_7');?>
											<?php echo form_input(array(
                                                                                                                    'name'          => 'bulan_7',
                                                                                                                    'id'            => 'bulan_7',
                                                                                                                    'class'         => 'form-control m-input',
                                                                                                                    'placeholder'    => getNamaBulan(7),
                                                                                                                    'type'          =>'number'
                                                                                                            ),set_value('bulan_7'));
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="col-lg-6 m-form__group-sub">
                                                                                         <?php echo form_label(getNamaBulan(8),'bulan_8');?>
											<?php echo form_input(array(
                                                                                                                    'name'          => 'bulan_8',
                                                                                                                    'id'            => 'bulan_8',
                                                                                                                    'class'         => 'form-control m-input',
                                                                                                                    'placeholder'    => getNamaBulan(8),
                                                                                                                    'type'          =>'number'
                                                                                                            ),set_value('bulan_8'));
                                                                                        ?>
                                                                                    </div>
										</div>
                                                                                <div class="form-group m-form__group row">
                                                                                    <div class="col-lg-6 m-form__group-sub">
                                                                                        <?php echo form_label(getNamaBulan(9),'bulan_9');?>
											<?php echo form_input(array(
                                                                                                                    'name'          => 'bulan_9',
                                                                                                                    'id'            => 'bulan_9',
                                                                                                                    'class'         => 'form-control m-input',
                                                                                                                    'placeholder'    => getNamaBulan(9),
                                                                                                                    'type'          =>'number'
                                                                                                            ),set_value('bulan_9'));
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="col-lg-6 m-form__group-sub">
                                                                                         <?php echo form_label(getNamaBulan(10),'bulan_10');?>
											<?php echo form_input(array(
                                                                                                                    'name'          => 'bulan_10',
                                                                                                                    'id'            => 'bulan_10',
                                                                                                                    'class'         => 'form-control m-input',
                                                                                                                    'placeholder'    => getNamaBulan(10),
                                                                                                                    'type'          =>'number'
                                                                                                            ),set_value('bulan_10'));
                                                                                        ?>
                                                                                    </div>
										</div>
                                                                                <div class="form-group m-form__group row">
                                                                                    <div class="col-lg-6 m-form__group-sub">
                                                                                        <?php echo form_label(getNamaBulan(11),'bulan_11');?>
											<?php echo form_input(array(
                                                                                                                    'name'          => 'bulan_11',
                                                                                                                    'id'            => 'bulan_11',
                                                                                                                    'class'         => 'form-control m-input',
                                                                                                                    'placeholder'    => getNamaBulan(11),
                                                                                                                    'type'          =>'number'
                                                                                                            ),set_value('bulan_11'));
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="col-lg-6 m-form__group-sub">
                                                                                         <?php echo form_label(getNamaBulan(12),'bulan_12');?>
											<?php echo form_input(array(
                                                                                                                    'name'          => 'bulan_12',
                                                                                                                    'id'            => 'bulan_12',
                                                                                                                    'class'         => 'form-control m-input',
                                                                                                                    'placeholder'    => getNamaBulan(12),
                                                                                                                    'type'          =>'number'
                                                                                                            ),set_value('bulan_12'));
                                                                                        ?>
                                                                                    </div>
										</div>
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
												<span class="m-accordion__item-title">1. <?php echo $this->lang->line('target_section4');?></span>
												<span class="m-accordion__item-mode"></span>
											</div>
											<div class="m-accordion__item-body collapse show" id="m_accordion_1_item_1_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_1_head" data-parent="#m_accordion_1">
                                                                                            
												<!--begin::Content-->
												<div class="tab-content active  m--padding-30">
													<div class="m-form__section m-form__section--first">
														<div class="m-form__heading">
															<h4 class="m-form__heading-title"><?php echo $this->lang->line('target_section1');?></h4>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
                                                                                                                        <?php echo form_label($this->lang->line('kd_measurement'),'kd_measurement',['class'=>"col-xl-4 col-lg-4 col-form-label"]);?>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static"><?php echo $RowData->kd_ms; ?></span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
                                                                                                                        <?php echo form_label($this->lang->line('nm_measurement'),'nm_measurement',['class'=>"col-xl-4 col-lg-4 col-form-label"]);?>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static"><?php echo $RowData->nm_measurement; ?></span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
                                                                                                                        <?php echo form_label($this->lang->line('kd_bd'),'kd_bd',['class'=>"col-xl-4 col-lg-4 col-form-label"]);?>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static"><?php echo $RowData->nm_bd; ?></span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
                                                                                                                        <?php echo form_label($this->lang->line('unit'),'unit',['class'=>"col-xl-4 col-lg-4 col-form-label"]);?>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static"><?php echo $ListUnit[$RowData->unit]; ?></span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
                                                                                                                        <?php echo form_label($this->lang->line('period'),'period',['class'=>"col-xl-4 col-lg-4 col-form-label"]);?>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static"><?php echo $ListPeriodAll[$RowData->period]; ?></span>
															</div>
														</div>
													</div>
													<div class="m-separator m-separator--dashed m-separator--lg"></div>
													<div class="m-form__section">
                                                                                                            <div class="m-form__heading">
                                                                                                                    <h4 class="m-form__heading-title"><?php echo $this->lang->line('target_section2');?></h4>
                                                                                                            </div>
                                                                                                            <div class="form-group m-form__group row">
                                                                                                                    <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('bulan'),'bulan',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
                                                                                                                    <div class="col-xl-9 col-lg-9">
                                                                                                                        <span class="m-form__control-static " ><span class="bulan-content"></span></span>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="form-group m-form__group row">
                                                                                                                    <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('tahun'),'tahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
                                                                                                                    <div class="col-xl-9 col-lg-9">
                                                                                                                        <span class="m-form__control-static " ><span class="tahun-content"></span></span>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="form-group m-form__group row">
                                                                                                                    <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('deskripsi'),'deskripsi',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
                                                                                                                    <div class="col-xl-9 col-lg-9">
                                                                                                                        <span class="m-form__control-static " ><span class="deskripsi-content"></span></span>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="form-group m-form__group row">
                                                                                                                    <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('type'),'type',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
                                                                                                                    <div class="col-xl-9 col-lg-9">
                                                                                                                        <span class="m-form__control-static " ><span class="type-content"></span></span>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                                                                    <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('target_setahun'),'target_setahun',['class'=>"col-xl-4 col-lg-4 col-form-label"]);?>
                                                                                                                    <div class="col-xl-8 col-lg-8">
                                                                                                                        <span class="m-form__control-static " ><span class="target-content"></span>&nbsp;<?php echo $ListUnitSimbol[$RowData->unit]." / ".$ListPeriodAll[$RowData->period]; ?></span>
                                                                                                                    </div>
                                                                                                            </div>
													</div>
												</div>

												<!--end::Section-->
											</div>
										</div>

										<!--end::Item-->

										<!--begin::Item-->
										<div class="m-accordion__item">
											<div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_2_head" data-toggle="collapse" href="#m_accordion_1_item_2_body" aria-expanded="    false">
												<span class="m-accordion__item-icon">
													<i class="fa  fa-bullseye"></i>
												</span>
												<span class="m-accordion__item-title">2. <?php echo $this->lang->line('target_section2');?></span>
												<span class="m-accordion__item-mode"></span>
											</div>
											<div class="m-accordion__item-body collapse" id="m_accordion_1_item_2_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_2_head" data-parent="#m_accordion_1">

												<!--begin::Content-->
												<div class="tab-content  m--padding-30">
													<div class="m-form__section m-form__section--first">
														<div class="m-form__heading">
															<h4 class="m-form__heading-title"><?php echo $this->lang->line('wizard_menu2');?></h4>
														</div>
                                                                                                            <?php 
                                                                                                            for($i=1;$i<=12;$i++)
                                                                                                            {
                                                                                                            ?>
                                                                                                            <div class="form-group m-form__group m-form__group--sm row">
                                                                                                                    <?php echo form_label(getNamaBulan($i),'target_setahun',['class'=>"col-xl-4 col-lg-4 col-form-label"]);?>
                                                                                                                    <div class="col-xl-8 col-lg-8">
                                                                                                                        <span class="m-form__control-static " ><span id="<?php echo "target-detail-".$i; ?>"></span>&nbsp;<?php echo $ListUnitSimbol[$RowData->unit]." / ".$ListPeriodAll[$RowData->period]; ?></span>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                            <?php
                                                                                                            }
                                                                                                            ?>
														
													</div>
												</div>

												<!--end::Content-->
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