<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
	<div class="m-container m-container--fluid m-container--full-height">
		<div class="m-stack m-stack--ver m-stack--desktop">

			<!-- BEGIN: Brand -->
			<div class="m-stack__item m-brand  m-brand--skin-dark ">
				<div class="m-stack m-stack--ver m-stack--general">
					<div class="m-stack__item m-stack__item--middle m-brand__logo">
                                            <a href="<?php echo site_url('dashboard/Home'); ?>" class="m-brand__logo-wrapper header-link-custom" style="">
							<!--<img alt="" src="<?php //echo base_url();?>assets/metronic/assets/demo/default/media/img/logo/logo_default_dark.png" />-->
                                                    <h2>Phronesis</h2>
						</a>
					</div>
					<div class="m-stack__item m-stack__item--middle m-brand__tools">

						<!-- BEGIN: Left Aside Minimize Toggle -->
						<a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
							<span></span>
						</a>

						<!-- END -->

						<!-- BEGIN: Responsive Aside Left Menu Toggler -->
						<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
							<span></span>
						</a>

						<!-- END -->

						<!-- BEGIN: Responsive Header Menu Toggler -->
						<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
							<span></span>
						</a>

						<!-- END -->

						<!-- BEGIN: Topbar Toggler -->
						<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
							<i class="flaticon-more"></i>
						</a>

						<!-- BEGIN: Topbar Toggler -->
					</div>
				</div>
			</div>

			<!-- END: Brand -->
			<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

				<!-- BEGIN: Horizontal Menu -->
				<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
					<i class="la la-close"></i>
				</button>
				<?php 
				if(isset($NamaPerusahaan))
				{
				?>
				<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
					<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                                                <?php 
                                                if ($this->mion_auth->in_group(1)){
                                                ?>
						<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
							<a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link">
								<i class="m-menu__link-icon flaticon-map"></i>
								<span class="m-menu__link-text">Company</span>
								<i class="m-menu__hor-arrow la la-angle-down"></i>
								<i class="m-menu__ver-arrow la la-angle-right"></i>
							</a>
							<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
								<span class="m-menu__arrow m-menu__arrow--adjust"></span>
								<ul class="m-menu__subnav">
                                                                    <?php
                                                                    foreach($ListMenuPerusahaan as $key=>$val)
                                                                    {
                                                                    ?>
									<li class="m-menu__item " aria-haspopup="true">
                                                                            <a href="<?php echo site_url("organisasi/Perusahaan/turn_on/".$key); ?>" class="m-menu__link ">
											<i class="m-menu__link-icon "></i>
											<span class="m-menu__link-text"><?php echo $val; ?></span>
										</a>
									</li>
                                                                    <?php
                                                                    }
                                                                    ?>
									
								</ul>
							</div>
						</li>
                                                <?php 
                                                }
												else{
													//echo $this->session->userdata('user_id')."-----|".$this->session->userdata('ses_perusahaan')."|---error header";
													// die;
												}
                                                if(isset($NamaPerusahaan))
                                                {
                                                    $link="#";
                                                    if($this->mion_auth->is_allowed('view_company')){
                                                        $link=site_url("organisasi/Perusahaan");
                                                    }
                                                ?>
						<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a href="<?php echo $link; ?>" class="m-menu__link" title="Link Company">
								<i class="m-menu__link-icon flaticon-network"></i>
								<span class="m-menu__link-title">
									<span class="m-menu__link-wrap">
										<span class="m-menu__link-text"><?php echo $NamaPerusahaan; ?></span>
									</span>
								</span>
							</a>
							
						</li>
                                                <?php
                                                }
                                                ?>
					</ul>
				</div>
				<?php
				}
				?>
				<!-- END: Horizontal Menu -->

				<!-- BEGIN: Topbar -->
				<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
					<div class="m-stack__item m-topbar__nav-wrapper">
						<ul class="m-topbar__nav m-nav m-nav--inline">
