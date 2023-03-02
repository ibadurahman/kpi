<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData = $DataPegawai->row();
?>
<!--Begin::Section-->
<div class="row">
    <div class="col-lg-4">
        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg" m-portlet="true">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('profile'); ?>
						</h3>
                    </div>
                </div>
                
            </div>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="m-form__section m-form__section--first">
                            
                            <div class="form-group m-form__group m--margin-bottom-20">
                                    <div class="col-sm-12">
                                        <?php 
                                            if($RowData->foto!=""){
                                                $LinkFoto= base_url('assets/upload/foto/'.$RowData->foto);
                                            }else{
                                                $LinkFoto= base_url('assets/img/NoImage.png');
                                            } 
                                        ?>
                                        <div id="image-holder"><img src="<?php echo $LinkFoto;?>" class="thumb-image" style="width: 150px; height: 150px;"/></div>
                                    </div>
                            </div>
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo $this->lang->line('header_section'); ?></h3>
                            </div>
				            <div class="form-group m-form__group row">
                                <?php echo form_label($this->lang->line('nip'),'nip',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                <div class="col-7">
                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->nip; ?></span>
                                </div>
				            </div>
				            <div class="form-group m-form__group row">
                                <?php echo form_label($this->lang->line('nama'),'nama',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                <div class="col-7">
                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo ucwords(strtolower($RowData->nama)); ?></span>
                                </div>
				            </div>
                            <div class="form-group m-form__group row">
                                    <?php echo form_label($this->lang->line('kd_departemen'),'kd_departemen',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                   <div class="col-7">
                                       <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->nm_departemen; ?></span>
                                   </div>
                            </div>
                            <div class="form-group m-form__group row">
                                    <?php echo form_label($this->lang->line('kd_jabatan'),'kd_jabatan',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                   <div class="col-7">
                                       <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->nm_jabatan; ?></span>
                                   </div>
                            </div>
                            <div class="form-group m-form__group row">
                                    <?php echo form_label($this->lang->line('report_to'),'report_to',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                   <div class="col-7">
                                       <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo ucwords(strtolower($RowData->nm_report_to)); ?></span>
                                   </div>
                            </div>
                            <div class="form-group m-form__group row">
                                    <?php echo form_label($this->lang->line('jenis_kelamin'),'jenis_kelamin',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                   <div class="col-7">
                                       <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $ListKelamin[$RowData->jenis_kelamin]; ?></span>
                                   </div>
                            </div>
                        </div>
                    </div>
                </div>
                    
                    
		    </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <div class="col-lg-8">
    <div class="m-portlet m-portlet--full-height ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('list_subordinate')." ". getNamaBulan($DataBulan)." ".$DataTahun; ?>
						</h3>
					</div>
				</div>
                <div class="m-portlet__head-tools">
                    <div class="btn-group">
                        <a href="<?php echo site_url('scorecards/Appraisal'); ?>" class="btn btn-success  m-btn m-btn--icon m-btn--wide m-btn--sm">
                            <span>
                                <span>View All</span>
                            </span>
                        </a>
                    </div>
		        </div>
			</div>
			<div class="m-portlet__body">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_3">
                    <thead>
                            <tr>
                                    <th>No</th>
                                    <th><?php echo $this->lang->line('nip')?></th>
                                    <th><?php echo $this->lang->line('nama')?></th>
                                    <!-- <th><?php //echo $this->lang->line('kd_departemen')?></th>
                                    <th><?php //echo $this->lang->line('kd_jabatan')?></th> -->
                                    <th><?php echo $this->lang->line('status_appraisal')?></th>
                                    <th><?php echo $this->lang->line('score')?></th>

                            </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=1;
                        foreach($ListSubordinate->result() as $row){
                            $nm_status= $ListStatAppraisal[$row->stat_appraisal]; 
                            switch ($row->stat_appraisal){
                                case 1: $ClsStatus = "m-badge--warning";break;
                                case 2: $ClsStatus = "m-badge--success";break;
                                default:$ClsStatus = "m-badge--danger";
                            }
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $row->nip; ?></td>
                            <td><?php echo $row->nama; ?></td>
                            <!-- <td><?php //echo $row->nm_departemen; ?></td>
                            <td><?php //echo $row->nm_jabatan; ?></td> -->
                            <td><span class="m-badge <?php echo $ClsStatus; ?> m-badge--wide"><?php echo $nm_status; ?></span></td>
                            <td class="m--align-right"><?php echo $row->point; ?></td>
                        </tr>
                        <?php
                        $no++;
                        }
                        ?>
                    </tbody>
                </table>
			</div>
		</div>
        
    </div>
</div>
<div class="row">
    <div class="col-lg-5">
        <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                        <span class="m-portlet__head-icon m--hide">
                                                <i class="la la-gear"></i>
                                        </span>
                                        <h3 class="m-portlet__head-text">
                                                <?php echo $this->lang->line('my_performance')." ". getNamaBulan($DataBulan)." ".$DataTahun; ?>
                                        </h3>
                                </div>
                        </div>
                </div>
                <div class="m-portlet__body">
                        <div id="basic-gauge" style="height: 300px;"></div>
                </div>
        </div>                                  
    </div>
    <div class="col-lg-7">
        <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                        <span class="m-portlet__head-icon m--hide">
                                                <i class="la la-gear"></i>
                                        </span>
                                        <h3 class="m-portlet__head-text">
                                                <?php echo $this->lang->line('performance_history'); ?>
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

<!--End::Section-->

		
                
<div class="modal fade" id="home_modal" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="form_header"><?php echo (isset($header_modal))?$header_modal:""; ?></h5>
<!--				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="la la-remove"></span>
				</button>-->
			</div>
                        <?php echo form_open('dashboard/Home/pilih_perusahaan',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
			<!--<form class="m-form m-form--fit m-form--label-align-right">-->
				<div class="modal-body">
                                        
                                    <div class="form-group m-form__group m--margin-bottom-20">
                                            <?php echo form_label($this->lang->line('kd_perusahaan')."<span class='m--font-danger'>*</span>",'kd_perusahaan');?>
                                            <?php echo form_dropdown('kd_perusahaan', 
                                                                        $ListMenuPerusahaan, 
                                                                        set_value('kd_perusahaan'),
                                                                        "id='kd_perusahaan' style='width: 100%' class='select2 form-control m-select2' 
                                                                        data-placeholder='".$this->lang->line('kd_perusahaan')."'"); 

                                            ?>
                                    </div>
				</div>
				<div class="modal-footer">
                                    <button type="submit" class="btn btn-success" id="tombol_submit">Submit</button>
                                    <!--<button type="button" class="btn btn-secondary" id="tombol-cancel" data-dismiss="modal">Close</button>-->
				</div>
			<!--</form>-->
                        <?php echo form_close(); ?>
		</div>
	</div>
</div>
		