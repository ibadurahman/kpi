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
                <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
                    <div class="m-demo__preview" style="border: none; padding: 0;">
                        <ul class="m-nav m-nav--active-bg" id="m_nav" role="tablist">
                        <?php
                        if(isset($ListMeasurement))
                        {
                            $KdTemp='';
                            $No=1;
                            // $Kode=$this->uri->segment(4);
                            $Kode=$DataKdMeasurement;
                            $arr=$ListMeasurement->result_array();
                            $key = array_search($Kode, array_column($arr, 'kd_measurement'));
                            $bd=$arr[$key]['kd_bd'];
                            // echo $ps;
                            // die;
                            foreach ($ListMeasurement->result() as $row)
                            {
                                $cls="";
                                $show='';
                                $clsHeader='';
                                if($row->kd_measurement==$Kode){
                                    $cls="m-nav__item--active";
                                
                                }
                                if($row->kd_bd==$bd){
                                    $show='show';
                                    $clsHeader="m-nav__item--active";
                                }
                        ?>
                        <?php
                                if($KdTemp!=$row->kd_bd){
                                    $KdTemp=$row->kd_bd;
                                    $hrefLink='#m_nav_sub_'.$KdTemp;
                                    $hrefId='m_nav_sub_'.$KdTemp;
                                    if($No==1){
                        ?>
                            <li class="m-nav__item <?php //echo $clsHeader ?>">
                                <a class="m-nav__link" role="tab" id="m_nav_link_1" data-toggle="collapse" href="<?php echo  $hrefLink;?>" aria-expanded=" false">
                                    <span class="m-nav__link-title" style="width:90%">
                                        <span class="m-nav__link-wrap">
                                            <span class="m-nav__link-text"><?php echo  $row->nm_bd;?></span>
                                            <span class="m-nav__link-badge">
                                            <?php 
                                                        $clsWeightage="m-badge--success";
                                                        if($row->total_persen < 100){
                                                            $clsWeightage="m-badge--danger";
                                                        }
                                            ?>
                                                <span class="m-badge <?php echo $clsWeightage ?> m-badge--wide m-badge--rounded"><?php echo $row->total_persen."%"; ?></span>
                                            </span>
                                        </span>
                                    </span>
                                    <span class="m-nav__link-arrow"></span> 
                                </a>
                                <ul class="m-nav__sub collapse <?php echo $show ?>" id="<?php echo  $hrefId;?>" role="tabpanel" aria-labelledby="m_nav_link_1" data-parent="#m_nav">
                        <?php
                                    }else{
                        ?>
                                </ul>
                            </li>
                            <li class="m-nav__item <?php //echo $clsHeader ?>">
                                <a class="m-nav__link" role="tab" id="m_nav_link_1" data-toggle="collapse" href="<?php echo  $hrefLink;?>" aria-expanded=" false">
                                    <span class="m-nav__link-title" style="width:90%">
                                        <span class="m-nav__link-wrap">
                                            <span class="m-nav__link-text"><?php echo  $row->nm_bd;?></span>
                                            <span class="m-nav__link-badge">
                                            <?php 
                                                        $clsWeightage="m-badge--success";
                                                        if($row->total_persen < 100){
                                                            $clsWeightage="m-badge--danger";
                                                        }
                                            ?>
                                                <span class="m-badge <?php echo $clsWeightage ?> m-badge--wide m-badge--rounded"><?php echo $row->total_persen."%"; ?></span>
                                            </span>
                                        </span>
                                    </span>
                                    <span class="m-nav__link-arrow"></span> 
                                </a>
                                <ul class="m-nav__sub collapse <?php echo $show ?>" id="<?php echo  $hrefId;?>" role="tabpanel" aria-labelledby="m_nav_link_1" data-parent="#m_nav">
                        <?php                
                                    }
                                    
                                }
                        ?>
                                    <li class="m-nav__item <?php echo $cls ?>">
                                        <a href="<?php echo site_url('scorecards/Measurement/index/'.$row->kd_measurement."/".$DataTahun."/".$DataBulan)?>" class="m-nav__link">
                                            <!-- <span class="m-nav__link-bullet m-nav__link-bullet--line">
                                                <span></span>
                                            </span> -->
                                            <span class="m-nav__link-title">
                                                <span class="m-nav__link-wrap">
                                                    <span class="m-nav__link-text"><?php echo $row->nm_measurement." (".$row->kd_ms.")"; ?></span>
                                                    <span class="m-nav__link-badge">
                                                    <?php 
                                                        $clsWeightageDetail="m-badge--success";
                                                        if($row->weightage <= 0){
                                                            $clsWeightageDetail="m-badge--danger";
                                                        }
                                                    ?>
                                                        <span class="m-badge <?php echo $clsWeightageDetail; ?>"><?php echo $row->weightage."%"; ?></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                        <?php
                                $No++;
                            }
                        ?>
                            
                                </ul>
                            </li>
                        <?php
                        }
                        ?>
                            
                        </ul>
                    </div>
                </div>
                            <!-- <div class="m-scrollable" data-scrollbar-shown="true" data-scrollable="true" data-height="2000" style="overflow:hidden; height: 2000px">
                            
                            <div class="m-list-timeline">
                                <?php 
                                // $KdPerspectiveTemp="";
                                // $No=1;
                                // foreach($ListMeasurement->result() as $row)
                                // {
                                //     $Kode=$this->uri->segment(4);
                                //     $cls="";
                                //     if($row->kd_measurement==$Kode){
                                //         $cls="m-list-timeline__badge--danger";
                                //     }
                                //     if($KdPerspectiveTemp!=$row->kd_bd){
                                //         $KdPerspectiveTemp=$row->kd_bd;
                                
                                //         if($No==1){
                                    ?>
                                        <div class="menu-header-group">
                                            <span class="header-text m--font-primary"><?php //echo $row->nm_bd; ?></span>
                                            <span class="header-tambahan">
                                                <?php 
                                                            // $clsWeightage="m-badge--success";
                                                            // if($row->total_persen < 100){
                                                            //     $clsWeightage="m-badge--danger";
                                                            // }
                                                ?>
                                                <a href="#" class="m-badge <?php //echo $clsWeightage; ?> m-badge--wide button_bobot" data-id="<?php //echo $row->kd_bd; ?>" data-total-persen="<?php //echo $row->total_persen; ?>"><?php //echo $row->total_persen."%"; ?></a>
                                            </span>
                                        </div>
                                        <div class="m-list-timeline__items">
                                    <?php        
                                        //}else{
                                    ?>
                                        </div>
                                        <div class="menu-header-group">
                                            <span class="header-text m--font-primary"><?php //echo $row->nm_bd; ?></span>
                                            <span class="header-tambahan">
                                                <?php 
                                                            // $clsWeightage="m-badge--success";
                                                            // if($row->total_persen < 100){
                                                            //     $clsWeightage="m-badge--danger";
                                                            // }
                                                ?>
                                                <a href="#" class="m-badge <?php //echo $clsWeightage; ?> m-badge--wide button_bobot" data-id="<?php //echo $row->kd_bd; ?>" data-total-persen="<?php //echo $row->total_persen; ?>"><?php //echo $row->total_persen."%"; ?></a>
                                            </span>
                                        </div>
                                        <div class="m-list-timeline__items">
                                    <?php         
                                    //     }
                                    // }
                                ?>          
                                            <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge <?php //echo $cls; ?>"></span>
                                                    <span class="m-list-timeline__text">
                                                        <a href="<?php //echo site_url('scorecards/Measurement/index/'.$row->kd_measurement."/".$DataTahun."/".$DataBulan)?>" class="nav-link">
                                                                <span class="m-nav__link-text"><?php //echo $row->nm_measurement." (".$row->kd_ms.")"; ?></span>
                                                        </a>
                                                    </span>
                                                    <span class="m-list-timeline__time ">
                                                        <?php 
                                                            // $clsWeightageDetail="m-badge--success";
                                                            // if($row->weightage <= 0){
                                                            //     $clsWeightageDetail="m-badge--danger";
                                                            // }
                                                        ?>
                                                        <a href="#" class="m-badge <?php //echo $clsWeightageDetail; ?> m-badge--wide button_bobot" data-id="<?php //echo $row->kd_bd; ?>" data-id2="<?php //echo $row->kd_measurement; ?>" data-total-persen="<?php ///echo $row->total_persen; ?>"><?php //echo $row->weightage."%"; ?></a>
                                                    </span>
                                            </div>
                                <?php 
                                        //     $No++;
                                        // } ?>
                                    </div>        
                            </div>
                            </div>     -->
			</div>
		</div>
	</div>
    <?php 
    if($DataMeasurement->num_rows()>0)
    {
        $RowData=$DataMeasurement->row();
    ?>
	<div class="col-xl-8 col-lg-7">
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
                                                            <?php echo form_label($this->lang->line('kd_measurement'),'kd_measurement',array("class"=>"col-sm-4 col-form-label"));?>
                                                            <div class="col-sm-8">
                                                                <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->kd_ms; ?></span>
                                                            </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                            <?php echo form_label($this->lang->line('nm_measurement'),'nm_measurement',array("class"=>"col-sm-4 col-form-label"));?>
                                                            <div class="col-sm-8">
                                                                <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->nm_measurement; ?></span>
                                                            </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                            <?php echo form_label($this->lang->line('kd_bd'),'kd_bd',array("class"=>"col-sm-4 col-form-label"));?>
                                                            <div class="col-sm-8">
                                                                <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->nm_bd; ?></span>
                                                            </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                            <?php echo form_label($this->lang->line('weightage'),'weightage',array("class"=>"col-sm-4 col-form-label"));?>
                                                            <div class="col-sm-8">
                                                                <span class="col-form-label" style="padding-top: .85rem; display: inline-block">
                                                                    <?php 
                                                                        $clsWeightageDetail="m-badge--success";
                                                                        if($RowData->weightage <= 0){
                                                                            $clsWeightageDetail="m-badge--danger";
                                                                        }
                                                                    ?>
                                                                    <a href="#" class="m-badge <?php echo $clsWeightageDetail; ?> m-badge--wide button_bobot" data-id="<?php echo $RowData->kd_bd; ?>"data-id2="<?php echo $RowData->kd_measurement; ?>" data-total-persen="<?php echo $RowData->total_persen; ?>"><?php echo $RowData->weightage."%"; ?></a>
                                                                </span>
                                                                
                                                            </div>
                                                    </div>
                                                    <!-- <div class="m-form__heading">
								                    <h3 class="m-form__heading-title"><?php //echo $this->lang->line('measurement_section2'); ?></h3>
                                                    </div>
                                                    <div class="form-group m-form__group m-form__section--first row">
                                                            <?php //echo form_label($this->lang->line('unit'),'unit',array("class"=>"col-sm-4 col-form-label"));?>
                                                            <div class="col-sm-8">
                                                                <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php //echo $ListUnit[$RowData->unit]; ?></span>
                                                            </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                            <?php //echo form_label($this->lang->line('period'),'period',array("class"=>"col-sm-4 col-form-label"));?>
                                                            <div class="col-sm-8">
                                                                <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php //echo $ListPeriodAll[$RowData->period]; ?></span>
                                                            </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                            <?php //echo form_label($this->lang->line('aggregation'),'aggregation',array("class"=>"col-sm-4 col-form-label"));?>
                                                            <div class="col-sm-8">
                                                                <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php //echo $ListAggregation[$RowData->aggregation]; ?></span>
                                                            </div>
                                                    </div> -->
                                        </form>        

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- input target -->
                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg" m-portlet="true">
                            <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text">
                                                            <?php //echo $this->lang->line('list_header_target')." ".$DataTahun; ?>
                                                    </h3>
                                            </div>
                                    </div>
                                    <div class="m-portlet__head-tools ">
                                            <ul class="m-portlet__nav">
                                                <?php 
                                                //if($DataMT->num_rows()<=0){
                                                //if($this->mion_auth->is_allowed('add_measurement_target')){ ?>
                                                    <li class="m-portlet__nav-item">
                                                        <a href="<?php //echo site_url('scorecards/Measurement/target_insert_form/'.$RowData->kd_measurement) ?>" class="btn btn-success m-btn btn-sm m-btn--custom m-btn--icon m-btn--air" id="button_add_target" >
                                                                    <span>
                                                                            <i class="la la-plus "></i>
                                                                            <span><?php //echo $this->lang->line('button_new_target');?></span>
                                                                    </span>
                                                            </a>
                                                    </li>
                                                <?php 
                                                    //} 
                                                //}
                                                ?>
                                            </ul>
                                    </div>
                            </div>
                            <div class="m-portlet__body">
                                <table class="table table-striped- table-bordered table-hover table-checkable custom-table" id="m_table_1">
                                        <thead>
                                                <tr>
                                                        <th>No</th>
                                                        <th><?php //echo $this->lang->line('kd_mt')?></th>
                                                        <th><?php //echo $this->lang->line('bulan')?></th>
                                                        <th><?php //echo $this->lang->line('tahun')?></th>
                                                        <th><?php //echo $this->lang->line('deskripsi')?></th>
                                                        <th></th>
                                                </tr>
                                        </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div> -->
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
                                                                <?php echo $RowData->nm_measurement." ".$this->lang->line('performance')." ". getNamaBulan($DataBulan)." ".$DataTahun; ?>
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
                                                                <?php echo $RowData->nm_measurement." ".$this->lang->line('performance_history'); ?>
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
                                                                <?php echo isset($result_header)?$RowData->nm_measurement." ".$result_header:""; ?>
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
                                                            <!-- <th><?php //echo $this->lang->line('score')?></th> -->
                                                            <th><?php echo $this->lang->line('result')?></th>

                                                    </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no=1;
                                                foreach($HistoryMesurement->result() as $row){
                                                    $score = $row->result*100;
                                                    $class="";
                                                    if($row->point_result<=1){
                                                       $class=" m--font-danger"; 
                                                    }else if($row->point_result<=3){
                                                       $class=" m--font-warning"; 
                                                    }else if($row->point_result>3){
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
                                                    <!-- <td><?php //echo $score."%"; ?></td> -->
                                                    <td class="<?php echo $class; ?>"><?php echo $row->point_result; ?></td>
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
                        <?php echo form_open('scorecards/Measurement/save',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
			<!--<form class="m-form m-form--fit m-form--label-align-right">-->
				<div class="modal-body">
                                        
				</div>
				<div class="modal-footer">
                                    <button type="submit" class="btn btn-success" id="tombol_submit2">Submit</button>
                                    <button type="button" class="btn btn-accent" id="tombol_edit" data-id="">Edit</button>
                                    <button type="button" class="btn btn-secondary" id="tombol-cancel" data-dismiss="modal">Close</button>
				</div>
			<!--</form>-->
                        <?php echo form_close(); ?>
		</div>
	</div>
</div>