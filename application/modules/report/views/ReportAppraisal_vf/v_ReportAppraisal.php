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
            <?php echo form_open('report/ReportAppraisal/search',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
		
		<div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                    <?php echo form_label($this->lang->line('report_type'),'report_type');?>
                                    <?php   
                                            echo form_dropdown('report_type', 
                                                                $ListReport, 
                                                                set_value('report_type'),
                                                                "id='report_type' style='width: 100%' class='select2 form-control m-select2' 
                                                                data-placeholder='".$this->lang->line('report_type')."'"); 

                                    ?>
                                <div class="error"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                    <?php echo form_label($this->lang->line('nm_departemen'),'kd_departemen');?>
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
                                    <?php echo form_label($this->lang->line('bulan'),'bulan');?>
                                    <?php echo form_dropdown('bulan', 
                                                                $ListBulan, 
                                                                set_value('bulan'),
                                                                "id='bulan' style='width: 100%' class='select2 form-control m-select2' 
                                                                data-placeholder='".$this->lang->line('bulan')."'"); 

                                    ?>
                                <div class="error"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group m-form__group">
                                    <?php echo form_label($this->lang->line('tahun'),'tahun');?>
                                    <?php echo form_dropdown('tahun', 
                                                                $ListTahun, 
                                                                set_value('tahun',date('Y')),
                                                                "id='tahun' style='width: 100%' class='select2 form-control m-select2' 
                                                                data-placeholder='".$this->lang->line('tahun')."'"); 

                                    ?>
                                <div class="error"></div>
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
<div class="row report_content">
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
                    <table class="table table-striped- table-bordered table-hover table-checkable custom-table" id="m_table_1">
                            <thead>
                                    <tr>
                                            <th>No</th>
                                            <th><?php echo $this->lang->line('nip')?></th>
                                            <th><?php echo $this->lang->line('nama')?></th>
                                            <th><?php echo $this->lang->line('nm_departemen')?></th>
                                            <th><?php echo $this->lang->line('kd_jabatan')?></th>
                                            <th><?php echo $this->lang->line('bulan')?></th>
                                            <th><?php echo $this->lang->line('tahun')?></th>
                                            <th><?php echo $this->lang->line('result')?></th>
                                    </tr>
                            </thead>
                    </table>
		</div>
        </div>
    </div>
    
</div>
<div class="row report_content2">
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
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_2">
                            <thead>
                                    <tr>
                                            <th>No</th>
                                            <th><?php echo $this->lang->line('kd_departemen')?></th>
                                            <th><?php echo $this->lang->line('nm_departemen')?></th>
                                            <th><?php echo $this->lang->line('bulan')?></th>
                                            <th><?php echo $this->lang->line('tahun')?></th>
                                            <th><?php echo $this->lang->line('result')?></th>
                                    </tr>
                            </thead>
                    </table>
		</div>
        </div>
    </div>
    
</div>
<div class="row report_content3">
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
                    <table class="table table-striped- table-bordered table-hover table-checkable custom-table" id="m_table_3" >
                            <thead>
                                    <tr>
                                            <th>No</th>
                                            <th><?php echo $this->lang->line('nip')?></th>
                                            <th  style="min-width: 100px"><?php echo $this->lang->line('nama')?></th>
                                            <th style="min-width: 100px"><?php echo $this->lang->line('nm_departemen')?></th>
                                            <th  style="min-width: 100px"><?php echo $this->lang->line('kd_jabatan')?></th>
                                            <th><?php echo $this->lang->line('tahun')?></th>
                                            <th><?php echo $this->lang->line('jan')?></th>
                                            <th><?php echo $this->lang->line('feb')?></th>
                                            <th><?php echo $this->lang->line('mar')?></th>
                                            <th><?php echo $this->lang->line('apr')?></th>
                                            <th><?php echo $this->lang->line('may')?></th>
                                            <th><?php echo $this->lang->line('jun')?></th>
                                            <th><?php echo $this->lang->line('jul')?></th>
                                            <th><?php echo $this->lang->line('aug')?></th>
                                            <th><?php echo $this->lang->line('sep')?></th>
                                            <th><?php echo $this->lang->line('oct')?></th>
                                            <th><?php echo $this->lang->line('nov')?></th>
                                            <th><?php echo $this->lang->line('dec')?></th>
                                    </tr>
                            </thead>
                    </table>
		</div>
        </div>
    </div>
    
</div>
<div class="row report_content4">
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
                    <table class="table table-striped- table-bordered table-hover table-checkable custom-table" id="m_table_4" >
                            <thead>
                                    <tr>
                                            <th>No</th>
                                            <th><?php echo $this->lang->line('kd_departemen')?></th>
                                            <th  style="min-width: 100px"><?php echo $this->lang->line('nm_departemen')?></th>
                                            <th><?php echo $this->lang->line('tahun')?></th>
                                            <th><?php echo $this->lang->line('jan')?></th>
                                            <th><?php echo $this->lang->line('feb')?></th>
                                            <th><?php echo $this->lang->line('mar')?></th>
                                            <th><?php echo $this->lang->line('apr')?></th>
                                            <th><?php echo $this->lang->line('may')?></th>
                                            <th><?php echo $this->lang->line('jun')?></th>
                                            <th><?php echo $this->lang->line('jul')?></th>
                                            <th><?php echo $this->lang->line('aug')?></th>
                                            <th><?php echo $this->lang->line('sep')?></th>
                                            <th><?php echo $this->lang->line('oct')?></th>
                                            <th><?php echo $this->lang->line('nov')?></th>
                                            <th><?php echo $this->lang->line('dec')?></th>
                                    </tr>
                            </thead>
                    </table>
		</div>
        </div>
    </div>
    
</div>