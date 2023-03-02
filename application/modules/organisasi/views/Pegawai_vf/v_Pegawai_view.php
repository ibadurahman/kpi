<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData = $DataPegawai->row();
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
                    <a href="<?php echo site_url('organisasi/Pegawai'); ?>" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>Back</span>
                        </span>
			        </a>
                    <?php if($this->mion_auth->is_allowed('edit_pegawai')){ ?>
                    <div class="btn-group">
                        <a href="<?php echo site_url('organisasi/Pegawai/edit_form/'.$RowData->nip); ?>" class="btn btn-success  m-btn m-btn--icon m-btn--wide m-btn--md">
                            <span>
                                <i class="la la-edit"></i>
                                <span>Edit</span>
                            </span>
                        </a>
                    </div>
                    <?php } ?>
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
                    <div class="col-md-3">
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
                        </div>
                    </div>
                    <div class="col-md-4">
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
                                <?php echo form_label($this->lang->line('tgl_masuk'),'tgl_masuk',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                <div class="col-7">
                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo convert_date($RowData->tgl_masuk); ?></span>
                                </div>
				            </div>
				            <div class="form-group m-form__group row">
                                <?php echo form_label($this->lang->line('tgl_keluar'),'tgl_keluar',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                <div class="col-7">
                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo convert_date($RowData->tgl_keluar); ?></span>
                                </div>
				            </div>
				            <div class="form-group m-form__group row">
                                <?php echo form_label($this->lang->line('dob'),'dob',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                <div class="col-7">
                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo convert_date($RowData->dob); ?></span>
                                </div>
				            </div>
                                
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="m-form__section m-form__section--first">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title"><?php echo $this->lang->line('header_section'); ?></h3>
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
                            <div class="form-group m-form__group row">
                                    <?php echo form_label($this->lang->line('status'),'status',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                   <div class="col-7">
                                       <?php 

                                       $nm_status= $ListStatus[$RowData->status]; 
                                       switch ($RowData->status){
                                           case 1: $ClsStatus = "m-badge--success";break;
                                           case 2: $ClsStatus = "m-badge--danger";break;
                                           default:$ClsStatus = "";
                                       }
                                       ?>
                                       <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><span class="m-badge <?php echo $ClsStatus; ?> m-badge--wide"><?php echo $nm_status; ?></span></span>
                                       
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
    <div class="col-lg-5">
        <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                        <span class="m-portlet__head-icon m--hide">
                                                <i class="la la-gear"></i>
                                        </span>
                                        <h3 class="m-portlet__head-text">
                                                <?php echo ucwords(strtolower($RowData->nama))." ".$this->lang->line('performance')." ". getNamaBulan($DataBulan)." ".$DataTahun; ?>
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
                                                <?php echo ucwords(strtolower($RowData->nama))." ".$this->lang->line('performance_history'); ?>
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
	<div class="col-sm-12">
		<div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-tools">
					<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
								<i class="flaticon-share m--hide"></i>
								<?php echo $this->lang->line('tab_kpi1');?>
							</a>
						</li>
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2" role="tab">
								<?php echo $this->lang->line('tab_kpi2');?>
							</a>
						</li>
					</ul>
                                        
				</div>
                                <div class="m-portlet__head-tools ">
                                        <ul class="m-portlet__nav">
                                            <?php 
                                            if($this->mion_auth->is_allowed('add_pegawai_kpi')){ ?>
                                                <li class="m-portlet__nav-item">
<!--                                                    <a href="#" class="btn btn-primary m-btn btn-sm m-btn--custom m-btn--icon m-btn--air" data-id="<?php //echo $RowData->nip; ?>" id="button_add_bobot" >-->
                                                        <a href="<?php echo site_url("organisasi/Pegawai/kpi_insert_form/".$RowData->nip."/".$DataTahun."/".$DataBulan) ?>" class="btn btn-success m-btn btn-sm m-btn--custom m-btn--icon m-btn--air" >
                                                                <span>
                                                                        <i class="la la-plus "></i>
                                                                        <span><?php echo $this->lang->line('button_new_target');?></span>
                                                                </span>
                                                        </a>
                                                </li>
                                            <?php } 
                                            
                                            ?>
                                        </ul>
                                </div>
				
			</div>
			<div class="tab-content">
				<div class="tab-pane active" id="m_user_profile_tab_1">
					<div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-md-9">
                                                        <h4 class="m-form__section"><?php echo $this->lang->line('kpi_header')." ".$DataTahun; ?></h4>
                                                </div>
                                                <div class="col-md-3">
                                                    <?php 
                                                    if($DataKpiPegawai->num_rows()>0){
                                                        $RowKPI=$DataKpiPegawai->row();
                                                       
                                                    ?>
                                                    <?php  //if($this->mion_auth->is_allowed('edit_pegawai_kpi')){ ?>
<!--                                                            <a href="<?php //echo site_url('organisasi/Pegawai/kpi_edit_form/'.$RowData->nip."/".$DataTahun) ?>" class="btn btn-accent m-btn btn-sm m-btn--custom m-btn--icon m-btn--air" id="button_edit_target" >
                                                                        <span>
                                                                                <i class="la la-edit "></i>
                                                                                <span><?php //echo $this->lang->line('button_edit');?></span>
                                                                        </span>
                                                                </a>-->
                                                    <?php //}  ?>
                                                    <?php if($this->mion_auth->is_allowed('delete_pegawai_kpi')){ ?>
                                                            <a href="#" class="btn btn-danger m-btn btn-sm m-btn--custom m-btn--icon m-btn--air" id="button_delete" data-id="<?php echo $RowKPI->kd_pk; ?>" data-id2="<?php echo $RowKPI->nip; ?>" data-id3="<?php echo $DataTahun; ?>">
                                                                        <span>
                                                                                <i class="la la-trash "></i>
                                                                                <span><?php echo $this->lang->line('button_delete');?></span>
                                                                        </span>
                                                                </a>
                                                    <?php } 
                                                    }?>
                                                </div>
                                            </div>
                                            <?php 
                                            if($DataKpiPegawai->num_rows()>0){
                                                $RowKPI=$DataKpiPegawai->row();
                                            ?>
                                            <div class="form-group m-form__group row">
                                                    <?php echo form_label($this->lang->line('bulan_efektif'),'bulan',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <span class="m-form__control-static"><?php echo getNamaBulan($RowKPI->bulan); ?></span>
                                                    </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                    <?php echo form_label($this->lang->line('tahun_efektif'),'tahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
                                                    <div class="col-xl-9 col-lg-9">
                                                            <span class="m-form__control-static"><?php echo $RowKPI->tahun; ?></span>
                                                    </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                            <div class="form-group m-form__group row">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover custom-table">
                                                        <thead>
                                                                <tr>
                                                                            <th>No</th>
                                                                            <th><?php echo $this->lang->line('kd_measurement')?></th>
                                                                            <th><?php echo $this->lang->line('nm_measurement')?></th>
                                                                            <!-- <th><?php //echo $this->lang->line('weightage_bd')." (%)"?></th> -->
                                                                            <th><?php echo $this->lang->line('weightage_kpi')." (%)"?></th>
                                                                            <th><?php echo $this->lang->line('target')?></th>

                                                                </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $no=1;
                                                            $KdDBTemp="";
                                                            foreach($DataKpiPegawai->result() as $row)
                                                            {
                                                                // $Persen_bd=round(($row->weightage_bd/$row->Tot_bobot_bd)*100,2);
                                                                $Persen_kpi=round(($row->weightage_kpi/$row->Tot_bobot_kpi)*100,2);
                                                                    if($row->kd_bd!=$KdDBTemp){
                                                                    $KdDBTemp=$row->kd_bd;
                                                            ?>
                                                            <tr>
                                                                <td colspan="6"><b><?php echo $row->nm_bd;?></b></td>
                                                            </tr>
                                                            <?php
                                                                }
                                                            ?>

                                                                <tr>
                                                                        <td scope="row"><?php echo $no; ?></td>
                                                                        <td><?php echo $row->kd_measurement; ?></td>
                                                                        <td><?php echo $row->nm_measurement; ?></td>
                                                                        <!-- <td align="right">
                                                                            <a href="#" class="m-badge m-badge--success m-badge--wide button_bobot_bd" 
                                                                                    data-id="<?php //echo $row->kd_measurement; ?>" 
                                                                                    data-id2="<?php //echo $row->kd_departemen; ?>" 
                                                                                    data-id3="<?php //echo $row->nip; ?>">
                                                                                <?php // echo $Persen_bd." %"; ?>
                                                                            </a>
                                                                        </td> -->
                                                                        <td align="right">
                                                                            <a href="#" class="m-badge m-badge--success m-badge--wide button_bobot_kpi" data-id="<?php echo $row->nip; ?>" data-total-persen="<?php echo $Persen_kpi; ?>"><?php echo $Persen_kpi." %"; ?></a>
                                                                        </td>
                                                                        <td align="center">
                                                                            <?php
                                                                            //if($row->total_target <= 0){
                                                                            ?>
                                                                            <!-- <a href="#" class="m-badge m-badge--danger m-badge--wide button_input_target" 
                                                                                    data-id="<?php //echo $row->kd_pkd; ?>" 
                                                                                    data-id2="<?php //echo $row->nip; ?>" 
                                                                                    data-thn="<?php //echo $row->tahun; ?>"
                                                                                    data-bln="<?php //echo $row->bulan; ?>">
                                                                                <?php //echo $this->lang->line('target_not_available')?>
                                                                                </a> -->
                                                                            <?php
                                                                            //}else{
                                                                            ?>
                                                                            <!-- <a href="#" class="m-badge m-badge--success m-badge--wide button_view_target" 
                                                                                    data-id="<?php //echo $row->kd_pk; ?>" 
                                                                                    data-id2="<?php //echo $row->kd_measurement; ?>" 
                                                                                    data-id3="<?php //echo $row->nip; ?>">
                                                                                <?php //echo $this->lang->line('target_view')?>
                                                                            </a> -->
                                                                            <a href="#" class="m-badge m-badge--success m-badge--wide button_view_target" 
                                                                                    data-id="<?php echo $row->kd_pkd; ?>">
                                                                                <?php echo $this->lang->line('target_view')?>
                                                                            </a>
                                                                            <?php
                                                                            //}
                                                                            ?>
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
				<div class="tab-pane " id="m_user_profile_tab_2">
                                     <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <div class="col-9">
                                                        <h4 class="m-form__section"><?php echo $this->lang->line('tab_kpi2')." ".$DataTahun; ?></h4>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <table class="table table-bordered table-hover custom-table" id="tbl_measurement">
                                                <thead>
                                                        <tr>
                                                                    <th>No</th>
                                                                    <th><?php echo $this->lang->line('bulan_efektif')?></th>
                                                                    <th><?php echo $this->lang->line('tahun_efektif')?></th>
                                                                    <th><?php echo $this->lang->line('kd_departemen')?></th>
                                                                    <th><?php echo $this->lang->line('deskripsi')?></th>
                                                                    <th></th>

                                                        </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no=1;
                                                    foreach($HistoryKPI->result() as $row)
                                                    {
                                                    ?>

                                                        <tr>
                                                                <td scope="row"><?php echo $no; ?></td>
                                                                <td><?php echo getNamaBulan($row->bulan); ?></td>
                                                                <td><?php echo $row->tahun; ?></td>
                                                                <td><?php echo $row->nm_departemen; ?></td>
                                                                <td><?php echo $row->deskripsi; ?></td>
                                                                <td>
                                                                    <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill button_view_kpi" data-id="<?php echo $row->kd_pk; ?>"><i class="la la-file-text"></i></a>
                                                                    <?php
                                                                    if($no==1){
                                                                    ?>
                                                                    <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-data" data-id="<?php echo $row->kd_pk; ?>" data-id2="<?php echo $row->nip; ?>" data-id3="<?php echo $DataTahun; ?>"><i class="la la-trash"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>
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
</div>
<div class="row">
    <div class="col-md-12">
        
        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg" m-portlet="true">
                <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                                <?php echo isset($result_header)?ucwords(strtolower($RowData->nama))." ".$result_header:""; ?>
                                        </h3>
                                </div>
                        </div>
                </div>
                <div class="m-portlet__body">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_3">
                            <thead>
                                    <tr>
                                            <th>No</th>
                                            <th><?php echo $this->lang->line('period')?></th>
                                            <!--<th><?php // echo $this->lang->line('score')?></th>-->
                                            <th><?php echo $this->lang->line('result')?></th>

                                    </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no=1;
                                foreach($HistoryPegawai->result() as $row){
                                    if(isset($row->bulan)){
                                        $period = getNamaBulanMin($row->bulan)." ".$row->tahun;
                                    }else{
                                        $period = $row->tahun;
                                    }
//                                    $score = $row->score_kpi*100;
                                ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $period; ?></td>
                                    <!--<td><?php // echo $score."%"; ?></td>-->
                                    <td><?php echo $row->point; ?></td>
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