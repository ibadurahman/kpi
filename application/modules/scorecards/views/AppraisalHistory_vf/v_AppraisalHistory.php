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
		</div>
		<div class="m-portlet__body">
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable custom-table" id="m_table_1">
                            <thead>
                                    <tr>
                                            <th>No</th>
                                            <th><?php echo $this->lang->line('kd_appraisal')?></th>
                                            <th><?php echo $this->lang->line('nip')?></th>
                                            <th><?php echo $this->lang->line('nama')?></th>
                                            <th><?php echo $this->lang->line('kd_departemen')?></th>
                                            <th><?php echo $this->lang->line('kd_jabatan')?></th>
                                            <th><?php echo $this->lang->line('nama_atasan')?></th>
                                            <th><?php echo $this->lang->line('bulan')?></th>
                                            <th><?php echo $this->lang->line('tahun')?></th>
                                            <th><?php echo $this->lang->line('status')?></th>
                                            <th></th>
                                    </tr>
                            </thead>
                    </table>
		</div>
        </div>
    </div>
    
</div>
<div class="modal fade" id="input_modal" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="form_header"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="la la-remove"></span>
				</button>
			</div>
                        <?php echo form_open('organisasi/Perusahaan/save',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
			<!--<form class="m-form m-form--fit m-form--label-align-right">-->
				<div class="modal-body">
                                        
				</div>
				<div class="modal-footer">
                                    <button type="submit" class="btn btn-success" id="tombol_submit">Submit</button>
                                    <button type="button" class="btn btn-accent" id="tombol_edit" data-id="">Edit</button>
                                    <button type="button" class="btn btn-secondary" id="tombol-cancel" data-dismiss="modal">Close</button>
				</div>
			<!--</form>-->
                        <?php echo form_close(); ?>
		</div>
	</div>
</div>