<!--							<li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light" m-dropdown-toggle="click" id="m_quicksearch" m-quicksearch-mode="dropdown"
							 m-dropdown-persistent="1">
								<a href="#" class="m-nav__link m-dropdown__toggle">
									<span class="m-nav__link-icon">
										<i class="flaticon-search-1"></i>
									</span>
								</a>
								<div class="m-dropdown__wrapper">
									<span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
									<div class="m-dropdown__inner ">
										<div class="m-dropdown__header">
											<form class="m-list-search__form">
												<div class="m-list-search__form-wrapper">
													<span class="m-list-search__form-input-wrapper">
														<input id="m_quicksearch_input" autocomplete="off" type="text" name="q" class="m-list-search__form-input" value="" placeholder="Search...">
													</span>
													<span class="m-list-search__form-icon-close" id="m_quicksearch_close">
														<i class="la la-remove"></i>
													</span>
												</div>
											</form>
										</div>
										<div class="m-dropdown__body">
											<div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-height="300" data-mobile-height="200">
												<div class="m-dropdown__content">
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>-->
							<li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
								<a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                                                                    <?php
                                                                    if($TotalReminder>0){
                                                                    ?>
									<span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
                                                                    <?php } ?>
									<span class="m-nav__link-icon">
										<i class="flaticon-alarm"></i>
									</span>
								</a>
								<div class="m-dropdown__wrapper">
									<span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
									<div class="m-dropdown__inner">
										<div class="m-dropdown__header m--align-center" style="background: url(<?php echo base_url("assets/metronic/assets/app/media/img/misc/notification_bg.jpg"); ?>); background-size: cover;">
											<span class="m-dropdown__header-title"><?php echo $TotalReminder." New"; ?></span>
											<span class="m-dropdown__header-subtitle">User Notifications</span>
										</div>
										<div class="m-dropdown__body">
											<div class="m-dropdown__content">
												<ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
													<li class="nav-item m-tabs__item">
														<a class="nav-link m-tabs__link active" data-toggle="tab" href="#topbar_notifications_notifications" role="tab">
															Alerts
														</a>
													</li>
<!--													<li class="nav-item m-tabs__item">
														<a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_events" role="tab">Events</a>
													</li>
													<li class="nav-item m-tabs__item">
														<a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_logs" role="tab">Logs</a>
													</li>-->
												</ul>
												<div class="tab-content">
													<div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
														<div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
															<div class="m-list-timeline m-list-timeline--skin-light">
																<div class="m-list-timeline__items">
                                                                                                                                    <?php
                                                                                                                                    foreach($ListReminder->result() as $row){
                                                                                                                                        $tgl=strtotime($row->tgl_input);
                                                                                                                                        $TglConversi= formatTimeString($tgl);
                                                                                                                                        $ClsRead="";
                                                                                                                                        $NipLogin=$this->session->userdata('login_nip');
                                                                                                                                        if(($NipLogin!="" and $row->status==1) or ($NipLogin =="" and $row->status_admin==1)){
                                                                                                                                            $ClsRead="m-list-timeline__item--read";
                                                                                                                                        } 
                                                                                                                                        
                                                                                                                                    ?>
                                                                                                                                        <div class="m-list-timeline__item <?php echo $ClsRead;?>">
																		<span class="m-list-timeline__badge"></span>
																		<span class="m-list-timeline__text"><a href="<?php echo site_url($row->link); ?>" class="m-link reminder-link" data-id="<?php echo $row->kd_notifikasi; ?>" data-uri="<?php echo site_url("dashboard/Home/update_notifikasi"); ?>"><?php echo $row->pesan; ?></a></span>
																		<span class="m-list-timeline__time"><?php echo $TglConversi; ?></span>
																	</div>
                                                                                                                                    <?php
                                                                                                                                    }
                                                                                                                                    ?>
