<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="m-section__content " id="user_role_section"></div>

<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_1">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text" id="judul-form">
						<?php echo isset($input_header)?$input_header:""; ?>
					</h3>
				</div>
			</div>
		</div>
            <?php echo form_open_multipart('organisasi/PegawaiImport/save',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
		
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                        <?php echo form_label($this->lang->line('template'),'template',array("class"=>"col-xl-2 col-lg-2 col-form-label"));?>
			<div class="col-xl-7 col-lg-7">
                            <a href="<?php echo site_url('organisasi/PegawaiImport/Pegawai_Format_Import_Excel'); ?>" class="" style="padding-top: .85rem; display: inline-block">Download</a>
                               <div class="error"></div>
			</div>
		</div>
                <div class="form-group m-form__group row">
			<?php echo form_label($this->lang->line('file'),'file',['class'=>'col-xl-2 col-lg-2 col-form-label']);?>
			<div class="col-xl-7 col-lg-7">
                               <?php echo form_upload(array(
                                                       'name'          => 'file',
                                                       'id'            => 'file',
                                                       'class'         => 'form-control m-input',
                                                       'placeholder'    => $this->lang->line('file')
                                               ),set_value('file')); 
                               ?>
                            <span class="m-form__help">.csv</span>
                               <div class="error"></div>
			</div>
		</div>
		
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                    <div class="row">
                            <div class="col-lg-12 m--align-right">
                            <?php //if($this->mion_auth->is_allowed('edit_permission')){ ?>
                                <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('button_import');?></button>
                            <?php //} ?>
                                <!--<button type="button" class="btn btn-secondary" id="tombol-cancel"><?php //echo $this->lang->line('button_reset');?></button>-->
                            </div>
                    </div>
                </div>
            </div>
            
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="row" id="result">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_1">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text" id="judul-form">
						<?php echo $this->lang->line('result_header'); ?>
					</h3>
				</div>
			</div>
		</div>
		<?php echo form_open_multipart('',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
            <div class="m-portlet__body">
                <div class="form-group m-form__group row" >
                        <div class="col-xl-12">
                            <div class="alert alert-success" role="alert" id="result_sukses">
                                    <?php echo $this->lang->line('import_sukses'); ?>
                            </div>
			</div>
                        <div class="col-xl-12">
                            <div class="alert alert-danger" role="alert" id="result_gagal">
                                    <?php echo $this->lang->line('import_gagal'); ?>
                            </div>
			</div>
		</div>
                <div class="form-group m-form__group row">
                    <div class="col-xl-12" id="list_error">
                               
                    </div>
		</div>
		
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                    <div class="row">
                            <div class="col-lg-12 m--align-right">
                                <a href="<?php echo site_url("organisasi/PegawaiImport/index") ?>" class="btn btn-secondary m-btn  m-btn--custom m-btn--icon m-btn--air" >
                                        <span>
                                                <i class="la la-arrow-left"></i>
                                                <span><?php echo $this->lang->line('button_reset');?></span>
                                        </span>
                                </a>
                            </div>
                    </div>
                </div>
            </div>
            
            <?php echo form_close(); ?>
        </div>
    </div>
</div>