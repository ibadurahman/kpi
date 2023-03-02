<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-6">
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
                                    <?php if($this->mion_auth->is_allowed('add_menu')){ ?>
					<li class="m-portlet__nav-item">
                                        <a href="#" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air" id="button_add">
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
                <div id="m_tree_1" class="tree-demo">
			<ul>
                        <?php
                        if(isset($ListMenuParent))
                        {
                            foreach ($ListMenuParent as $key=>$val)
                            {
                        ?>
                            <li data-jstree='{ "opened" : true,"icon" : "fa fa-sss" }' id="<?php echo $key;?>">
                                <?php echo $val["menu"];
                                
                                if(isset($ListMenuChild[$key]) and count($ListMenuChild[$key])>0)
                                {
                                ?>
                                <ul>
                                    <?php foreach($ListMenuChild[$key] as $key_child=>$val_child)
                                    {
                                     ?>
                                    <li data-jstree='{ "opened" : true, "icon" : "fa fa-sss" }' id="<?php echo $key_child;?>">
							<a href="javascript:;">
								<?php echo $val_child["menu"];?> 
                                                    </a>
                                        <?php
                                        if(isset($ListMenuChild[$key_child]) and count($ListMenuChild[$key_child])>0)
                                        {
                                        ?>
                                        <ul>
                                            <?php foreach($ListMenuChild[$key_child] as $key_child2=>$val_child2)
                                            {
                                             ?>
                                            <li data-jstree='{ "opened" : true, "icon" : "fa fa-sss" }' id="<?php echo $key_child2;?>">
                                                            <a href="javascript:;">
                                                                    <?php echo $val_child2["menu"];?> 
                                                            </a>
                                            </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                        <?php
                                        }
                                        ?>
					</li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                                <?php
                                }
                                ?>
                            </li>
                        <?php
                            }
                        }
                        ?>
				
			</ul>
                </div>
		</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="m-portlet m-portlet--mobile m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_1">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text" id="judul-form">
						<?php echo isset($input_header)?$input_header:""; ?>
					</h3>
				</div>
			</div>
		</div>
            <?php echo form_open('akses/Menu/save',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
		
		<div class="m-portlet__body">
                
                <div class="form-group m-form__group">
                    <?php echo form_label($this->lang->line('menu')."<span class='m--font-danger'>*</span>",'menu');?>
                    <?php echo form_input(array(
                                                'name'          => 'menu',
                                                'id'            => 'menu',
                                                'class'         => 'form-control m-input',
                                                'placeholder'    => $this->lang->line('menu')
                                        ),set_value('menu'));
                    ?>
                </div>
                <div class="form-group m-form__group">
                    <?php echo form_label($this->lang->line('link')."<span class='m--font-danger'>*</span>",'link');?>
                    <?php echo form_input(array(
                                                   'name'          => 'link',
                                                   'id'            => 'link',
                                                   'class'         => 'form-control m-input',
                                                   'placeholder'    => $this->lang->line('link')
                                           ),set_value('link'));
                    ?>
                </div>
                <div class="form-group m-form__group">
                    <?php echo form_label($this->lang->line('icon'),'icon');?>
                    <?php echo form_input(array(
                                                   'name'          => 'icon',
                                                   'id'            => 'icon',
                                                   'class'         => 'form-control m-input',
                                                   'placeholder'    => $this->lang->line('icon')
                                           ),set_value('icon'));
                    ?>
                </div>
                <div class="form-group m-form__group">
                    <?php echo form_label($this->lang->line('icon_quick'),'icon_quick');?>
                    <?php echo form_input(array(
                                                   'name'          => 'icon_quick',
                                                   'id'            => 'icon_quick',
                                                   'class'         => 'form-control m-input',
                                                   'placeholder'    => $this->lang->line('icon_quick')
                                           ),set_value('icon_quick'));
                    ?>
                </div>
                <div class="form-group m-form__group">
                    <?php echo form_label($this->lang->line('kd_menu_parent'),'kd_menu_parent');?>
                    <?php echo form_dropdown('kd_menu_parent', 
                                                $ListMenu, 
                                                set_value('kd_menu_parent'),
                                                "id='kd_menu_parent' style='width: 100%' class='select2 form-control m-select2' 
                                                data-placeholder='".$this->lang->line('kd_menu_parent')."'"); 

                    ?>
                        
                </div>
                 <div class="form-group m-form__group row">
                     <div class="col-6">
                    <?php echo form_label($this->lang->line('order')."<span class='m--font-danger'>*</span>",'order');?>
                    <?php echo form_input(array(
                                                   'name'          => 'order',
                                                   'id'            => 'order',
                                                   'class'         => 'form-control m-input',
                                                   'placeholder'    => $this->lang->line('order'),
                                                   'type'           =>'number'
                                           ),set_value('order'));
                    ?>
                    </div>
                </div>    
                <div class="form-group m-form__group row">
                    <?php echo form_label($this->lang->line('status_show'),'status_show',["class"=>"col-4 col-form-label"]);?>
                    <div class="col-2">
                            <span class="m-switch m-switch--icon m-switch--accent">
                                    <label>
                                        <?php
                                        echo form_checkbox(array(
                                                        'name'          => 'status_show',
                                                        'id'            => 'status_show'
                                                        ), 1,set_checkbox('status_show', 1,TRUE));
                                        ?>
                                            <span></span>
                                    </label>
                            </span>
                    </div>
                    <?php echo form_label($this->lang->line('quick_menu'),'quick_menu',["class"=>"col-4 col-form-label"]);?>
                    <div class="col-2">
                            <span class="m-switch m-switch--icon m-switch--accent">
                                    <label>
                                            <?php
                                                echo form_checkbox(array(
                                                            'name'          => 'quick_menu',
                                                            'id'            => 'quick_menu'
                                                            ), 1,set_checkbox('quick_menu', 1,FALSE));
                                            ?>
                                            <span></span>
                                    </label>
                            </span>
                    </div>
                    <?php echo form_label($this->lang->line('stat_section'),'stat_section',["class"=>"col-4 col-form-label"]);?>
                    <div class="col-2">
                            <span class="m-switch m-switch--icon m-switch--accent">
                                    <label>
                                            <?php
                                                echo form_checkbox(array(
                                                            'name'          => 'stat_section',
                                                            'id'            => 'stat_section'
                                                            ), 1,set_checkbox('stat_section', 1,FALSE));
                                            ?>
                                            <span></span>
                                    </label>
                            </span>
                    </div>
                </div>
		</div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                    <div class="row">
                            <div class="col-lg-6">
                            <?php if($this->mion_auth->is_allowed('edit_permission')){ ?>
                                <button type="submit" class="btn btn-success">Submit</button>
                            <?php } ?>
                                <button type="button" class="btn btn-secondary" id="tombol-cancel">Cancel</button>
                            </div>
                        <div class="col-lg-6 m--align-right" id="tombol-del">
                            <?php if($this->mion_auth->is_allowed('delete_permission')){ ?>
                            <button type="reset" class="btn btn-danger delete-data" data-id="">Delete</button>
                            <?php } ?>
                            </div>
                    </div>
                    <div class="col-"></div>
                </div>
		</div>
            
            <?php echo form_close(); ?>
        </div>
    </div>
</div>