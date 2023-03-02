<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
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
            <?php echo form_open('report/ReportPegawai/search',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
		
		<div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                <?php echo form_label($this->lang->line('keyword'),'keyword');?>
                                <?php echo form_input(array(
                                                            'name'          => 'keyword',
                                                            'id'            => 'keyword',
                                                            'class'         => 'form-control m-input',
                                                            'placeholder'    => $this->lang->line('keyword')
                                                    ),set_value('keyword'));
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                    <?php echo form_label($this->lang->line('kd_departemen'),'kd_departemen');?>
                                    <?php echo form_dropdown('kd_departemen', 
                                                                $ListDepartemen, 
                                                                set_value('kd_departemen'),
                                                                "id='kd_departemen' style='width: 100%' class='select2 form-control m-select2' 
                                                                data-placeholder='".$this->lang->line('kd_departemen')."'"); 

                                    ?>
                                <div class="error"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                    <?php echo form_label($this->lang->line('kd_jabatan'),'kd_jabatan');?>
                                    <?php echo form_dropdown('kd_jabatan', 
                                                                $ListJabatan, 
                                                                set_value('kd_jabatan'),
                                                                "id='kd_jabatan' style='width: 100%' class='select2 form-control m-select2' 
                                                                data-placeholder='".$this->lang->line('kd_jabatan')."'"); 

                                    ?>
                                <div class="error"></div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                    <?php echo form_label($this->lang->line('jenis_kelamin'),'jenis_kelamin');?>
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
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                <?php echo form_label($this->lang->line('tgl_masuk'),'tgl_masuk');?>
                                <?php echo form_input(array(
                                                            'name'          => 'tgl_masuk',
                                                            'id'            => 'tgl_masuk',
                                                            'class'         => 'form-control m-input daterangecustom'
                                                    ),set_value('tgl_masuk'));
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                <?php echo form_label($this->lang->line('tgl_keluar'),'tgl_keluar');?>
                                <?php echo form_input(array(
                                                            'name'          => 'tgl_keluar',
                                                            'id'            => 'tgl_keluar',
                                                            'class'         => 'form-control m-input daterangecustom'
                                                    ),set_value('tgl_keluar'));
                                ?>
                            </div>
                        </div>
                    </div>
                    
		</div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                    <div class="row">
                            <div class="col-lg-12 m--align-right">
                            <?php //if($this->mion_auth->is_allowed('edit_permission')){ ?>
                                <button type="submit" class="btn btn-success"><?php echo $this->lang->line('button_search');?></button>
                            <?php //} ?>
                                <button type="button" class="btn btn-secondary" id="tombol-cancel"><?php echo $this->lang->line('button_reset');?></button>
                            </div>
                    </div>
                </div>
		</div>
            
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						<?php echo isset($list_header)?$list_header:""; ?>
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
<!--                                        <li class="m-portlet__nav-item">
                                            <a href="<?php //echo site_url('organisasi/Pegawai/import_form'); ?>" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air" id="button_add" >
							<span>
								<i class="la la-file-excel-o"></i>
								<span><?php //echo $this->lang->line('button_excel');?></span>
							</span>
						</a>
					</li>-->
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                            <thead>
                                    <tr>
                                            <th>No</th>
                                            <th><?php echo $this->lang->line('nip')?></th>
                                            <th><?php echo $this->lang->line('nama')?></th>
                                            <th><?php echo $this->lang->line('kd_departemen')?></th>
                                            <th><?php echo $this->lang->line('kd_jabatan')?></th>
                                            <th><?php echo $this->lang->line('report_to')?></th>
                                            <th><?php echo $this->lang->line('tgl_masuk')?></th>
                                            <th><?php echo $this->lang->line('status')?></th>
                                    </tr>
                            </thead>
                    </table>
		</div>
        </div>
    </div>
    
</div>