<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
	<i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

	<!-- BEGIN: Aside Menu -->
	<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
		<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                    <?php
                    //var_dump($ListMenu);
                    if(isset($ListMenu) and count($ListMenu['Parent']) > 0){
                        $Link=$this->uri->segment(1)."/".$this->uri->segment(2);
                        $ClsParentAktif="";
                        $ClsChildAktif="";
                        $ClsChild2Aktif="";
                        foreach($ListMenu['Parent'] as $key=>$val){
                            if($val['section']==0){
                                if($val['link']==$Link){
                                    $ClsParentAktif = "m-menu__item--active";
                                }else{
                                    $ClsParentAktif="";
                                }
                    ?>
                        <li class="m-menu__item <?php echo $ClsParentAktif; ?> " aria-haspopup="true">
				<a href="<?php echo site_url($val['link']);?>" class="m-menu__link ">
					<i class="m-menu__link-icon <?php echo $val['icon'];?>"></i>
					<span class="m-menu__link-title">
						<span class="m-menu__link-wrap">
							<span class="m-menu__link-text"><?php echo $val['menu'];?></span>
<!--							<span class="m-menu__link-badge">
								<span class="m-badge m-badge--danger">2</span>
							</span>-->
						</span>
					</span>
				</a>
			</li>
                    <?php
                            }
                            else
                            {
                        ?>
                        <li class="m-menu__section ">
				<h4 class="m-menu__section-text"><?php echo $val['menu'];?></h4>
				<i class="m-menu__section-icon flaticon-more-v2"></i>
			</li>
                    <?php        
                    //var_dump($ListMenu['Child'][$key]);
                                foreach($ListMenu['Child'][$key] as $KeyChild=>$ValChild)
                                {
                                    if(isset($ListMenu['Child'][$KeyChild]) and count($ListMenu['Child'][$KeyChild])>0){
                                        
                                        if(in_array_r(preg_quote($Link,'/'), $ListMenu['Child'][$KeyChild])){
                                            $ClsOpenMenu="m-menu__item--open m-menu__item--expanded";
                                        }else{
                                            $ClsOpenMenu="";
                                        }
                    ?>
                        <li class="m-menu__item  m-menu__item--submenu <?php echo $ClsOpenMenu; ?>" aria-haspopup="true" m-menu-submenu-toggle="hover">
				<a href="javascript:;" class="m-menu__link m-menu__toggle">
					<i class="m-menu__link-icon <?php echo $ValChild['icon'];?>"></i>
					<span class="m-menu__link-text"><?php echo $ValChild['menu'];?></span>
					<i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
                                <div class="m-menu__submenu ">
					<span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
                    <?php
                                        foreach ($ListMenu['Child'][$KeyChild] as $KeyChild2=>$ValChild2)
                                        {
                                            if($ValChild2['link']==$Link){
                                                $ClsChild2Aktif = "m-menu__item--active";
                                            }else{
                                                $ClsChild2Aktif="";
                                            }
                    ?>
                                               <li class="m-menu__item <?php echo $ClsChild2Aktif; ?>" aria-haspopup="true">
                                                   <a href="<?php echo site_url($ValChild2['link']); ?>" class="m-menu__link ">
								<i class="m-menu__link-bullet m-menu__link-bullet--dot">
									<span></span>
								</i>
								<span class="m-menu__link-text"><?php echo $ValChild2['menu'];?></span>
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
                                    else
                                    {
                                        if($ValChild['link']==$Link){
                                                $ClsChildAktif = "m-menu__item--active";
                                            }else{
                                                $ClsChildAktif="";
                                            }
                    ?>
                        <li class="m-menu__item  m-menu__item--submenu <?php echo $ClsChildAktif; ?>" aria-haspopup="true" m-menu-submenu-toggle="hover">
				<a href="<?php echo site_url($ValChild['link']); ?>" class="m-menu__link m-menu__toggle">
					<i class="m-menu__link-icon <?php echo $ValChild['icon'];?>"></i>
					<span class="m-menu__link-text"><?php echo $ValChild['menu'];?></span>
				</a>
                        </li>
                    <?php
                                    }
                                }
                            }
                        }
                    }
                    ?>
			
		</ul>
	</div>

	<!-- END: Aside Menu -->
</div>