<!--																	<div class="m-list-timeline__item">
																		<span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
																		<span class="m-list-timeline__text">12 new users registered</span>
																		<span class="m-list-timeline__time">Just now</span>
																	</div>
																	<div class="m-list-timeline__item">
																		<span class="m-list-timeline__badge"></span>
																		<span class="m-list-timeline__text">System shutdown
																			<span class="m-badge m-badge--success m-badge--wide">pending</span>
																		</span>
																		<span class="m-list-timeline__time">14 mins</span>
																	</div>
																	<div class="m-list-timeline__item">
																		<span class="m-list-timeline__badge"></span>
																		<span class="m-list-timeline__text">New invoice received</span>
																		<span class="m-list-timeline__time">20 mins</span>
																	</div>
																	<div class="m-list-timeline__item">
																		<span class="m-list-timeline__badge"></span>
																		<span class="m-list-timeline__text">DB overloaded 80%
																			<span class="m-badge m-badge--info m-badge--wide">settled</span>
																		</span>
																		<span class="m-list-timeline__time">1 hr</span>
																	</div>
																	<div class="m-list-timeline__item">
																		<span class="m-list-timeline__badge"></span>
																		<span class="m-list-timeline__text">System error -
																			<a href="#" class="m-link">Check</a>
																		</span>
																		<span class="m-list-timeline__time">2 hrs</span>
																	</div>
																	<div class="m-list-timeline__item m-list-timeline__item--read">
																		<span class="m-list-timeline__badge"></span>
																		<span href="" class="m-list-timeline__text">New order received
																			<span class="m-badge m-badge--danger m-badge--wide">urgent</span>
																		</span>
																		<span class="m-list-timeline__time">7 hrs</span>
																	</div>
																	<div class="m-list-timeline__item m-list-timeline__item--read">
																		<span class="m-list-timeline__badge"></span>
																		<span class="m-list-timeline__text">Production server down</span>
																		<span class="m-list-timeline__time">3 hrs</span>
																	</div>
																	<div class="m-list-timeline__item">
																		<span class="m-list-timeline__badge"></span>
																		<span class="m-list-timeline__text">Production server up</span>
																		<span class="m-list-timeline__time">5 hrs</span>
																	</div>-->
																</div>
															</div>
														</div>
													</div>
<!--													<div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
														<div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
															<div class="m-list-timeline m-list-timeline--skin-light">
																<div class="m-list-timeline__items">
																	<div class="m-list-timeline__item">
																		<span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
																		<a href="" class="m-list-timeline__text">New order received</a>
																		<span class="m-list-timeline__time">Just now</span>
																	</div>
																	<div class="m-list-timeline__item">
																		<span class="m-list-timeline__badge m-list-timeline__badge--state1-danger"></span>
																		<a href="" class="m-list-timeline__text">New invoice received</a>
																		<span class="m-list-timeline__time">20 mins</span>
																	</div>
																	<div class="m-list-timeline__item">
																		<span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
																		<a href="" class="m-list-timeline__text">Production server up</a>
																		<span class="m-list-timeline__time">5 hrs</span>
																	</div>
																	<div class="m-list-timeline__item">
																		<span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
																		<a href="" class="m-list-timeline__text">New order received</a>
																		<span class="m-list-timeline__time">7 hrs</span>
																	</div>
																	<div class="m-list-timeline__item">
																		<span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
																		<a href="" class="m-list-timeline__text">System shutdown</a>
																		<span class="m-list-timeline__time">11 mins</span>
																	</div>
																	<div class="m-list-timeline__item">
																		<span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
																		<a href="" class="m-list-timeline__text">Production server down</a>
																		<span class="m-list-timeline__time">3 hrs</span>
																	</div>
																</div>
															</div>
														</div>
													</div>-->
