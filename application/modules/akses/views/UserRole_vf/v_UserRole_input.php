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
                                            <a href="<?php echo site_url('akses/UserRole'); ?>" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
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
                                <?php echo form_open('akses/UserRole/save',["class"=>"-form m-form--label-align-right m-form--state-","id"=>"form_input"]);
                                            echo form_input(array(
                                                         'name'          => 'StatusSave',
                                                         'id'            => 'StatusSave',
                                                         'type'         =>'hidden'
                                                 ));
                                ?>

					<!--begin: Form Body -->
					<div class="m-portlet__body">
						<div class="row">
							<div class="col-xl-8 offset-xl-2">
								<div class="m-form__section m-form__section--first">
                                                                        <div class="m-form__heading">
										<h3 class="m-form__heading-title"><?php echo $this->lang->line('header_section'); ?></h3>
									</div>
									<div class="form-group m-form__group row">
                                                                                <?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('name'),'name',['class'=>'col-xl-3 col-lg-3 col-form-label']);?>
										<div class="col-xl-9 col-lg-9">
                                                                                     <?php echo form_input(array(
                                                                                                                'name'          => 'name',
                                                                                                                'id'            => 'name',
                                                                                                                'class'         => 'form-control m-input',
                                                                                                                'placeholder'    => $this->lang->line('name')
                                                                                                        ),set_value('name'));
                                                                                    ?>
										</div>
									</div>
									<div class="form-group m-form__group row">
										<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('description'),'description',['class'=>'col-xl-3 col-lg-3 col-form-label']);?>
										<div class="col-xl-9 col-lg-9">
                                                                                    <?php echo form_textarea(array(
                                                                                                                'name'          => 'description',
                                                                                                                'id'            => 'description',
                                                                                                                'class'         => 'form-control m-input',
                                                                                                                'placeholder'    => $this->lang->line('description')
                                                                                                        ),set_value('description'));
                                                                                    ?>
										</div>
									</div>
								</div>
								<div class="m-separator m-separator--dashed m-separator--lg"></div>
								<div class="m-form__section">
									<div class="m-form__heading">
										<h3 class="m-form__heading-title">
											<?php echo $this->lang->line('list_permission'); ?>
										</h3>
									</div>
									<div class="col-12">
                                                                            <div class="m-portlet m-portlet--bordered m-portlet--bordered-semi m-portlet--rounded">
                                                                                
                                                                                <div class="m-portlet__body pt-5">
                                                                                    <?php
                                                                                                        $a=1;
                                                                                                        if(isset($ListPermission) and $ListPermission->num_rows()>0)
                                                                                                        {
                                                                                                            $TempMenu="";
                                                                                                            foreach($ListPermission->result() as $row)
                                                                                                            {
                                                                                                              if($TempMenu!=$row->kd_menu)
                                                                                                                {
                                                                                                                    $TempMenu=$row->kd_menu;
                                                                                                                    if($a==1)
                                                                                                                    {
                                                                                                                       echo '<div class="m-form__group form-group">
																<label>'.$this->lang->line('menu_'.$row->kd_menu).'</label>
																<div class="m-checkbox-list">'; 
                                                                                                                    }else{
                                                                                                                        echo '  </div>
                                                                                                                                </div><div class="m-form__group form-group">
																<label>'.$this->lang->line('menu_'.$row->kd_menu).'</label>
																<div class="m-checkbox-list">'; 
                                                                                                                    }
                                                                                        ?>
                                                                                                                <?php }?>
                                                                                                                <label class="m-checkbox m-checkbox--success">
															<?php echo form_checkbox(array(
                                                                                                                                                    'name'          => 'kd_permission['.$a.']',
                                                                                                                                                    'id'            => 'kd_permission'.$a,
                                                                                                                                                    'value'         => $row->kd_permission
                                                                                                                                            ),set_checkbox('kd_permission[]'));

                                                                                                                        echo $row->deskripsi; ?>
															<span></span>
														</label>


                                                                                                    <?php
                                                                                                                $a++;
                                                                                                            }
                                                                                                        }
                                                                                                        echo "</div></div>";
                                                                                           ?>

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

		<!--end::Portlet-->
	</div>
</div>