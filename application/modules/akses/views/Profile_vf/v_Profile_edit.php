<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData=$DataProfile->row();
?>

<div class="row">
	<div class="col-xl-3 col-lg-4">
		<div class="m-portlet m-portlet--full-height  ">
			<div class="m-portlet__body">
				<div class="m-card-profile">
					<div class="m-card-profile__title m--hide">
						Your Profile
					</div>
					<div class="m-card-profile__pic">
						<div class="m-card-profile__pic-wrapper">
                                                    <?php 
                                                        if($RowData->foto!=""){
                                                            $LinkFoto= base_url('assets/upload/foto/'.$RowData->foto);
                                                        }else{
                                                            $LinkFoto= base_url('assets/img/NoImage.png');
                                                        } 
                                                    ?>
							<img src="<?php echo $LinkFoto;?>" alt="" />
						</div>
					</div>
					<div class="m-card-profile__details">
						<span class="m-card-profile__name"><?php echo $RowData->first_name; ?></span>
						<a href="" class="m-card-profile__email m-link"><?php echo $RowData->email; ?></a>
					</div>
				</div>
				<ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
					<li class="m-nav__separator m-nav__separator--fit"></li>
					<li class="m-nav__section m--hide">
						<span class="m-nav__section-text">Section</span>
					</li>
					<li class="m-nav__item">
                                            <a href="<?php echo site_url('akses/User/view_form/'.$RowData->id)?>" class="m-nav__link">
							<i class="m-nav__link-icon flaticon-profile-1"></i>
							<span class="m-nav__link-title">
								<span class="m-nav__link-wrap">
									<span class="m-nav__link-text">My Profile</span>
									
								</span>
							</span>
						</a>
					</li>
                                        <?php if($this->mion_auth->is_allowed('activity_user')){ ?>
					<li class="m-nav__item">
						<a href="<?php echo site_url('akses/User/activity_form/'.$RowData->id)?>" class="m-nav__link">
							<i class="m-nav__link-icon flaticon-share"></i>
							<span class="m-nav__link-text">Activity</span>
						</a>
					</li>
                                        <?php } ?>
					
				</ul>
			</div>
		</div>
	</div>
	<div class="col-xl-9 col-lg-8">
		<div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-tools">
					<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
								<i class="flaticon-share m--hide"></i>
								Profile
							</a>
						</li>
                                                <?php if($this->mion_auth->is_allowed('change_password')){ ?>
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2" role="tab">
								Change Password
							</a>
						</li>
                                                <?php } ?>
					</ul>
				</div>
				
			</div>
			<div class="tab-content">
				<div class="tab-pane active" id="m_user_profile_tab_1">
                                        <?php echo form_open_multipart('akses/Profile/edit/'.$RowData->id,["class"=>"m-form m-form--fit m-form--label-align-right","id"=>"form_input"]); ?>
						<div class="m-portlet__body">
                                                        <div class="form-group m-form__group row">
                                                                <?php echo form_label($this->lang->line('nip'),'nip',array("class"=>"col-xl-2 col-lg-2 col-form-label"));?>
								<div class="col-xl-7 col-lg-7">
                                                                    <span class="col-form-label" style="padding-top: .85rem; display: inline-block"><?php echo $RowData->nip; ?></span>
                                                                    <?php /*echo form_dropdown('nip', 
                                                                                            $ListPegawai, 
                                                                                            set_value('nip',$RowData->nip),
                                                                                            "id='nip' style='width: 100%' class='select2-ajax form-control m-select2' 
                                                                                            data-placeholder='".$this->lang->line('nip')."'"); 
                                                                     * 
                                                                     */
                                                                            echo form_input(array(
                                                                                                'name'          => 'nip',
                                                                                                'id'            => 'nip',
                                                                                                'type'          => 'hidden',
                                                                                                'class'         => 'form-control m-input'
                                                                                        ),set_value('nip',$RowData->nip));         
                                                                    ?>
                                                                    <div class="error"></div>
								</div>
							</div>
							<div class="form-group m-form__group row">
                                                                <?php echo form_label($this->lang->line('username'),'username',array("class"=>"col-xl-2 col-lg-2 col-form-label"));?>
								<div class="col-xl-7 col-lg-7">
                                                                    <?php echo form_input(array(
                                                                                                'name'          => 'username',
                                                                                                'id'            => 'username',
                                                                                                'class'         => 'form-control m-input',
                                                                                                'placeholder'    => $this->lang->line('username')
                                                                                        ),set_value('username',$RowData->username));
                                                                        echo form_hidden('username_lama',$RowData->username);
                                                                    ?>
                                                                    <div class="error"></div>
								</div>
							</div>
							<div class="form-group m-form__group row">
                                                                <?php echo form_label($this->lang->line('email'),'email',array("class"=>"col-xl-2 col-lg-2 col-form-label"));?>
								<div class="col-xl-7 col-lg-7">
                                                                    <?php echo form_input(array(
                                                                                                'name'          => 'email',
                                                                                                'id'            => 'email',
                                                                                                'class'         => 'form-control m-input',
                                                                                                'placeholder'    => $this->lang->line('email')
                                                                                        ),set_value('email',$RowData->email));
                                                                    echo form_hidden('email_lama',$RowData->email);
                                                                    ?>
                                                                    <div class="error"></div>
								</div>
							</div>
                                                        <div class="form-group m-form__group row">
                                                                <?php echo form_label($this->lang->line('group'),'group',array("class"=>"col-xl-2 col-lg-2 col-form-label"));?>
								<div class="col-xl-7 col-lg-7">
                                                                    <?php echo form_dropdown('group', 
                                                                                            $ListGroup, 
                                                                                            set_value('group',$RowData->group_id),
                                                                                            "id='group' style='width: 100%' class='select2-ajax form-control m-select2' 
                                                                                            data-placeholder='".$this->lang->line('group')."'"); 

                                                                    ?>
                                                                    <div class="error"></div>
								</div>
							</div>
							<div class="form-group m-form__group row">
                                                                <?php echo form_label($this->lang->line('first_name'),'first_name',array("class"=>"col-xl-2 col-lg-2 col-form-label"));?>
								<div class="col-xl-7 col-lg-7">
                                                                    <?php echo form_input(array(
                                                                                                'name'          => 'first_name',
                                                                                                'id'            => 'first_name',
                                                                                                'class'         => 'form-control m-input',
                                                                                                'placeholder'    => $this->lang->line('first_name')
                                                                                        ),set_value('first_name',$RowData->first_name));
                                                                    ?>
                                                                    <div class="error"></div>
								</div>
							</div>
							<div class="form-group m-form__group row data_hidden">
                                                                <?php echo form_label($this->lang->line('dob'),'dob',array("class"=>"col-xl-2 col-lg-2 col-form-label"));?>
								<div class="col-xl-7 col-lg-7">
                                                                    <div class="input-group date">
                                                                        <?php echo form_input(array(
                                                                                                        'name'          => 'dob',
                                                                                                        'id'            => 'dob',
                                                                                                        'class'         => 'form-control m-input datepicker',
                                                                                                        'placeholder'    => $this->lang->line('dob')
                                                                                                ),set_value('dob',convert_date($RowData->dob)));
                                                                            ?>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-calendar glyphicon-th"></i>
										</span>
									</div>
                                                                    </div>
                                                                    <div class="error"></div>
								</div>
							</div>
							<div class="form-group m-form__group row data_hidden">
                                                                <?php echo form_label($this->lang->line('jenis_kelamin'),'jenis_kelamin',array("class"=>"col-xl-2 col-lg-2 col-form-label"));?>
								<div class="col-xl-7 col-lg-7">
                                                                    <div class="m-radio-inline">
                                                                            <label class="m-radio m-radio--solid">
                                                                                       <?php 
                                                                                           $StatusKelaminL=FALSE;
                                                                                           $StatusKelaminP=FALSE;
                                                                                           switch($RowData->jenis_kelamin){
                                                                                               case 'L': $StatusKelaminL=TRUE;break;
                                                                                               case 'P': $StatusKelaminP=TRUE;break;
                                                                                           }
                                                                                                   echo form_radio(array(
                                                                                                                       'name'          => 'jenis_kelamin',
                                                                                                                       'id'            => 'jenis_kelamin',
                                                                                                                       'value'         => 'L'
                                                                                                               ),'',set_radio('jenis_kelamin', 'L',$StatusKelaminL));
                                                                                                   echo $ListKelamin['L'];
                                                                                       ?>
                                                                                    <span></span>
                                                                            </label>
                                                                            <label class="m-radio m-radio--solid">
                                                                                       <?php 
                                                                                                   echo form_radio(array(
                                                                                                                       'name'          => 'jenis_kelamin',
                                                                                                                       'id'            => 'jenis_kelamin2',
                                                                                                                       'value'         => 'P'
                                                                                                               ),'',set_radio('jenis_kelamin', 'P',$StatusKelaminP));
                                                                                                   echo $ListKelamin['P'];
                                                                                       ?>
                                                                                    <span></span>
                                                                            </label>
                                                                    </div>
								</div>
							</div>
                                                        <div class="form-group m-form__group row">
								<?php echo form_label($this->lang->line('image'),'foto',['class'=>'col-xl-2 col-lg-2 col-form-label']);?>
								<div class="col-xl-7 col-lg-7">
                                                                    <?php echo form_upload(array(
                                                                                            'name'          => 'foto',
                                                                                            'id'            => 'foto',
                                                                                            'class'         => 'form-control m-input',
                                                                                            'placeholder'    => $this->lang->line('foto')
                                                                                    ),set_value('foto'));
                                                                        echo form_hidden("foto_lama",$RowData->foto);     
                                                                    ?>
                                                                    <div class="error"></div>
								</div>
							</div>
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
						<div class="m-portlet__foot m-portlet__foot--fit">
							<div class="m-form__actions">
								<div class="row">
									<div class="col-2">
									</div>
									<div class="col-7">
										<button type="submit" class="btn btn-brand m-btn m-btn--air m-btn--custom">Save</button>&nbsp;&nbsp;
                                                                                <button type="button" onclick="window.location='<?php echo site_url('akses/Profile'); ?>';" class="btn btn-secondary m-btn m-btn--md">Cancel</button>
									</div>
								</div>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
				<div class="tab-pane " id="m_user_profile_tab_2">
                                        <?php echo form_open('akses/User/change_password/'.$RowData->id,["class"=>"m-form m-form--fit m-form--label-align-right","id"=>"form_change_pass"]); ?>
                                        
						<div class="m-portlet__body">
							<div class="form-group m-form__group row">
                                                                <?php echo form_label($this->lang->line('old_pass'),'old_pass',array("class"=>"col-3 col-form-label"));?>
								<div class="col-7">
                                                                    <?php echo form_password(array(
                                                                                                'name'          => 'old_pass',
                                                                                                'id'            => 'old_pass',
                                                                                                'class'         => 'form-control m-input',
                                                                                                'placeholder'    => $this->lang->line('old_pass')
                                                                                        ),set_value('old_pass'));
                                                                    ?>
                                                                    <div class="error"></div>
								</div>
							</div>
							<div class="form-group m-form__group row">
                                                                <?php echo form_label($this->lang->line('new_pass'),'new_pass',array("class"=>"col-3 col-form-label"));?>
								<div class="col-7">
                                                                    <?php echo form_password(array(
                                                                                                'name'          => 'new_pass',
                                                                                                'id'            => 'new_pass',
                                                                                                'class'         => 'form-control m-input',
                                                                                                'placeholder'    => $this->lang->line('new_pass')
                                                                                        ),set_value('new_pass'));
                                                                    ?>
                                                                    <div class="error"></div>
								</div>
							</div>
							<div class="form-group m-form__group row">
                                                                <?php echo form_label($this->lang->line('cnew_pass'),'cnew_pass',array("class"=>"col-3 col-form-label"));?>
								<div class="col-7">
                                                                    <?php echo form_password(array(
                                                                                                'name'          => 'cnew_pass',
                                                                                                'id'            => 'cnew_pass',
                                                                                                'class'         => 'form-control m-input',
                                                                                                'placeholder'    => $this->lang->line('cnew_pass')
                                                                                        ),set_value('cnew_pass'));
                                                                    ?>
                                                                    <div class="error"></div>
								</div>
							</div>
							
						</div>
						<div class="m-portlet__foot m-portlet__foot--fit">
							<div class="m-form__actions">
								<div class="row">
									<div class="col-2">
									</div>
									<div class="col-7">
										<button type="submit" class="btn btn-brand m-btn m-btn--air m-btn--custom">Save</button>&nbsp;&nbsp;
                                                                                <button type="button" onclick="window.location='<?php echo site_url('akses/User'); ?>';" class="btn btn-secondary m-btn m-btn--md">Cancel</button>
									</div>
								</div>
							</div>
						</div>
					<?php echo form_close(); ?>
                                    
				</div>
				
			</div>
		</div>
	</div>
</div>