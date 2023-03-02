<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<!-- begin: alert error -->
<div class="m-section__content " id="alert_error">
    
        
</div>
<!-- end: alert error -->

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
                                            <a href="<?php echo site_url('akses/User'); ?>" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
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
                                <?php echo form_open_multipart('akses/User/save',["class"=>"-form m-form--label-align-right m-form--state-","id"=>"form_input"]);
                                            echo form_input(array(
                                                         'name'          => 'StatusSave',
                                                         'id'            => 'StatusSave',
                                                         'type'         =>'hidden'
                                                 ));
                                ?>

					<!--begin: Form Body -->
					<div class="m-portlet__body">
						<div class="row">
							<div class="col-xl-8 offset-xl-2">
								<div class="m-form__section m-form__section--first">
                                                                        <div class="m-form__heading">
										<h3 class="m-form__heading-title"><?php echo $this->lang->line('header_section'); ?></h3>
									</div>
									<div class="form-group m-form__group row">
                                                                                <?php echo form_label($this->lang->line('nip'),'nip',['class'=>'col-xl-3 col-lg-3 col-form-label']);?>
										<div class="col-xl-9 col-lg-9">
                                                                                     <?php echo form_dropdown('nip', 
                                                                                                            $ListPegawai, 
                                                                                                            set_value('nip'),
                                                                                                            "id='nip' style='width: 100%' class='select2-ajax form-control m-select2' 
                                                                                                            data-placeholder='".$this->lang->line('nip')."'"); 

                                                                                    ?>
                                                                                    <div class="error"></div>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('username'),'username',['class'=>'col-xl-3 col-lg-3 col-form-label']);?>
										<div class="col-xl-9 col-lg-9">
                                                                                    <?php echo form_input(array(
                                                                                                                'name'          => 'username',
                                                                                                                'id'            => 'username',
                                                                                                                'class'         => 'form-control m-input',
                                                                                                                'placeholder'    => $this->lang->line('username')
                                                                                                        ),set_value('username'));
                                                                                    ?>
                                                                                    <div class="error"></div>
										</div>
									</div>
                                                                        <div class="form-group m-form__group row">
										<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('password'),'password',['class'=>'col-xl-3 col-lg-3 col-form-label']);?>
										<div class="col-xl-9 col-lg-9">
                                                                                    <?php echo form_password(array(
                                                                                                                'name'          => 'password',
                                                                                                                'id'            => 'password',
                                                                                                                'class'         => 'form-control m-input',
                                                                                                                'placeholder'    => $this->lang->line('password')
                                                                                                        ),set_value('password'));
                                                                                    ?>
                                                                                    <div class="error"></div>
										</div>
									</div>
                                                                        <div class="form-group m-form__group row">
										<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('cpassword'),'cpassword',['class'=>'col-xl-3 col-lg-3 col-form-label']);?>
										<div class="col-xl-9 col-lg-9">
                                                                                    <?php echo form_password(array(
                                                                                                                'name'          => 'cpassword',
                                                                                                                'id'            => 'cpassword',
                                                                                                                'class'         => 'form-control m-input',
                                                                                                                'placeholder'    => $this->lang->line('cpassword')
                                                                                                        ),set_value('cpassword'));
                                                                                    ?>
                                                                                    <div class="error"></div>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('email'),'email',['class'=>'col-xl-3 col-lg-3 col-form-label']);?>
										<div class="col-xl-9 col-lg-9">
                                                                                    <?php echo form_input(array(
                                                                                                                'name'          => 'email',
                                                                                                                'id'            => 'email',
                                                                                                                'class'         => 'form-control m-input',
                                                                                                                'placeholder'    => $this->lang->line('email')
                                                                                                        ),set_value('email'));
                                                                                    ?>
                                                                                    <div class="error"></div>
										</div>
									</div>
                                                                        <div class="form-group m-form__group row">
                                                                                <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('group'),'group',['class'=>'col-xl-3 col-lg-3 col-form-label']);?>
										<div class="col-xl-9 col-lg-9">
                                                                                     <?php echo form_dropdown('group', 
                                                                                                            $ListGroup, 
                                                                                                            set_value('group'),
                                                                                                            "id='group' style='width: 100%' class='select2 form-control m-select2' 
                                                                                                            data-placeholder='".$this->lang->line('group')."'"); 

                                                                                    ?>
                                                                                    <div class="error"></div>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('first_name'),'first_name',['class'=>'col-xl-3 col-lg-3 col-form-label']);?>
										<div class="col-xl-9 col-lg-9">
                                                                                    <?php echo form_input(array(
                                                                                                                'name'          => 'first_name',
                                                                                                                'id'            => 'first_name',
                                                                                                                'class'         => 'form-control m-input',
                                                                                                                'placeholder'    => $this->lang->line('first_name')
                                                                                                        ),set_value('first_name'));
                                                                                    ?>
                                                                                    <div class="error"></div>
										</div>
									</div>
                                                                        <div class="form-group m-form__group row">
										<?php echo form_label($this->lang->line('company'),'company',['class'=>'col-xl-3 col-lg-3 col-form-label']);?>
										<div class="col-xl-9 col-lg-9">
                                                                                    <?php echo form_input(array(
                                                                                                                'name'          => 'company',
                                                                                                                'id'            => 'company',
                                                                                                                'class'         => 'form-control m-input',
                                                                                                                'placeholder'    => $this->lang->line('company')
                                                                                                        ),set_value('company'));
                                                                                    ?>
                                                                                    <div class="error"></div>
										</div>
									</div>
                                                                        <div class="form-group m-form__group row">
										<?php echo form_label($this->lang->line('image'),'foto',['class'=>'col-xl-3 col-lg-3 col-form-label']);?>
										<div class="col-xl-9 col-lg-9">
                                                                                    <?php echo form_upload(array(
                                                                                                            'name'          => 'foto',
                                                                                                            'id'            => 'foto',
                                                                                                            'class'         => 'form-control m-input',
                                                                                                            'placeholder'    => $this->lang->line('foto')
                                                                                                    ),set_value('foto'));
                                                                                    ?>
                                                                                    <div class="error"></div>
										</div>
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