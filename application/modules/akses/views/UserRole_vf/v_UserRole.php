<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						<?php echo isset($list_header)?$list_header:""; ?>
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
                                    <?php if($this->mion_auth->is_allowed('add_user_role')){ ?>
					<li class="m-portlet__nav-item">
                                            <a href="<?php echo site_url('akses/UserRole/insert_form'); ?>" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air" id="button_add" >
							<span>
								<i class="la la-plus "></i>
								<span><?php echo $this->lang->line('button_new');?></span>
							</span>
						</a>
					</li>
                                    <?php } ?>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
                    <div class="row">
			<div class="col-xl-3">
				<div class="m-tabs" data-tabs="true" data-tabs-contents="#m_sections">
					<ul class="m-nav m-nav--active-bg m-nav--active-bg-padding-lg m-nav--font-lg m-nav--font-bold m--margin-bottom-20 m--margin-top-10 m--margin-right-40" id="m_nav" role="tablist">
                                            <?php 
                                                $No=1;
                                                foreach($groups as $row)
                                                {
                                                    $ClsActive="";
                                                    if($No==1){
                                                        $ClsActive="m-tabs__item--active";
                                                    }
                                            ?>
                                                <li class="m-nav__item">
							<a class="m-nav__link m-tabs__item <?php echo $ClsActive; ?>" data-tab-target="<?php echo "#RoleTab_".$row->id; ?>" href="#">
								<span class="m-nav__link-text"><?php echo $row->name; ?></span>
							</a>
						</li>
                                            <?php
                                                    $No++;
                                                }
                                            ?>
						
						
					</ul>
				</div>
			</div>
			<div class="col-xl-9">
				<div class="m-tabs-content" id="m_sections">
                                    <?php 
                                            $No=1;
                                            foreach($groups as $row)
                                            {
                                                $ClsActive="";
                                                if($No==1){
                                                    $ClsActive="m-tabs-content__item--active";
                                                }
                                    ?>
                                    <div class="m-tabs-content__item <?php echo $ClsActive; ?>" id="<?php echo "RoleTab_".$row->id; ?>">
                                        <h4 class="m--font-bold m--margin-top-15 m--margin-bottom-20"><?php echo $row->name; ?></h4>
                                        <div class="m-accordion m-accordion--section m-accordion--padding-lg" id="<?php echo "RoleTab_".$row->id."_content"; ?>">
                                            <div class="m-section">
                                                <div class="m-section__sub">
                                                    <?php echo $row->description; ?>
                                                </div>
                                                <div class="m-section__content">
                                                    <div class="col-6">
                                                    <div class="m-portlet m-portlet--bordered m-portlet--info m-portlet--head-solid-bg">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
											<?php echo $this->lang->line('access'); ?>
										</h3>
									</div>
								</div>
							</div>
							<div class="m-portlet__body">
                                                            <?php
                                                                                $a=1;
                                                                                if(isset($ListPermission[$row->id]) and count($ListPermission[$row->id])>0)
                                                                                {
                                                                                    $TempMenu="";
                                                                                    foreach($ListPermission[$row->id] as $key=>$val)
                                                                                    {
                                                                                      
                                                                            ?>
                                                                <?php 
                                                                                      if($TempMenu!=$val['menu'])
                                                                                        {
                                                                                            $TempMenu=$val['menu'];
                                                                                            if($a==1)
                                                                                            {
                                                                                               echo '<div class="">'; 
                                                                                            }else{
                                                                                                echo '</div><div class="m-separator m-separator--fit"></div><div class="">'; 
                                                                                            }
                                                                ?>
                                                                <h2 class="m-section__heading"><?php echo $val['menu'];?></h2>
                                                                                        <?php }?>
                                                                <div class="m-section__sub"><?php echo $val['deskripsi'];?></div>
                                                                         
                                                            
                                                                            <?php
                                                                                        $a++;
                                                                                    }
                                                                                echo "</div>";
                                                                                }
                                                                   ?>
                                                                
							</div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-separator m-separator--fit"></div>
                                            <div class="row">
                                                <?php if($this->mion_auth->is_allowed('edit_user_role')){ ?>
                                                    <div class="col-lg-6">
                                                        <a href="<?php echo site_url('akses/UserRole/edit_form/'.$row->id); ?>" class="btn btn-accent m-btn m-btn--icon">
                                                            <span>
                                                                    <i class="la la-edit"></i>
                                                                    <span>Edit</span>
                                                            </span>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                                <?php if($this->mion_auth->is_allowed('delete_user_role')){ ?>
                                                    <div class="col-lg-6 m--align-right" id="tombol-del">
                                                        <button type="button" class="btn btn-danger m-btn m-btn--icon delete-data" data-id="<?php echo $row->id;?>">
                                                            <span>
                                                                    <i class="la la-trash"></i>
                                                                    <span>Delete</span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                            $No++;
                                        }
                                    ?>
					
				</div>
			</div>
		</div>
		</div>
        </div>
    </div>
    
</div>