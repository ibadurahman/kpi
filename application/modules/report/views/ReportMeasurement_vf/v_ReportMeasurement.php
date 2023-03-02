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
            <?php echo form_open('report/ReportMeasurement/index',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
		
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
                                <div class="error"><?php echo form_error('report_type'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-4 data_hide">
                            <div class="form-group m-form__group">
                                    <?php echo form_label($this->lang->line('nm_departemen'),'kd_departemen');?>
                                    <?php echo form_dropdown('kd_departemen', 
                                                                $ListDepartemen, 
                                                                set_value('kd_departemen'),
                                                                "id='kd_departemen' style='width: 100%' class='select2 form-control m-select2' 
                                                                data-placeholder='".$this->lang->line('kd_departemen')."'"); 

                                    ?>
                                <div class="error"><?php echo form_error('nm_departemen'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-4 data_hide_pegawai">
                            <div class="form-group m-form__group">
                                    <?php echo form_label($this->lang->line('nama'),'nip');?>
                                    <?php   
                                            echo form_dropdown('nip', 
                                                                array(), 
                                                                set_value('nip'),
                                                                "id='nip' style='width: 100%' class='select2-ajax form-control m-select2' 
                                                                data-placeholder='".$this->lang->line('nama')."'"); 

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
                                <div class="error"><?php echo form_error('bulan'); ?></div>
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
                                <div class="error"><?php echo form_error('tahun'); ?></div>
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