<!--													<div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
														<div class="m-stack m-stack--ver m-stack--general" style="min-height: 180px;">
															<div class="m-stack__item m-stack__item--center m-stack__item--middle">
																<span class="">All caught up!
																	<br>No new logs.</span>
															</div>
														</div>
													</div>-->
												</div>
                                                                                                <ul class="m-nav m-nav--skin-light">
                                                                                                            
                                                                                                            <li class="m-nav__separator m-nav__separator--fit">
                                                                                                            </li>
                                                                                                            <li class="m-nav__item">
                                                                                                                <a href="<?php echo site_url("akses/Notifikasi"); ?>" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">View All</a>
                                                                                                            </li>
                                                                                                    </ul>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li class="m-nav__item m-topbar__quick-actions m-topbar__quick-actions--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light"
							 m-dropdown-toggle="click">
								<a href="#" class="m-nav__link m-dropdown__toggle">
                                                                    
									<span class="m-nav__link-badge m-badge m-badge--dot m-badge--info m--hide"></span>
									<span class="m-nav__link-icon">
										<i class="flaticon-share"></i>
									</span>
								</a>
								<div class="m-dropdown__wrapper">
									<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
									<div class="m-dropdown__inner">
                                                                            <div class="m-dropdown__header m--align-center" style="background: url(<?php echo base_url('assets/metronic/assets/app/media/img/misc/quick_actions_bg.jpg')?>); background-size: cover;">
											<span class="m-dropdown__header-title">Quick Actions</span>
											<span class="m-dropdown__header-subtitle">Shortcuts</span>
										</div>
										<div class="m-dropdown__body m-dropdown__body--paddingless">
											<div class="m-dropdown__content">
												<div class="data" data="false" data-height="380" data-mobile-height="200">
													<div class="m-nav-grid m-nav-grid--skin-light">
                                                                                                            <?php
                                                                                                            $no=1;
                                                                                                            foreach($ListQuickMenu as $key=>$val){
                                                                                                                if($no==1){
                                                                                                            ?>
                                                                                                                <div class="m-nav-grid__row">
                                                                                                            <?php
                                                                                                                }else if($no%3==0){
                                                                                                            ?>
                                                                                                                </div>
                                                                                                                <div class="m-nav-grid__row">
                                                                                                            <?php
                                                                                                                }
                                                                                                            ?>
                                                                                                                <a href="<?php echo site_url($val['link']);?>" class="m-nav-grid__item">
															<i class="m-nav-grid__icon <?php echo $val['icon'] ?>"></i>
															<span class="m-nav-grid__text"><?php echo $val['menu'] ?></span>
														</a>
                                                                                                            <?php
                                                                                                                $no++;
                                                                                                            }
                                                                                                            ?>
                                                                                                                </div>     
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li class="m-nav__item m-topbar__languages m-dropdown m-dropdown--small m-dropdown--arrow m-dropdown--align-right m-dropdown--mobile-full-width" m-dropdown-toggle="click">
								<a href="#" class="m-nav__link m-dropdown__toggle">
									<span class="m-nav__link-text">
                                                                            <?php
                                                                            $siteLang = $this->session->userdata('site_lang');
                                                                            if($siteLang=="indonesian"){
                                                                                $flag="004-indonesia.svg";
                                                                                $statAktifIndo="m-nav__item--active";
                                                                                $statAktifEng="";
                                                                            }else{
                                                                                $flag="020-flag.svg";
                                                                                $statAktifIndo="";
                                                                                $statAktifEng="m-nav__item--active";
                                                                            }
                                                                            ?>
										<img class="m-topbar__language-selected-img" src="<?php echo base_url();?>assets/metronic/assets/app/media/img/flags/<?php echo $flag;?>">
									</span>
								</a>
								<div class="m-dropdown__wrapper">
									<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
									<div class="m-dropdown__inner">
										<div class="m-dropdown__header m--align-center" style="background: url(<?php echo base_url();?>assets/metronic/assets/app/media/img/misc/flagsquick_actions_bg.jpg); background-size: cover;">
											<span class="m-dropdown__header-subtitle">Select your language</span>
										</div>
										<div class="m-dropdown__body">
											<div class="m-dropdown__content">
												<ul class="m-nav m-nav--skin-light">
													<li class="m-nav__item <?php echo $statAktifEng;?>">
														<a href="<?php echo site_url("akses/LanguageSwitcher/switchLang/english"); ?>" class="m-nav__link m-nav__link--active">
															<span class="m-nav__link-icon">
																<img class="m-topbar__language-img" src="<?php echo base_url();?>assets/metronic/assets/app/media/img/flags/020-flag.svg">
															</span>
															<span class="m-nav__link-title m-topbar__language-text m-nav__link-text">USA</span>
														</a>
													</li>
													<li class="m-nav__item <?php echo $statAktifIndo;?>">
                                                                                                            <a href="<?php echo site_url("akses/LanguageSwitcher/switchLang/indonesian"); ?>" class="m-nav__link">
															<span class="m-nav__link-icon">
																<img class="m-topbar__language-img" src="<?php echo base_url();?>assets/metronic/assets/app/media/img/flags/004-indonesia.svg">
															</span>
															<span class="m-nav__link-title m-topbar__language-text m-nav__link-text">Indonesia</span>
														</a>
													</li>
													
												</ul>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
								<a href="#" class="m-nav__link m-dropdown__toggle">
									<span class="m-topbar__userpic">
                                                                            <?php
                                                                            if($this->session->userdata('login_foto')!=""){
                                                                                $LinkFoto= base_url('assets/upload/foto/'.$this->session->userdata('login_foto'));
                                                                            }else{
                                                                                $LinkFoto= base_url('assets/img/NoImage.png');
                                                                            } 
                                                                            ?>
										<img src="<?php echo $LinkFoto; ?>" class="m--img-rounded m--marginless" alt="" />
									</span>
									<span class="m-topbar__username m--hide">Nick</span>
								</a>
								<div class="m-dropdown__wrapper">
									<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
									<div class="m-dropdown__inner">
										<div class="m-dropdown__header m--align-center" style="background: url(<?php echo base_url("assets/metronic/assets/app/media/img/misc/user_profile_bg.jpg"); ?>); background-size: cover;">
											<div class="m-card-user m-card-user--skin-dark">
												<div class="m-card-user__pic">
													<img src="<?php echo $LinkFoto; ?>" class="m--img-rounded m--marginless" alt="" />

													<!--
			<span class="m-type m-type--lg m--bg-danger"><span class="m--font-light">S<span><span>
			-->
												</div>
												<div class="m-card-user__details">
													<span class="m-card-user__name m--font-weight-500"><?php echo $this->session->userdata('login_nama'); ?></span>
													<a href="" class="m-card-user__email m--font-weight-300 m-link"><?php echo $this->session->userdata($this->config->item('identity', 'ion_auth')); ?></a>
												</div>
											</div>
										</div>
										<div class="m-dropdown__body">
											<div class="m-dropdown__content">
												<ul class="m-nav m-nav--skin-light">
													<li class="m-nav__section m--hide">
														<span class="m-nav__section-text">Section</span>
													</li>
													<li class="m-nav__item">
                                                                                                            <a href="<?php echo site_url('akses/Profile'); ?>" class="m-nav__link">
															<i class="m-nav__link-icon flaticon-profile-1"></i>
															<span class="m-nav__link-title">
																<span class="m-nav__link-wrap">
																	<span class="m-nav__link-text">My Profile</span>
