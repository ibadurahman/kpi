<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData=$DataPerspective->row();
?>
<div class="row">
	<div class="col-xl-3 col-lg-4">
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
                           
				<ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                                        <?php 
                                        foreach($ListPerspective->result() as $row)
                                        {
                                            $Kode=$this->uri->segment(4);
                                            $cls="";
                                            if($row->kd_perspective==$Kode){
                                                $cls="m-nav__item--active";
                                            }
                                        ?>
					<li class="m-nav__item <?php echo $cls; ?>">
                                            <a href="<?php echo site_url('scorecards/Perspective/view_form/'.$row->kd_perspective."/".$DataTahun."/".$DataBulan)?>" class="m-nav__link  m-nav__link--active">
							<!--<i class="m-nav__link-icon flaticon-profile-1"></i>-->
							<span class="m-nav__link-title">
								<span class="m-nav__link-wrap">
									<span class="m-nav__link-text"><?php echo $row->nm_perspective; ?></span>
									
								</span>
							</span>
						</a>
					</li>
                                        <?php } ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-xl-9 col-lg-8">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="m-portlet m-portlet--tab">
                                <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                        <span class="m-portlet__head-icon m--hide">
                                                                <i class="la la-gear"></i>
                                                        </span>
                                                        <h3 class="m-portlet__head-text">
                                                                <?php echo isset($result_header)?$RowData->nm_perspective." ".$result_header." ". getNamaBulan($DataBulan)." ".$DataTahun:""; ?>
                                                        </h3>
                                                </div>
                                        </div>
                                </div>
                                <div class="m-portlet__body">
                                        <div id="basic-gauge" style="height: 300px;"></div>
                                </div>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="m-portlet m-portlet--full-height">
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
                                                        <div class="form-group m-form__group m-form__section--first row">
                                                                <?php echo form_label($this->lang->line('kd_perspective'),'kd_perspective',array("class"=>"col-5 col-form-label"));?>
                                                                <div class="col-7">
                                                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->kd_ps; ?></span>
                                                                </div>
                                                        </div>
                                                        <div class="form-group m-form__group row">
                                                                <?php echo form_label($this->lang->line('nm_perspective'),'nm_perspective',array("class"=>"col-5 col-form-label"));?>
                                                                <div class="col-7">
                                                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->nm_perspective; ?></span>
                                                                </div>
                                                        </div>
                                                        <div class="form-group m-form__group row">
                                                                <?php echo form_label($this->lang->line('weightage')." ".$DataTahun,'weightage',array("class"=>"col-5 col-form-label"));?>
                                                                <div class="col-7">
                                                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $weightage." %"; ?></span>
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
                    
                </div>
		<div class="row">
                    <div class="col-md-12">

                        <div class="m-portlet m-portlet--tab">
                                <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                        <span class="m-portlet__head-icon m--hide">
                                                                <i class="la la-gear"></i>
                                                        </span>
                                                        <h3 class="m-portlet__head-text">
                                                                <?php echo isset($result_header)?$RowData->nm_perspective." Chart ".$DataTahun:""; ?> 
                                                        </h3>
                                                </div>
                                        </div>
                                </div>
                                <div class="m-portlet__body">
                                        <div id="m_amcharts_7" style="height: 400px;"></div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        
                        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg" m-portlet="true">
                                <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                        <h3 class="m-portlet__head-text">
                                                                <?php echo isset($result_header)?$RowData->nm_perspective." ".$result_header." ".$DataTahun:""; ?>
                                                        </h3>
                                                </div>
                                        </div>
                                </div>
                                <div class="m-portlet__body">
                                    <table class="table table-striped- table-bordered table-hover table-checkable custom-table" id="m_table_3">
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
                                                foreach($HistoryPerspective->result() as $row){
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
                                                    }else{
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
                                    <button type="submit" class="btn btn-success" id="tombol_submit">Submit</button>
                                    <button type="button" class="btn btn-accent" id="tombol_edit" data-id="">Edit</button>
                                    <button type="button" class="btn btn-secondary" id="tombol-cancel" data-dismiss="modal">Close</button>
				</div>
			<!--</form>-->
                        <?php echo form_close(); ?>
		</div>
	</div>
</div>