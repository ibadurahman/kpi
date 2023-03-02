<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="m-section__content " id="user_role_section">
    
        
</div>

<div class="row">
        <div class="col-lg-12">

		<!--begin::Portlet-->
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
                                            <a href="<?php echo site_url('scorecards/Pegawai'); ?>" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
							<span>
								<i class="la la-arrow-left"></i>
								<span>Back</span>
							</span>
						</a>
						<div class="btn-group">
							<button type="button" class="btn btn-success  m-btn m-btn--icon m-btn--wide m-btn--md tombol-save">
								<span>
									<i class="la la-check"></i>
									<span>Save</span>
								</span>
							</button>
							<button type="button" class="btn btn-success  dropdown-toggle dropdown-toggle-split m-btn m-btn--md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							</button>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item tombol-save2" href="#">
									<i class="la la-plus"></i> Save & New</a>
								<a class="dropdown-item tombol-save" href="#">
									<i class="la la-undo"></i> Save & Close</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
                                <?php echo form_open_multipart('scorecards/WeightageCompany/save',["class"=>"-form m-form--label-align-right m-form--state-","id"=>"form_input"]);
                                            echo form_input(array(
                                                         'name'          => 'StatusSave',
                                                         'id'            => 'StatusSave',
                                                         'type'         =>'hidden'
                                                 ));
                                ?>

					<!--begin: Form Body -->
					<div class="m-portlet__body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="m-form__section m-form__section--first">
                                    <div class="m-form__heading">
                                        <h4 class="m-form__heading-title"><?php echo $this->lang->line('header_input'); ?></h4>
                                    </div>
                                    <div class="m-separator  m-separator--sm"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group m-form__group">
                                                    <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('deskripsi'),'deskripsi');?>
                                                        <?php echo form_input(array(
                                                                                    'name'          => 'deskripsi',
                                                                                    'id'            => 'deskripsi',
                                                                                    'class'         => 'form-control m-input',
                                                                                    'placeholder'    => $this->lang->line('deskripsi')
                                                                            ),set_value('deskripsi'));
                                                        ?>
                                                <div class="error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group m-form__group">
                                                    <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('bulan'),'bulan');?>
                                                    <?php echo form_dropdown('bulan', 
                                                                                $ListBulan, 
                                                                                set_value('bulan'),
                                                                                "id='bulan' style='width: 100%' class='select2 form-control m-select2' 
                                                                                data-placeholder='".$this->lang->line('bulan')."'"); 

                                                    ?>
                                                <div class="error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group m-form__group">
                                                    <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('tahun'),'tahun');?>
                                                    <?php echo form_dropdown('tahun', 
                                                                                $ListTahun, 
                                                                                set_value('tahun'),
                                                                                "id='tahun' style='width: 100%' class='select2 form-control m-select2' 
                                                                                data-placeholder='".$this->lang->line('tahun')."'"); 

                                                    ?>
                                                <div class="error"></div>
                                            </div>
                                        </div>
                                    </div>
                                                                 
								</div>                  
                            </div>
                        </div>
						<div class="row">
							<div class="col-md-12">
                                <div class="form-group m-form__group m--margin-top-20">
                                    <div class="m-form__heading">
                                        <h4 class="m-form__heading-title"><?php echo $this->lang->line('bobot_perspective'); ?></h4>
                                    </div>
                                    <div class="m-separator  m-separator--sm"></div>
                                    <div class="m-section__content " id="alert_error_section"></div>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                                <tr>
                                                        <th>#</th>
                                                        <th width="100"><?php echo $this->lang->line('kd_perspective');?></th>
                                                        <th><?php echo $this->lang->line('nm_perspective');?></th>
                                                        <th width="150"><?php echo $this->lang->line('weightage');?></th>
                                                        <th width="100"><?php echo "Total (%)";?></th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no=1;
                                            foreach($DataPerspective->result() as $row)
                                            {
                                            ?>
                                                <tr>
                                                        <td scope="row"><?php echo $no; ?></td>
                                                        <td>
                                                            <?php echo form_input(array(
                                                                                        'name'          => 'kd_ps[]',
                                                                                        'id'            => 'kd_ps'.$no,
                                                                                        'class'         => 'form-control m-input ',
                                                                                        'placeholder'    => $this->lang->line('kd_ps'),
                                                                                        'readonly'      => true
                                                                                ),set_value('kd_ps'.$no,$row->kd_ps));
                                                            
                                                                    echo form_input(array(
                                                                                        'name'          => 'kd_perspective[]',
                                                                                        'id'            => 'kd_perspective'.$no,
                                                                                        'class'         => 'form-control m-input ',
                                                                                        'placeholder'    => $this->lang->line('kd_perspective'),
                                                                                        'type'      => 'hidden'
                                                                                ),set_value('kd_perspective'.$no,$row->kd_perspective));            
                                                            ?>
                                                            <div class="error"></div>
                                                        </td>
                                                        <td>
                                                            <?php echo form_input(array(
                                                                                        'name'          => 'nm_perspective[]',
                                                                                        'id'            => 'nm_perspective'.$no,
                                                                                        'class'         => 'form-control m-input',
                                                                                        'placeholder'    => $this->lang->line('nm_perspective'),
                                                                                        'readonly'      => true
                                                                                ),set_value('nm_perspective'.$no,$row->nm_perspective));
                                                            ?>
                                                            <div class="error"></div>
                                                        </td>
                                                        <td>
                                                            <?php echo form_input(array(
                                                                                        'name'          => 'weightage[]',
                                                                                        'id'            => 'weightage'.$no,
                                                                                        'class'         => 'form-control m-input list-weightage',
                                                                                        'placeholder'    => $this->lang->line('weightage'),
                                                                                        'type'  => 'number'
                                                                                ),set_value('weightage'.$no));
                                                            ?>
                                                            <div class="error"></div>
                                                        </td>
                                                        <td scope="row" align="right" id="<?php echo "bobot".$no; ?>"></td>
                                                </tr>
                                            <?php 
                                                    $no++;
                                                }
                                            ?>
                                                <tr>
                                                    <td colspan="3" align="right"><b>Total</b></td>
                                                    <td id="total"></td>
                                                    <td id="total_persen" align="right"></td>
                                                    <?php echo form_input(array(
                                                                                        'name'          => 'total_bobot',
                                                                                        'id'            => 'total_bobot',
                                                                                        'type'  => 'hidden'
                                                                                ),set_value('total_bobot'));
                                                            ?>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
								
								
							</div>
                            
						</div>
                        <div class="row">
							<div class="col-md-12">
                                <div class="form-group m-form__group m--margin-top-20">
                                    <div class="m-form__heading">
                                        <h4 class="m-form__heading-title"><?php echo $this->lang->line('bobot_bd'); ?></h4>
                                    </div>
                                    <div class="m-separator  m-separator--sm"></div>
                                    <div class="m-section__content " id="alert_error_bd"></div>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                                <tr>
                                                        <th>#</th>
                                                        <th width="100"><?php echo $this->lang->line('kd_bd');?></th>
                                                        <th><?php echo $this->lang->line('nm_bd');?></th>
                                                        <th><?php echo $this->lang->line('nm_perspective');?></th>
                                                        <th width="150"><?php echo $this->lang->line('weightage');?></th>
                                                        <th width="100"><?php echo "Total (%)";?></th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no=1;
                                            $Total=0;
                                            $Total_persen=0;
                                            foreach($DataBD->result() as $row)
                                            {
                                                // $Total=$Total+$row->weightage;
                                                // $Total_persen=$Total_persen+$row->bobot;
                                            ?>
                                                <tr>
                                                        <td scope="row"><?php echo $no; ?></td>
                                                        <td> 
                                                            <?php echo $row->kd_bds; ?>
                                                            <?php echo form_input(array(
                                                                                        'name'          => 'kd_bds[]',
                                                                                        'id'            => 'kd_bds'.$no,
                                                                                        'class'         => 'form-control m-input ',
                                                                                        'placeholder'    => $this->lang->line('kd_bds'),
                                                                                        'type'      => 'hidden'
                                                                                ),set_value('kd_bds'.$no,$row->kd_bds));
                                                            
                                                                    echo form_input(array(
                                                                                        'name'          => 'kd_bd[]',
                                                                                        'id'            => 'kd_bd'.$no,
                                                                                        'class'         => 'form-control m-input ',
                                                                                        'placeholder'    => $this->lang->line('kd_bd'),
                                                                                        'type'      => 'hidden'
                                                                                ),set_value('kd_bd'.$no,$row->kd_bd));            
                                                            ?>
                                                            <div class="error"></div>
                                                        </td>
                                                        <td> 
                                                            <?php echo $row->nm_bd; ?>
                                                            <?php echo form_input(array(
                                                                                        'name'          => 'nm_bd[]',
                                                                                        'id'            => 'nm_bd'.$no,
                                                                                        'class'         => 'form-control m-input',
                                                                                        'placeholder'    => $this->lang->line('nm_bd'),
                                                                                        'type'      => 'hidden'
                                                                                ),set_value('nm_bd'.$no,$row->nm_bd));
                                                            ?>
                                                            <div class="error"></div>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->nm_perspective; ?>                    
                                                            <?php echo form_input(array(
                                                                                        'name'          => 'nm_ps[]',
                                                                                        'id'            => 'nm_ps'.$no,
                                                                                        'class'         => 'form-control m-input',
                                                                                        'placeholder'    => $this->lang->line('nm_ps'),
                                                                                        'type'      => 'hidden'
                                                                                ),set_value('nm_ps'.$no,$row->nm_perspective));
                                                            ?>
                                                            <div class="error"></div>
                                                        </td>
                                                        <td>
                                                            <?php echo form_input(array(
                                                                                        'name'          => 'weightage_bd[]',
                                                                                        'id'            => 'weightage_bd'.$no,
                                                                                        'class'         => 'form-control m-input list-weightage',
                                                                                        'placeholder'    => $this->lang->line('weightage'),
                                                                                        'type'  => 'number'
                                                                                ),set_value('weightage_bd'.$no));
                                                            ?>
                                                            <div class="error"></div>
                                                        </td>
                                                        <td scope="row" align="right" id="<?php echo "bobot".$no; ?>"><?php //echo $row->bobot."%"; ?></td>
                                                </tr>
                                            <?php 
                                                    $no++;
                                                }
                                            ?>
                                                <tr>
                                                    <td colspan="3" align="right"><b>Total</b></td>
                                                    <td id="total"><?php echo $Total; ?></td>
                                                    <td id="total_persen" align="right"><?php //echo $Total_persen."%"; ?></td>
                                                    <?php echo form_input(array(
                                                                                        'name'          => 'total_bobot',
                                                                                        'id'            => 'total_bobot',
                                                                                        'type'  => 'hidden'
                                                                                ),set_value('total_bobot'));
                                                            ?>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
								
								
							</div>
                            
						</div>
					</div>
                                <?php echo form_close(); ?>
			</div>
		</div>

		<!--end::Portlet-->
	</div>
</div>