<!--																	<span class="m-nav__link-badge">
																		<span class="m-badge m-badge--success">2</span>
																	</span>-->
																</span>
															</span>
														</a>
													</li>
													<li class="m-nav__item">
                                                                                                            <a href="<?php echo site_url('akses/Profile/activity_form') ?>" class="m-nav__link">
															<i class="m-nav__link-icon flaticon-share"></i>
															<span class="m-nav__link-text">Activity</span>
														</a>
													</li>
<!--													<li class="m-nav__item">
														<a href="header/profile.html" class="m-nav__link">
															<i class="m-nav__link-icon flaticon-chat-1"></i>
															<span class="m-nav__link-text">Messages</span>
														</a>
													</li>
													<li class="m-nav__separator m-nav__separator--fit">
													</li>
													<li class="m-nav__item">
														<a href="header/profile.html" class="m-nav__link">
															<i class="m-nav__link-icon flaticon-info"></i>
															<span class="m-nav__link-text">FAQ</span>
														</a>
													</li>
													<li class="m-nav__item">
														<a href="header/profile.html" class="m-nav__link">
															<i class="m-nav__link-icon flaticon-lifebuoy"></i>
															<span class="m-nav__link-text">Support</span>
														</a>
													</li>-->
													<li class="m-nav__separator m-nav__separator--fit">
													</li>
													<li class="m-nav__item">
                                                                                                            <a href="<?php echo site_url("akses/Login/logout"); ?>" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</li>
<!--							<li id="m_quick_sidebar_toggle" class="m-nav__item">
								<a href="#" class="m-nav__link m-dropdown__toggle">
									<span class="m-nav__link-icon">
										<i class="flaticon-grid-menu"></i>
									</span>
								</a>
							</li>-->
						</ul>
					</div>
				</div>

				<!-- END: Topbar -->
			</div>
		</div>
	</div>
</header>