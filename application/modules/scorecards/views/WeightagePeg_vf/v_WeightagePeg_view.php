<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData = $DataPk->row();
?>
<div class="m-section__content " id="user_role_section"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg" m-portlet="true">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
							<?php echo isset($input_header)?$input_header:""; ?>
						</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="<?php echo site_url('scorecards/WeightagePeg'); ?>" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>Back</span>
                        </span>
			        </a>
		        </div>
            </div>
            <?php echo form_open_multipart('organisasi/Pegawai/save',["class"=>"-form m-form--label-align-right m-form--state-","id"=>"form_input"]);
                        echo form_input(array(
                                     'name'          => 'StatusSave',
                                     'id'            => 'StatusSave',
                                     'type'         =>'hidden'
                             ));
            ?>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="m-form__section m-form__section--first">
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
                                <?php echo form_label($this->lang->line('bulan_efektif'),'bulan_efektif',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                <div class="col-7">
                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo getNamaBulan($RowData->bulan); ?></span>
                                </div>
				            </div>
				            <div class="form-group m-form__group row">
                                <?php echo form_label($this->lang->line('tahun_efektif'),'tahun_efektif',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                <div class="col-7">
                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->tahun; ?></span>
                                </div>
				            </div>
                                
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title"><?php echo $this->lang->line('header_KPI'); ?></h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover custom-table">
                                            <thead>
                                                    <tr>
                                                                <th>No</th>
                                                                <th><?php echo $this->lang->line('kd_measurement')?></th>
                                                                <th><?php echo $this->lang->line('nm_measurement')?></th>
                                                                <th><?php echo $this->lang->line('weightage_kpi')." (%)"?></th>
                                                                
                                                    </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no=1;
                                                $KdDBTemp="";
                                                foreach($DataPk->result() as $row)
                                                {
                                                ?>

                                                    <tr>
                                                            <td scope="row"><?php echo $no; ?></td>
                                                            <td><?php echo $row->kd_ms; ?></td>
                                                            <td><?php echo $row->nm_measurement; ?></td>
                                                            <td align="center">
                                                                <span class="m-badge m-badge--success m-badge--wide button_bobot_kpi" ><?php echo  $row->bobot." %"; ?></span>
                                                            </td>
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
                </div>             
		    </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('header_target'); ?>
						</h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="row">
                    <!-- <div class="col-md-6">
                        <div class="m-section">
                            <h3 class="m-section__heading">Tes Target</h3>
                            <div class="m-section__content">
                            content target
                            </div>                                
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="m-section">
                            <h3 class="m-section__heading">Tes Target</h3>
                            <div class="m-section__content">
                            content target
                            </div>                                
                        </div>                            
                    </div> -->
                    <?php 
                    foreach($DataTarget->result() as $rowTarget){
                    ?>

                    <div class="col-md-6">
                        <div class="m-portlet">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            <?php echo $rowTarget->nm_measurement; ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__body"> 
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover custom-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th><?php echo $this->lang->line('bulan')?></th>
                                                <th><?php echo $this->lang->line('Target')?></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no=1;
                                            $unit="";
                                            $DataBulan=explode(",",$rowTarget->bulan);
                                            $DataTarget=explode(",",$rowTarget->target);
                                            foreach($DataBulan as $key=>$val)
                                            {
                                                
                                                if($rowTarget->unit=='p'){
                                                    $unit = "%";
                                                }
                                            ?>

                                                <tr>
                                                    <td scope="row"><?php echo $no; ?></td>
                                                    <td><?php echo getNamaBulan($val)." ".$RowData->tahun; ?></td>
                                                    <td align="right"><?php echo $DataTarget[$key]." ".$unit; ?></td>
                                                </tr>
                                            <?php 
                                                    $no++;
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="m-portlet__foot">
                            <?php
                            if($this->mion_auth->is_allowed('edit_weightage_peg')) {
                            ?>
                                <a href="#" class="btn btn-success button_view_target"  data-id="<?php echo $RowData->kd_pk; ?>" data-id2="<?php echo $rowTarget->kd_measurement; ?>">
                                    <span>
                                        <i class="la la-edit"></i>
                                        <span>Edit</span>
                                    </span>
                                </a>
                            <?php
                            }
                            ?>
                            </div>
                        </div>                        
                    </div>
                    
                    <?php
                    }
                    ?>
                </div>                                    
                                                    
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
                        <?php echo form_open('scorecards/DepartemenKpi/save',["class"=>"m-form m-form--state","id"=>"form_input_modal"]);?>
			<!--<form class="m-form m-form--fit m-form--label-align-right">-->
				<div class="modal-body">
                                        
				</div>
				<div class="modal-footer">
                                    <button type="submit" class="btn btn-success" id="tombol_submit">Submit</button>
                                    <button type="button" class="btn btn-accent" id="tombol_edit" data-id="" data-id2="" data-id3="">Edit</button>
                                    <button type="button" class="btn btn-secondary" id="tombol-cancel" data-dismiss="modal">Close</button>
				</div>
			<!--</form>-->
                        <?php echo form_close(); ?>
		</div>
	</div>
</div>
<!--<div class="row">
    <div class="col-lg-12">
        <div class="m-portlet m-portlet--tabs">
		<div class="m-portlet__head">
			<div class="m-portlet__head-tools">
				<ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
					<li class="nav-item m-tabs__item">
						<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">
							<i class="flaticon-statistics"></i> <?php //echo $this->lang->line('result'); ?>
						</a>
					</li>
					<li class="nav-item m-tabs__item">
						<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">
							<i class="la la-bars"></i> <?php //echo $this->lang->line('list_kpi'); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
                    
			<div class="tab-content">
				<div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-4">
                                                        <div class="m-portlet ">
                                                                <div class="m-portlet__body">
                                                                        <div id="m_amcharts_7" style="height: 300px;"></div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="m-portlet ">
                                                                <div class="m-portlet__body">
                                                                        <div id="m_amcharts_7" style="height: 300px;"></div>
                                                                </div>
                                                        </div>
                                                    </div>
                                        </div>
					
				</div>
				<div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
					It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
					publishing software like Aldus PageMaker including versions of Lorem Ipsum.
				</div>
				<div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has
					survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
				</div>
			</div>
		</div>
	</div>
        
    </div>
</div>-->