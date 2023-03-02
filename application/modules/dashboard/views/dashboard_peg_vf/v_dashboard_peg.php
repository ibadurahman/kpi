<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData = $DataPegawai->row();
?>
<!--Begin::Section Data Pegawai-->
<div class="row">
    <div class="col-lg-4">
        <div class="m-portlet m-portlet--tab m-portlet--full-height">
                
                <div class="m-portlet__body">
                        <div class="m-form__section m-form__section--first">
                            
                            <div class="form-group m-form__group">
                                    <div class="col-sm-12">
                                        <?php 
                                            if($RowData->foto!=""){
                                                $LinkFoto= base_url('assets/upload/foto/'.$RowData->foto);
                                            }else{
                                                $LinkFoto= base_url('assets/img/NoImage.png');
                                            } 
                                        ?>
                                        <div id="image-holder"><img src="<?php echo $LinkFoto;?>" class="thumb-image" style="width: 210px; height: 320px;"/></div>
                                    </div>
                            </div>
                        </div>
                </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg" m-portlet="true">
            <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
								<?php echo $this->lang->line('detail_pegawai'); ?>
							</h3>
                            </div>
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
                    <div class="col-md-6">
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
                    <div class="col-md-6">
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
                                       <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo ucwords(strtolower($RowData->nm_atasan)); ?></span>
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
<!--End::Section Data Pegawai-->
<!--Begin::Section Data KPI-->
<div class="row mb-3">
	<div class="col-md-5">
            <div class="m-portlet m-portlet--tab m-portlet--full-height">
<!--                    <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                            <span class="m-portlet__head-icon m--hide">
                                                    <i class="la la-gear"></i>
                                            </span>
                                            <h3 class="m-portlet__head-text">
                                                    <?php // echo $this->lang->line('company_score'); ?>
                                            </h3>
                                    </div>
                            </div>
                    </div>-->
                    <div class="m-portlet__body">
                        <div class="mt-5" id="basic-gauge" style="height: 300px;"></div>
                    </div>
            </div>
        </div>
    <div class="col-md-7">
	<!--begin:: Widgets/New Users-->
	<div class="m-portlet m-portlet--full-height ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('dept_detail'); ?>
						</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<ul class="nav nav-pills nav-pills--success m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_widget4_tab1_content" role="tab">
								<?php echo $this->lang->line('tab_company_grafik'); ?>
							</a>
						</li>
                        <?php 
                        if(isset($detail_kpi)){
                        ?>
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_widget4_tab2_content" role="tab">
								<?php echo $this->lang->line('tab_company_detail'); ?>
							</a>
						</li>
                        <?php
                        }
                        ?>
					</ul>
				</div>
			</div>
			<div class="m-portlet__body">
				<div class="tab-content">
					<div class="tab-pane active" id="m_widget4_tab1_content">

						<!--begin::Widget 14-->
						<div class="m-widget4">

							<div id="m_amcharts_7" style="height: 300px;"></div>
						</div>

						<!--end::Widget 14-->
					</div>
                    <?php 
                    if(isset($detail_kpi)){
                    ?>
					<div class="tab-pane" id="m_widget4_tab2_content">

						<!--begin::Widget 14-->
						<div class="m-widget11">
							<div class="table-responsive">

								<!--begin::Table-->
								<table class="table">

									<!--begin::Thead-->
									<thead>
										<tr>
											<td class="m-widget11__label">#</td>
											<td class="m-widget11__app"><?php echo $this->lang->line('measurement'); ?></td>
											<td class="m--align-right m-widget11__sales"><?php echo $this->lang->line('gross_score'); ?></td>
											<td class="m--align-right m-widget11__price"><?php echo $this->lang->line('weightage'); ?></td>
											<td class="m-widget11__total m--align-right"><?php echo $this->lang->line('score'); ?></td>
										</tr>
									</thead>

									<!--end::Thead-->

									<!--begin::Tbody-->
									<tbody>
                                                                            <?php 
                                                                                if(isset($detail_kpi)){
                                                                                    $no=1;
                                                                                    $TotScore=0;
                                                                                    foreach($detail_kpi->result() as $row)
                                                                                    {
                                                                            ?>
										<tr>
											<td>
												<span class="m-widget11__title"><?php echo $no; ?></span>
											</td>
											<td>
												<span class="m-widget11__title"><?php echo $row->nm_measurement; ?></span>
												<!--<span class="m-widget11__sub">Vertex To By Again</span>-->
											</td>
											<td class="m--align-right"><?php echo $row->point_result; ?></td>
											<td class="m--align-right"><?php echo $row->weightage_kpi; ?></td>
											<td class="m--align-right m--font-brand"><?php echo $row->score_kpi; ?></td>
										</tr>
                                                                            <?php   
                                                                                        $TotScore=$TotScore+$row->score_kpi;
                                                                                        $no++;
                                                                                    }
                                                                                }
                                                                            ?>
                                                                                <tr>
                                                                                    <td colspan="4" class="m--align-right">
                                                                                        <span class="m-widget11__title"><?php echo $this->lang->line('tot_score'); ?></span>
                                                                                    </td>
                                                                                    <td class="m--align-right m--font-brand"><?php echo $TotScore; ?></td>
                                                                                </tr>
									</tbody>

									<!--end::Tbody-->
								</table>

								<!--end::Table-->
							</div>
<!--							<div class="m-widget11__action m--align-right">
								<button type="button" class="btn m-btn--pill btn-outline-brand m-btn m-btn--custom">Import Report</button>
							</div>-->
						</div>

						<!--end::Widget 14-->
					</div>
                    <?php
                    }
                    ?>
				</div>
			</div>
		</div>

	<!--end:: Widgets/New Users-->
    </div>
