<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData=$DataBusinessDriver->row();
?>
<div class="row">
    <div class="col-4">
        
        <div class="m-portlet m-portlet--tab">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
					</span>
					<h3 class="m-portlet__head-text">
						<?php echo isset($result_header)?$RowData->nm_bd." Chart ".$DataTahun:""; ?> 
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<div id="m_amcharts_9" style="height: 300px;"></div>
		</div>
	</div>
    </div>
    <div class="col-8">
        <div class="m-portlet m-portlet--tab">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
					</span>
					<h3 class="m-portlet__head-text">
						<?php echo isset($result_header)?$RowData->nm_bd." ".$result_header." ".$DataTahun:""; ?>
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
						<?php echo isset($input_header)?$input_header:""; ?>
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
                                    <?php if($this->mion_auth->is_allowed('edit_business_driver')){ ?>
					<li class="m-portlet__nav-item">
                                            <a href="#" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air" id="button_edit" data-id="<?php echo $RowData->kd_bd; ?>" >
							<span>
								<i class="la la-edit "></i>
								<span><?php echo $this->lang->line('button_edit');?></span>
							</span>
						</a>
					</li>
                                    <?php } ?>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
                    <div class="row">
			<div class="col-12">
                            <form class="m-form m-form--fit m-form--label-align-right form-horizontal">
                                        <div class="form-group m-form__group m-form__section--first row">
                                                <?php echo form_label($this->lang->line('kd_bd'),'kd_bd',array("class"=>"col-3 col-form-label"));?>
						<div class="col-7">
                                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->kd_bd; ?></span>
						</div>
					</div>
					<div class="form-group m-form__group row">
                                                <?php echo form_label($this->lang->line('nm_bd'),'nm_bd',array("class"=>"col-3 col-form-label"));?>
						<div class="col-7">
                                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->nm_bd; ?></span>
						</div>
					</div>
					<div class="form-group m-form__group row">
                                                <?php echo form_label($this->lang->line('kd_perspective'),'kd_perspective',array("class"=>"col-3 col-form-label"));?>
						<div class="col-7">
                                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->nm_perspective; ?></span>
						</div>
					</div>
                            </form>        
				
			</div>
                    </div>
		</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg" m-portlet="true">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						<?php echo isset($result_header)?$RowData->nm_bd." ".$result_header." ".$DataTahun:""; ?>
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_3">
                            <thead>
                                    <tr>
                                            <th>No</th>
                                            <th><?php echo $this->lang->line('bulan')?></th>
                                            <th><?php echo $this->lang->line('result')?></th>
                                            
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
                        <?php echo form_open('scorecards/BusinessDriver/save',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
			<!--<form class="m-form m-form--fit m-form--label-align-right">-->
				<div class="modal-body">
                                        
				</div>
				<div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="tombol_submit">Submit</button>
                                    <button type="button" class="btn btn-success" id="tombol_edit" data-id="">Edit</button>
                                    <button type="button" class="btn btn-secondary" id="tombol-cancel" data-dismiss="modal">Close</button>
				</div>
			<!--</form>-->
                        <?php echo form_close(); ?>
		</div>
	</div>
</div>