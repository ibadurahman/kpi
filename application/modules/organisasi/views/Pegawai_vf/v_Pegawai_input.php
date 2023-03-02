<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="m-section__content " id="user_role_section">
    
        
</div>

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
                                            <a href="<?php echo site_url('organisasi/Pegawai'); ?>" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
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
                                <?php echo form_open_multipart('organisasi/Pegawai/save',["class"=>"-form m-form--label-align-right m-form--state-","id"=>"form_input"]);
                                            echo form_input(array(
                                                         'name'          => 'StatusSave',
                                                         'id'            => 'StatusSave',
                                                         'type'         =>'hidden'
                                                 ));
                                ?>

					<!--begin: Form Body -->
					<div class="m-portlet__body">
						<div class="row">
							<div class="col-md-7">
								<div class="m-form__section m-form__section--first">
                                                                        <div class="m-form__heading">
										<h3 class="m-form__heading-title"><?php echo $this->lang->line('header_section'); ?></h3>
									</div>
									<div class="form-group m-form__group">
                                                                                <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('nip'),'nip');?>
                                                                                     <?php echo form_input(array(
                                                                                                                'name'          => 'nip',
                                                                                                                'id'            => 'nip',
                                                                                                                'class'         => 'form-control m-input',
                                                                                                                'placeholder'    => $this->lang->line('nip')
                                                                                                        ),set_value('nip'));
                                                                                    ?>
                                                                            <div class="error"></div>
									</div>
									<div class="form-group m-form__group">
										<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('nama'),'nama');?>
                                                                                    <?php echo form_input(array(
                                                                                                                'name'          => 'nama',
                                                                                                                'id'            => 'nama',
                                                                                                                'class'         => 'form-control m-input',
                                                                                                                'placeholder'    => $this->lang->line('nama')
                                                                                                        ),set_value('nama'));
                                                                                    ?>
                                                                            <div class="error"></div>
									</div>
									<div class="form-group m-form__group">
                                                                            <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('tgl_masuk'),'tgl_masuk');?>
                                                                            <div class="input-group date">
                                                                                <?php echo form_input(array(
                                                                                                                'name'          => 'tgl_masuk',
                                                                                                                'id'            => 'tgl_masuk',
                                                                                                                'class'         => 'form-control m-input datepicker_custom',
                                                                                                                'placeholder'    => $this->lang->line('tgl_masuk')
                                                                                                        ),set_value('tgl_masuk'));
                                                                                    ?>
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar glyphicon-th"></i>
											</span>
										</div>
                                                                            </div>
                                                                            <div class="error"></div>
                                                                                    
									</div>
                                                                    
                                                                        <div class="form-group m-form__group">
                                                                            <?php echo form_label($this->lang->line('tgl_keluar'),'tgl_keluar');?>
                                                                            <div class="input-group date">
                                                                                <?php echo form_input(array(
                                                                                                                'name'          => 'tgl_keluar',
                                                                                                                'id'            => 'tgl_keluar',
                                                                                                                'class'         => 'form-control m-input datepicker_custom',
                                                                                                                'placeholder'    => $this->lang->line('tgl_keluar')
                                                                                                        ),set_value('tgl_keluar'));
                                                                                    ?>
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar glyphicon-th"></i>
											</span>
										</div>
                                                                            </div>
                                                                            <div class="error"></div>
                                                                                    
									</div>
                                                                        <div class="form-group m-form__group">
                                                                            <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('dob'),'dob');?>
                                                                            <div class="input-group date">
                                                                                <?php echo form_input(array(
                                                                                                                'name'          => 'dob',
                                                                                                                'id'            => 'dob',
                                                                                                                'class'         => 'form-control m-input datepicker_custom',
                                                                                                                'placeholder'    => $this->lang->line('dob')
                                                                                                        ),set_value('dob'));
                                                                                    ?>
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar glyphicon-th"></i>
											</span>
										</div>
                                                                            </div>
                                                                            <div class="error"></div>
                                                                                    
									</div>
                                                                        <div class="form-group m-form__group">
                                                                                <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_departemen'),'kd_departemen');?>
                                                                                <?php echo form_dropdown('kd_departemen', 
                                                                                                            $ListDepartemen, 
                                                                                                            set_value('kd_departemen'),
                                                                                                            "id='kd_departemen' style='width: 100%' class='select2 form-control m-select2' 
                                                                                                            data-placeholder='".$this->lang->line('kd_departemen')."'"); 

                                                                                ?>
                                                                            <div class="error"></div>
                                                                        </div>
                                                                        <div class="form-group m-form__group">
                                                                                <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_jabatan'),'kd_jabatan');?>
                                                                                <?php echo form_dropdown('kd_jabatan', 
                                                                                                            $ListJabatan, 
                                                                                                            set_value('kd_jabatan'),
                                                                                                            "id='kd_jabatan' style='width: 100%' class='select2 form-control m-select2' 
                                                                                                            data-placeholder='".$this->lang->line('kd_jabatan')."'"); 

                                                                                ?>
                                                                            <div class="error"></div>
                                                                        </div>
                                                                        <div class="form-group m-form__group">
                                                                                <?php echo form_label($this->lang->line('report_to'),'report_to');?>
                                                                                <?php echo form_dropdown('report_to', 
                                                                                                            $ListPegawai, 
                                                                                                            set_value('report_to'),
                                                                                                            "id='report_to' style='width: 100%' class='select2 form-control m-select2' 
                                                                                                            data-placeholder='".$this->lang->line('report_to')."'"); 

                                                                                ?>
                                                                            <div class="error"></div>
                                                                        </div>
                                                                        <div class="form-group m-form__group">
                                                                                <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('jenis_kelamin'),'jenis_kelamin');?>
										<div class="m-radio-inline">
											<label class="m-radio m-radio--solid">
                                                                                                <?php 
                                                                                                            echo form_radio(array(
                                                                                                                                'name'          => 'jenis_kelamin',
                                                                                                                                'id'            => 'jenis_kelamin',
                                                                                                                                'value'         => 'L'
                                                                                                                        ),'',set_radio('jenis_kelamin', 'L'));
                                                                                                            echo $ListKelamin['L'];
                                                                                                ?>
												<span></span>
											</label>
											<label class="m-radio m-radio--solid">
                                                                                                <?php 
                                                                                                            echo form_radio(array(
                                                                                                                                'name'          => 'jenis_kelamin',
                                                                                                                                'id'            => 'jenis_kelamin2',
                                                                                                                                'value'         => 'P'
                                                                                                                        ),'',set_radio('jenis_kelamin', 'P'));
                                                                                                            echo $ListKelamin['P'];
                                                                                                ?>
												<span></span>
											</label>
										</div>
                                                                            <div class="error"></div>
                                                                        </div>
								</div>
								<div class="m-separator m-separator--dashed m-separator--lg"></div>
								
								
							</div>
                                                    <div class="col-md-5">
                                                        <div class="m-form__section m-form__section--first">
                                                            <div class="form-group m-form__group">
                                                                    <?php echo form_label($this->lang->line('foto'),'foto');?>
                                                                    <?php echo form_upload(array(
                                                                                                'name'          => 'foto',
                                                                                                'id'            => 'foto',
                                                                                                'class'         => 'form-control m-input',
                                                                                                'placeholder'    => $this->lang->line('foto')
                                                                                        ),set_value('foto'));
                                                                    ?>
                                                                            <div class="error"></div>
                                                            </div>
                                                            <div class="form-group m-form__group m--margin-bottom-20">
                                                                    <div class="col-sm-12">
                                                                        <div id="image-holder"><img src="<?php echo base_url('assets/img/NoImage.png')?>" class="thumb-image" style="width: 150px; height: 150px;"/></div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
						</div>
					</div>
                                <?php echo form_close(); ?>
			</div>
		</div>

		<!--end::Portlet-->
	</div>
</div>