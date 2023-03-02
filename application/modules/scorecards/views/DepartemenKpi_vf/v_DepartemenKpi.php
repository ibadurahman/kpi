<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-xl-4 col-lg-5">
		<div class="m-portlet m-portlet--full-height  ">
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
                            <div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="300" style="overflow:hidden; height: 300px">
                            
                            <div class="m-list-timeline">
                                <?php 
                                $No=1;
                                foreach($ListDepartemen->result() as $row)
                                {
                                    $Kode=$this->uri->segment(4);
                                    $cls="";
                                    if($row->kd_departemen==$Kode){
                                        $cls="m-list-timeline__badge--danger";
                                    }
                                    ?>     
                                        <div class="m-list-timeline__items">
                                            <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge <?php echo $cls; ?>"></span>
                                                    <span class="m-list-timeline__text">
                                                        <a href="<?php echo site_url('scorecards/DepartemenKpi/index/'.$row->kd_departemen."/".$DataTahun."/".$DataBulan)?>" class="nav-link">
                                                                <!--<i class="m-nav__link-icon flaticon-share"></i>-->
                                                                <span class="m-nav__link-text"><?php echo $row->nm_departemen; ?></span>
                                                        </a>
                                                    </span>
                                            </div>
                                        </div>  
                                <?php 
                                            $No++;
                                        } ?>      
                            </div>
                            </div>    
			</div>
		</div>
	</div>
    <?php 
    if(isset($DataDepartemen) and $DataDepartemen->num_rows()>0)
    {
        $RowData=$DataDepartemen->row();
    ?>
	<div class="col-xl-8 col-lg-7">
                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg" m-portlet="true">
                            <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text">
                                                            <?php //echo $this->lang->line('list_kpi_header')." ".$RowData->nm_departemen." ".$DataTahun; ?>
                                                    </h3>
                                            </div>
                                    </div>
                                    <div class="m-portlet__head-tools ">
                                            <ul class="m-portlet__nav">
                                                <?php 
                                                // if($DataDepartemenKpi->num_rows()<=0){
                                                // if($this->mion_auth->is_allowed('add_departemen_kpi')){ ?>
                                                    <li class="m-portlet__nav-item">
                                                        <a href="#" class="btn btn-success m-btn btn-sm m-btn--custom m-btn--icon m-btn--air" data-id="<?php //echo $RowData->kd_departemen; ?>" id="button_add_bobot" >
                                                                    <span>
                                                                            <i class="la la-plus "></i>
                                                                            <span><?php //echo $this->lang->line('button_new');?></span>
                                                                    </span>
                                                            </a>
                                                    </li>
                                                <?php //} 
                                                //}else{
                                                ?>
                                                <?php //if($this->mion_auth->is_allowed('edit_departemen_kpi')){ ?>
                                                    <li class="m-portlet__nav-item">
                                                        <a href="<?php //echo site_url('scorecards/DepartemenKpi/edit_form/'.$RowData->kd_departemen."/".$DataTahun."/".$DataBulan) ?>" class="btn btn-accent m-btn btn-sm m-btn--custom m-btn--icon m-btn--air" id="button_edit_target" >
                                                                    <span>
                                                                            <i class="la la-edit "></i>
                                                                            <span><?php //echo $this->lang->line('button_edit');?></span>
                                                                    </span>
                                                            </a>
                                                    </li>
                                                <?php //}  ?>
                                                <?php //if($this->mion_auth->is_allowed('delete_departemen_kpi')){ ?>
                                                    <li class="m-portlet__nav-item">
                                                        <a href="#" class="btn btn-danger m-btn btn-sm m-btn--custom m-btn--icon m-btn--air" id="button_delete" data-id="<?php //echo $RowData->kd_departemen; ?>" data-id2="<?php //echo $DataTahun; ?>">
                                                                    <span>
                                                                            <i class="la la-trash "></i>
                                                                            <span><?php //echo $this->lang->line('button_delete');?></span>
                                                                    </span>
                                                            </a>
                                                    </li>
                                                <?php 
                                                //} 
                                                //}?>
                                            </ul>
                                    </div>
                            </div>
                            <div class="m-portlet__body">
                                <table class="table table-bordered table-hover custom-table">
                                    <thead>
                                            <tr>
                                                        <th>No</th>
                                                        <th><?php //echo $this->lang->line('kd_measurement')?></th>
                                                        <th><?php //echo $this->lang->line('nm_measurement')?></th>
                                                        <th><?php //echo $this->lang->line('weightage_bd')." (%)"?></th>
                                                        <th><?php //echo $this->lang->line('weightage_kpi')." (%)"?></th>

                                            </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // $no=1;
                                        // $KdDBTemp="";
                                        // foreach($DataDepartemenKpi->result() as $row)
                                        // {
                                        //     $Persen_bd=round(($row->weightage_bd/$row->Tot_bobot_bd)*100,2);
                                        //     $Persen_kpi=round(($row->weightage_kpi/$row->Tot_bobot_kpi)*100,2);
                                        //         if($row->kd_bd!=$KdDBTemp){
                                        //         $KdDBTemp=$row->kd_bd;
                                        ?>
                                        <tr>
                                            <td colspan="5"><b><?php //echo $row->nm_bd;?></b></td>
                                        </tr>
                                        <?php
                                            //}
                                        ?>
                                        
                                            <tr>
                                                    <td scope="row"><?php //echo $no; ?></td>
                                                    <td><?php //echo $row->kd_measurement; ?></td>
                                                    <td><?php //echo $row->nm_measurement; ?></td>
                                                    <td align="right">
                                                        <a href="#" class="m-badge m-badge--success m-badge--wide button_bobot_bd" data-id="<?php //echo $row->kd_measurement; ?>" data-id2="<?php //echo $row->kd_departemen; ?>" data-total-persen="<?php //echo $Persen_bd; ?>"><?php //echo $Persen_bd." %"; ?></a>
                                                    </td>
                                                    <td align="right">
                                                        <a href="#" class="m-badge m-badge--success m-badge--wide button_bobot_kpi" data-id="<?php //echo $row->kd_departemen; ?>" data-total-persen="<?php //echo $Persen_kpi; ?>"><?php //echo $Persen_kpi." %"; ?></a>
                                                    </td>
                                            </tr>
                                        <?php 
                                        //         $no++;
                                        //     }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div> -->
                <div class="row">
                    <div class="col-12">
                        <div class="m-portlet m-portlet--mobile">
                            <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text">
                                                            <?php echo isset($input_header)?$input_header:""; ?>
                                                    </h3>
                                            </div>
                                    </div>
                            </div>
                            <div class="m-portlet__body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form class="m-form m-form--fit m-form--label-align-right form-horizontal">
                                                    <div class="m-form__heading">
								<h3 class="m-form__heading-title"><?php echo $this->lang->line('measurement_section1'); ?></h3>
                                                    </div>
                                                    <div class="form-group m-form__group m-form__section--first row">
                                                            <?php echo form_label($this->lang->line('kd_departemen'),'kd_departemen',array("class"=>"col-sm-4 col-form-label"));?>
                                                            <div class="col-sm-8">
                                                                <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->kd_departemen; ?></span>
                                                            </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                            <?php echo form_label($this->lang->line('nm_departemen'),'nm_departemen',array("class"=>"col-sm-4 col-form-label"));?>
                                                            <div class="col-sm-8">
                                                                <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->nm_departemen; ?></span>
                                                            </div>
                                                    </div>
                                        </form>        

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="m-portlet m-portlet--tab">
                                <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                        <span class="m-portlet__head-icon m--hide">
                                                                <i class="la la-gear"></i>
                                                        </span>
                                                        <h3 class="m-portlet__head-text">
                                                                <?php echo $RowData->nm_departemen." ".$this->lang->line('performance')." ". getNamaBulan($DataBulan)." ".$DataTahun; ?>
                                                        </h3>
                                                </div>
                                        </div>
                                </div>
                                <div class="m-portlet__body">
                                        <div id="basic-gauge" style="height: 300px;"></div>
                                </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="m-portlet m-portlet--tab">
                                <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                        <span class="m-portlet__head-icon m--hide">
                                                                <i class="la la-gear"></i>
                                                        </span>
                                                        <h3 class="m-portlet__head-text">
                                                               <?php echo $RowData->nm_departemen." ".$this->lang->line('performance_history'); ?>
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
                    <div class="col-md-12">
                        
                        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg" m-portlet="true">
                                <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                        <h3 class="m-portlet__head-text">
                                                                <?php echo isset($result_header)?$RowData->nm_departemen." ".$result_header:""; ?>
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
                                                            <!--<th><?php // echo $this->lang->line('score')?></th>-->
                                                            <th><?php echo $this->lang->line('result')?></th>

                                                    </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no=1;
                                                foreach($HistoryDepartemen->result() as $row){
//                                                    $score = $row->score_kpi*100;
                                                    $class="";
                                                    if($row->score_kpi_point<=1){
                                                       $class=" m--font-danger"; 
                                                    }else if($row->score_kpi_point<=3){
                                                       $class=" m--font-warning"; 
                                                    }else if($row->score_kpi_point>3){
                                                       $class=" m--font-accent"; 
                                                    }
                                                    $period="";
                                                    if(isset($row->bulan)) {
                                                        $period = getNamaBulanMin($row->bulan)." ".$row->tahun;
                                                    } else {
                                                        $period = $row->tahun;
                                                    }
                                                ?>
                                                <tr>
                                                    <td><?php echo $no; ?></td>
                                                    <td><?php echo $period; ?></td>
                                                    <!--<td><?php // echo $score."%"; ?></td>-->
                                                    <td align="right" class="<?php echo $class; ?>"><?php echo number_format($row->score_kpi_point,2); ?></td>
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
    <?php } ?>
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
                        <?php echo form_open('scorecards/DepartemenKpi/save',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
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