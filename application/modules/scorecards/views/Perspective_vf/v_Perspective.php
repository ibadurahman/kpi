<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-4">
        
        <div class="m-portlet m-portlet--tab">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
					</span>
					<h3 class="m-portlet__head-text">
						<?php echo $this->lang->line('performa_perusahaan'); ?>
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<div id="m_amcharts_9" style="height: 300px;"></div>
		</div>
	</div>
    </div>
    <div class="col-md-8">
        <div class="m-portlet m-portlet--tab">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
					</span>
					<h3 class="m-portlet__head-text">
						<?php echo $this->lang->line('performa_perusahaan_history'); ?>
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<div id="m_amcharts_7" style="height: 300px;"></div>
		</div>
	</div>
        
    </div>
</div>
<div class="row">
    <div class="col-md-6">
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
                                    <?php if($this->mion_auth->is_allowed('add_perspective')){ ?>
					<li class="m-portlet__nav-item">
                                            <a href="#" class="btn btn-success m-btn btn-sm m-btn--custom m-btn--icon m-btn--air" id="button_add" >
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
                    <table class="table table-striped- table-bordered table-hover table-checkable custom-table" id="m_table_1">
                            <thead>
                                    <tr>
                                            <th>No</th>
                                            <th><?php echo $this->lang->line('kd_perspective')?></th>
                                            <th><?php echo $this->lang->line('kd_ps')?></th>
                                            <th><?php echo $this->lang->line('nm_perspective')?></th>
                                            <th></th>
                                            <th></th>
                                    </tr>
                            </thead>
                    </table>
		</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg" m-portlet="true">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						<?php echo isset($list_header_bobot)?$list_header_bobot." ".$DataTahun:""; ?>
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools ">
				<ul class="m-portlet__nav">
                                    <?php 
                                    if(isset($perspective_bobot) and $perspective_bobot->num_rows()<=0){
                                        if($this->mion_auth->is_allowed('add_perspective_bobot')){ ?>
					<li class="m-portlet__nav-item">
                                            <a href="#" class="btn btn-success m-btn btn-sm m-btn--custom m-btn--icon m-btn--air" id="button_add_bobot" >
							<span>
								<i class="la la-plus "></i>
								<span><?php echo $this->lang->line('button_new_bobot');?></span>
							</span>
						</a>
					</li>
                                    <?php } ?>
                                    <?php 
                                    }else{
                                        $RowData=$perspective_bobot->row();
                                    if($this->mion_auth->is_allowed('edit_perspective_bobot')){
                                        
                                    ?>
					<li class="m-portlet__nav-item">
                                            <a href="#" class="btn btn-accent m-btn btn-sm m-btn--custom m-btn--icon m-btn--air" id="button_edit_bobot" data-id="<?php echo $RowData->tahun; ?>" >
							<span>
								<i class="la la-edit "></i>
								<span><?php echo $this->lang->line('button_edit');?></span>
							</span>
						</a>
					</li>
                                    <?php } ?>
                                    <?php if($this->mion_auth->is_allowed('delete_perspective_bobot')){ ?>
					<li class="m-portlet__nav-item">
                                            <a href="#" class="btn btn-danger m-btn btn-sm m-btn--custom m-btn--icon m-btn--air" id="button_delete_bobot" data-id="<?php echo $RowData->tahun; ?>">
							<span>
								<i class="la la-trash "></i>
								<span><?php echo $this->lang->line('button_delete');?></span>
							</span>
						</a>
					</li>
                                    <?php }
                                    }?>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
                    <table class="table table-striped- table-bordered table-hover table-checkable custom-table" id="m_table_2">
                            <thead>
                                    <tr>
                                            <th>No</th>
                                            <th><?php echo $this->lang->line('kd_pb')?></th>
                                            <th><?php echo $this->lang->line('nm_perspective')?></th>
                                            <th><?php echo $this->lang->line('weightage')?></th>
                                            
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
                        <?php echo form_open('scorecards/Perspective/save',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
			<!--<form class="m-form m-form--fit m-form--label-align-right">-->
				<div class="modal-body">
                                        
				</div>
				<div class="modal-footer">
                                    <!--<button type="button" class="btn btn-warning m--align-left" id="tombol_duplicate">Duplicate from last year</button>-->
                                    <button type="submit" class="btn btn-success" id="tombol_submit">Submit</button>
                                    <button type="button" class="btn btn-accent" id="tombol_edit" data-id="">Edit</button>
                                    <button type="button" class="btn btn-secondary" id="tombol-cancel" data-dismiss="modal">Close</button>
				</div>
			<!--</form>-->
                        <?php echo form_close(); ?>
		</div>
	</div>
</div>