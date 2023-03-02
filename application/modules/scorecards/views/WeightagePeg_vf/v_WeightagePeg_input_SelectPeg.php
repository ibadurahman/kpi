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
                <?php echo form_open_multipart('scorecards/WeightagePeg/save_select_peg',["class"=>"-form m-form--label-align-right m-form--state-","id"=>"form_input2"]);
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
                                    <h3 class="m-form__heading-title">
                                        <?php echo $this->lang->line('header_input');?>
                                    </h3>
                                </div>
                                <div class="form-group m-form__group row">
                                    <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('tahun_efektif'),'tahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
                                    <div class="col-xl-9 col-lg-9">
                                        <?php echo form_dropdown('tahun', 
                                                    $ListTahun, 
                                                    set_value('tahun'),
                                                    "id='tahun' style='width: 100%' class='select2_non_clear form-control m-select2' 
                                                    data-placeholder='".$this->lang->line('tahun_efektif')."'"); 

                                        ?>
                                        <div class="error"></div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('bulan_efektif'),'tahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
                                    <div class="col-xl-9 col-lg-9">
                                        <?php echo form_dropdown('bulan', 
                                                                    $ListBulan, 
                                                                    set_value('bulan'),
                                                                    "id='bulan' style='width: 100%' class='select2 form-control m-select2' 
                                                                    data-placeholder='".$this->lang->line('bulan_efektif')."'"); 

                                        ?>
                                        <div class="error"></div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('deskripsi'),'deskripsi',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
                                    <div class="col-xl-9 col-lg-9">
                                        <?php echo form_input(array(
                                                                    'name'          => 'deskripsi',
                                                                    'id'            => 'deskripsi',
                                                                    'class'         => 'form-control m-input'
                                                            ),set_checkbox('deskripsi'));

                                        ?>
                                        <div class="error"></div>
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="m-form__section m-form__section--first">
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title"><?php echo $this->lang->line('select_peg'); ?></h3>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div id="nip"></div>
                                        <div class="error"></div>                     
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover custom-table">
                                                <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>#</th>
                                                            <th><?php echo $this->lang->line('nip')?></th>
                                                            <th><?php echo $this->lang->line('nama')?></th>
                                                            <th><?php echo $this->lang->line('kd_jabatan')?></th>
                                                                    
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no=1;
                                                    $KdDeptTemp="";
                                                    foreach($DataPeg->result() as $row)
                                                    {
                                                        if($row->kd_departemen!=$KdDeptTemp){
                                                            $KdDeptTemp=$row->kd_departemen;
                                                    ?>
                                                    <tr>
                                                        <td colspan="5"><b><?php echo $row->nm_departemen;?></b></td>
                                                    </tr>
                                                    <?php
                                                        }
                                                    ?>

                                                        <tr>
                                                            <td>
                                                                <?php echo form_checkbox(array(
                                                                                                    'name'          => 'nip[]',
                                                                                                    'id'            => 'nip'.$no,
                                                                                                    'value'         => $row->nip,
                                                                                                    'class'         => 'data_nip'
                                                                                            ),set_checkbox('nip'.$no));
                                                                ?>
                                                            </td>
                                                            <td scope="row"><?php echo $no; ?></td>
                                                            <td><?php echo $row->nip; ?></td>
                                                            <td><?php echo $row->nama; ?></td>
                                                            <td><?php echo $row->nm_jabatan; ?></td>
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
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
