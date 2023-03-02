<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="m-section__content " id="user_role_section"></div>
<div class="row">
    <div class="col-lg-12">
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
        <div class="m-portlet__head">
				<div class="m-portlet__head-progress">

					<!-- here can place a progress bar-->
				</div>
				<div class="m-portlet__head-wrapper">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
<!--							<span class="m-portlet__head-icon">
								<i class="flaticon-map-location"></i>
							</span>-->
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
						<div class="btn-group">
							<button type="button" class="btn btn-success  m-btn m-btn--icon m-btn--wide m-btn--md tombol-save">
								<span>
                                    <span>Next</span>&nbsp;
									<i class="la la-arrow-right"></i>
								</span>
							</button>
						</div>
					</div>
				</div>
			</div>
            <div class="m-portlet__body">
                <?php echo form_open_multipart('scorecards/WeightagePeg/save_select_ms',["class"=>"-form m-form--label-align-right m-form--state-","id"=>"form_input2"]);
                            echo form_input(array(
                                        'name'          => 'StatusSave',
                                        'id'            => 'StatusSave',
                                        'type'         =>'hidden'
                                ));
                            echo form_hidden('DataPage1',$DataPage1);
                ?>
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="m-form__section m-form__section--first">
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title">
                                        <?php echo $this->lang->line('header_input');?>
                                    </h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <?php echo form_label($this->lang->line('tahun_efektif'),'tahun_efektif',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                    <div class="col-7">
                                        <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $Info->ThnEfektif; ?></span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <?php echo form_label($this->lang->line('bulan_efektif'),'bulan_efektif',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                    <div class="col-7">
                                        <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo getNamaBulan($Info->BlnEfektif); ?></span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <?php echo form_label($this->lang->line('deskripsi'),'deskripsi',array("class"=>"col-5 col-form-label m--font-boldest txt_align_right"));?>
                                    <div class="col-7">
                                        <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $Info->Deskripsi; ?></span>
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="m-section">
                                <h3 class="m-section__heading"><?php echo $this->lang->line('select_ms'); ?></h3>
                                <hr>
                                <div class="m-section__content">
                                    <?php
                                        $KdDeptTemp="";
                                    foreach($DataMs['dept'] as $key=>$val){
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="m-form__section m-form__section--first">
                                                    <!-- <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title"><?php //echo $val; ?></h3>
                                                        
                                                    </div> -->
                                                    <h3 class="m-section__heading"><?php echo $val; ?></h3>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-md-4">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <span class="m-list-search__result-category m-list-search__result-category--first"><?php echo $this->lang->line('list_peg'); ?></span>
                                                                    <?php
                                                                    foreach($DataPeg[$key] as $keyPeg=>$valPeg){
                                                                    ?>
                                                                    <div class="m-list-search__result-item">
                                                                        <span class="m-list-search__result-item-text"><?php echo $valPeg['nama']." (".$keyPeg.")"; ?></span>
                                                                    </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="m-list-search">
                                                                <div class="m-list-search__results">
                                                                    <span class="m-list-search__result-category m-list-search__result-category--first"><?php echo $this->lang->line('select_ms'); ?></span>
                                                                    
                                                                </div>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover custom-table">
                                                                        <thead>
                                                                                <tr>
                                                                                    <th></th>
                                                                                    <th>#</th>
                                                                                    <th><?php echo $this->lang->line('kd_measurement')?></th>
                                                                                    <th><?php echo $this->lang->line('nm_measurement')?></th>
                                                                                            
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $no=1;
                                                                            $KdDeptTemp="";
                                                                            foreach($DataMs['ms'][$key] as $keyMs=>$rowMs)
                                                                            {
                                                                            ?>

                                                                                <tr>
                                                                                    <td>
                                                                                        <?php echo form_checkbox(array(
                                                                                                                            'name'          => 'kd_ms[]',
                                                                                                                            'id'            => 'kd_ms'.$keyMs,
                                                                                                                            'value'         => $keyMs,
                                                                                                                            'class'         => 'data_ms'
                                                                                                                    ),set_checkbox('kd_ms'.$no));
                                                                                        ?>
                                                                                    </td>
                                                                                    <td scope="row"><?php echo $no; ?></td>
                                                                                    <td><?php echo $rowMs['kd_ms']; ?></td>
                                                                                    <td><?php echo $rowMs['nm_measurement']; ?></td>
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
                                    <hr>
                                    <?php
                                            
                                        }
                                    ?>
                                    
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
