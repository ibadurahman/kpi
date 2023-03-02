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
                                    <?php if($this->mion_auth->is_allowed('add_permission')){ ?>
					<li class="m-portlet__nav-item">
                                        <a href="#" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air" id="button_add" >
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
                                            <th><?php echo $this->lang->line('kd_permission')?></th>
                                            <th><?php echo $this->lang->line('deskripsi')?></th>
                                            <th><?php echo $this->lang->line('kd_menu')?></th>
                                            <th></th>
                                    </tr>
                            </thead>
                    </table>
		</div>
        </div>
    </div>
    
</div>
<div class="modal fade" id="input_modal" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="form_header"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="la la-remove"></span>
				</button>
			</div>
                        <?php echo form_open('akses/Permission/save',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
			<!--<form class="m-form m-form--fit m-form--label-align-right">-->
				<div class="modal-body">
                                        
				</div>
				<div class="modal-footer">
                                    <button type="submit" class="btn btn-success" id="tombol_submit">Submit</button>
                                    <?php if($this->mion_auth->is_allowed('edit_permission')){ ?>
                                    <button type="button" class="btn btn-accent" id="tombol_edit" data-id="">Edit</button>
                                    <?php } ?>
                                    <button type="button" class="btn btn-secondary" id="tombol-cancel" data-dismiss="modal">Close</button>
				</div>
			<!--</form>-->
                        <?php echo form_close(); ?>
		</div>
	</div>
</div>