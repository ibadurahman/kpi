<?php 
$RowData = $DataPermission->row();
        
?>
<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label($this->lang->line('kd_permission')."<span class='m--font-danger'>*</span>",'kd_permission_baru');?>
        <?php echo form_input(array(
                                    'name'          => 'kd_permission_baru',
                                    'id'            => 'kd_permission_baru',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('kd_permission')
                            ),set_value('kd_permission_baru',$RowData->kd_permission));
            
              echo form_hidden("kd_permission",$RowData->kd_permission);        
        ?>
</div>
<div class="form-group m-form__group">
	<?php echo form_label($this->lang->line('deskripsi')."<span class='m--font-danger'>*</span>",'deskripsi');?>
        <?php echo form_input(array(
                                    'name'          => 'deskripsi',
                                    'id'            => 'deskripsi',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('deskripsi')
                            ),set_value('deskripsi',$RowData->deskripsi));
        ?>
</div>
<div class="form-group m-form__group m--margin-bottom-20">
        <?php echo form_label($this->lang->line('kd_menu')."<span class='m--font-danger'>*</span>",'kd_menu');?>
        <?php echo form_dropdown('kd_menu', 
                                    $ListMenu, 
                                    set_value('kd_menu',$RowData->kd_menu),
                                    "id='kd_menu' style='width: 100%' class='select2 form-control m-select2' 
                                    data-placeholder='".$this->lang->line('kd_menu')."'"); 

        ?>
</div>