<div>
        <?php if($this->mion_auth->is_allowed('add_business_driver')){ ?>
        <a href="#" id="button_add" class="btn btn-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--air" title="<?php echo $this->lang->line('button_new'); ?>">
		<i class="la la-plus"></i>
	</a>
        <?php }?>
    <?php if(isset($DataBusinessDriver) and $DataBusinessDriver->num_rows()>0){ 
        $RowData=$DataBusinessDriver->row();
        ?>
<!--        <a href="<?php //echo site_url('scorecards/BusinessDriver/index/'.$DataTahun); ?>" class="btn btn-secondary m-btn m-btn--icon m-btn--icon-only m-btn--custom">
		<i class="la la-arrow-left"></i>
	</a>-->
        <?php if($this->mion_auth->is_allowed('edit_business_driver')){ ?>
        <a href="#" id="button_edit" data-id="<?php echo $RowData->kd_bd; ?>" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--air" title="<?php echo $this->lang->line('button_edit'); ?>">
		<i class="la la-edit"></i>
	</a>
        <?php }?>
        <?php if($this->mion_auth->is_allowed('delete_business_driver') and $RowData->total_data <= 0){ ?>
        <a href="#" id="button_delete" data-id="<?php echo $RowData->kd_bd; ?>" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--air" title="<?php echo $this->lang->line('button_delete'); ?>">
		<i class="la la-trash"></i>
	</a>
        <?php }?>
    <?php }?>
        <div class="m-dropdown m-dropdown--inline m-dropdown--medium  m-dropdown--arrow m-dropdown--align-right" m-dropdown-toggle="click">
            <a href="#" class="m-dropdown__toggle btn btn-success dropdown-toggle" id="dropdown_tahun_header">
			<?php echo getNamaBulan($DataBulan)." ".$DataTahun; ?>
		</a>
		<div class="m-dropdown__wrapper">
			<span class="m-dropdown__arrow m-dropdown__arrow--right"></span>
			<div class="m-dropdown__inner">
				<div class="m-dropdown__body">
					<div class="m-dropdown__content">
						<?php echo form_open('scorecards/BusinessDriver/search_data',["class"=>"m-form m-form--state","id"=>"form_input_select"]);?>
                                                <!--<form class="m-form m-form--fit m-form--label-align-right">-->
                                                                <div class="form-group m-form__group row">
                                                                    <div class="col-md-12">
                                                                        <?php echo form_dropdown('period_search', 
                                                                                                    $ListPeriod, 
                                                                                                    set_value('period_search'),
                                                                                                    "id='period_search' style='width: 100%' class='select2_non_clear form-control m-select2' 
                                                                                                    data-placeholder='".$this->lang->line('period')."'"); 
                                                                                echo form_hidden("data_uri",$data_uri);                    
                                                                        ?>
                                                                        <div class="error"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group m-form__group row">
                                                                    <div class="col-md-7 select_bulan">
                                                                        <?php echo form_dropdown('bulan_search', 
                                                                                                    $ListBulan, 
                                                                                                    set_value('bulan_search',$DataBulan),
                                                                                                    "id='bulan_search' style='width: 100%' class='select2_non_clear form-control m-select2' 
                                                                                                    data-placeholder='".$this->lang->line('bulan')."'"); 

                                                                        ?>
                                                                        <div class="error"></div>
                                                                    </div>
                                                                    <div class="col-md-5 select_tahun">
                                                                        <?php echo form_dropdown('tahun_search', 
                                                                                                    $ListTahun, 
                                                                                                    set_value('tahun_search',$DataTahun),
                                                                                                    "id='tahun_search' style='width: 100%' class='select2_non_clear form-control m-select2' 
                                                                                                    data-placeholder='".$this->lang->line('tahun')."'"); 

                                                                        ?>
                                                                    <div class="error"></div>
                                                                    </div>
                                                                </div>
                                                            <div class="form-group m-form__group">
                                                                <button type="submit" class="btn btn-success" id="tombol_submit">Show Result</button>
                                                            </div>
                                                                
                                                <!--</form>-->
                                                <?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
        
</div>