</div>
<?php 
if(isset($detail_kpi)){
?>
<div class="row">
    <div class="col-md-12">
	<!--begin:: Widgets/New Users-->
	<div class="m-portlet m-portlet--full-height ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('ms_detail'); ?>
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
            <?php
                foreach($detail_kpi->result() as $row)
                {
            ?>
                <div class="m-form__heading">
                        <h5 class="m-form__heading-title"><?php echo $row->nm_measurement;?></h5>
                </div>
                <table class="table table-bordered table-hover m-table m-table--head-bg-primary">
                    <thead>
                        <tr>
                            <th colspan="2" style="text-align: center;"><?php echo $this->lang->line("formula");?></th>
                            <th><?php echo $this->lang->line("target");?></th>
                            <th><?php echo $this->lang->line("actual");?></th>
                            <th><?php echo $this->lang->line("targetvactual");?></th>
                            <th><?php echo $this->lang->line("point_result");?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $formula=json_decode($row->formula,true);
                        krsort($formula);
                        $i=1;
                        foreach($formula as $dataFormula){
                            
                        ?>
                        <tr>
                            <td width="100" align="center">
                                <?php
                                    echo $dataFormula['score'];
                                ?>
                            </td>
                            <td width="100" align="center">
                                <?php
                                    echo $ListOperator[$dataFormula['operator']]." ".$dataFormula['label'];
                                
                                ?>
                            </td>
                            <?php if($i==1){ ?>		
                            <td width="200" align="right" rowspan="4">
                                <?php echo $row->target_label;?>
                            </td>
                            <td width="200"  align="right" rowspan="4">
                                <?php echo number_to_money($row->actual);?>
                            </td>
                            <td width="200"  align="right" rowspan="4">
                                <?php 
                                    if($row->status_calculate == 1){
                                        echo number_to_money($row->result)."%";
                                    }else{
                                        echo number_to_money($row->result);
                                    }
                                    
                                ?>
                            </td>
                            <td width="200"  align="right" rowspan="4">
                                <?php echo $row->point_result;?>
                            </td>
                            <?php
                            }
                            ?>
                        </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            
            <?php
                }
            ?>
			</div>
		</div>

	<!--end:: Widgets/New Users-->
    </div>
</div>
<!--End::Section Data KPI-->
<?php
}
?>
<?php 
if(isset($detail_kpi_thn)){
?>
<div class="row">
    <div class="col-md-12">
	<!--begin:: Widgets/New Users-->
	<div class="m-portlet m-portlet--full-height ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('kpi_detail_thn')." ".$DataTahun; ?>
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
                <table class="table table-bordered table-hover m-table m-table--head-bg-primary">
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line("period");?></th>
                            <th><?php echo $this->lang->line("kd_departemen");?></th>
                            <th><?php echo $this->lang->line("kd_jabatan");?></th>
                            <th><?php echo $this->lang->line("score");?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($detail_kpi_thn->result() as $row){
                            if(isset($row->bulan)){
                                $period = getNamaBulanMin($row->bulan)." ".$row->tahun;
                            }else{
                                $period = $row->tahun;
                            }
                        ?>
                        <tr>
                            <td width="100" align="center">
                                <?php
                                    echo $period;
                                ?>
                            </td>
                            <td width="200">
                                <?php
                                    echo $row->nm_departemen;
                                
                                ?>
                            </td>	
                            <td width="200">
                                <?php echo $row->nm_jabatan;?>
                            </td>
                            <td width="100"  align="right">
                                <?php echo $row->point;?>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            
			</div>
		</div>

	<!--end:: Widgets/New Users-->
    </div>
</div>
<!--End::Section Data KPI-->
<?php
}
?>		
		