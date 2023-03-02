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
                                            <a href="<?php echo site_url('akses/Profile/index/'.$RowData->id)?>" class="m-nav__link">
							<i class="m-nav__link-icon flaticon-profile-1"></i>
							<span class="m-nav__link-title">
								<span class="m-nav__link-wrap">
									<span class="m-nav__link-text">My Profile</span>
									
								</span>
							</span>
						</a>
					</li>
                                        <?php if($this->mion_auth->is_allowed('activity_user')){ ?>
					<li class="m-nav__item m-menu__item--active">
						<a href="<?php echo site_url('akses/Profile/activity_form/'.$RowData->id)?>" class="m-nav__link">
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
		<div class="m-portlet m-portlet--full-height ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo isset($activity_header)?$activity_header:""; ?>
						</h3>
					</div>
				</div>
                                <div class="m-portlet__head-tools">
                                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>
                                    </div>
				</div>
				
			</div>
			<div class="m-portlet__body">
                            <div class="m-scrollable" id="list-timeline" data-scrollable="true" data-height="400" style="height: 400px; overflow: hidden;">
							
						</div>
			</div>
		</div>
	</div>
</div>