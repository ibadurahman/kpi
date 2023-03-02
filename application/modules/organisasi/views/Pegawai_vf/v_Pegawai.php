<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
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
                    <?php if($this->mion_auth->is_allowed('import_pegawai')){ ?>
                    <li class="m-portlet__nav-item">
                        <a href="<?php echo site_url('organisasi/PegawaiImport/index'); ?>" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air" id="button_add" >
							<span>
								<i class="la la-upload"></i>
								<span><?php echo $this->lang->line('button_import');?></span>
							</span>
						</a>
					</li>
                    <?php } ?>
                    <?php if($this->mion_auth->is_allowed('add_pegawai')){ ?>
					<li class="m-portlet__nav-item">
                                            <a href="<?php echo site_url('organisasi/Pegawai/insert_form'); ?>" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air" id="button_add" >
							<span>
								<i class="la la-plus "></i>
								<span><?php echo $this->lang->line('button_new');?></span>
							</span>
						</a>
					</li>
                    <?php } ?>
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
                                            <th></th>
                                    </tr>
                            </thead>
                    </table>
		</div>
        </div>
    </div>
    
</div>