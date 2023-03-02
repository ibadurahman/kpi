<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData = $DataPerusahaan->row();
?>

<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label($this->lang->line('nm_perusahaan')."<span class='m--font-danger'>*</span>",'nm_perusahaan');?>
        <?php echo form_input(array(
                                    'name'          => 'nm_perusahaan',
                                    'id'            => 'nm_perusahaan',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('nm_perusahaan')
                            ),set_value('nm_perusahaan',$RowData->nm_perusahaan));
        ?>
</div>
<div class="form-group m-form__group">
	<?php echo form_label($this->lang->line('alamat'),'alamat');?>
        <?php echo form_input(array(
                                    'name'          => 'alamat',
                                    'id'            => 'alamat',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('alamat')
                            ),set_value('alamat',$RowData->alamat));
        ?>
</div>
<div class="form-group m-form__group">
        <?php echo form_label($this->lang->line('telepon'),'telepon');?>
        <?php echo form_input(array(
                                    'name'          => 'telepon',
                                    'id'            => 'telepon',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('telepon')
                            ),set_value('telepon',$RowData->telepon));
        ?>
</div>
<div class="form-group m-form__group">
        <?php echo form_label($this->lang->line('fax'),'fax');?>
        <?php echo form_input(array(
                                    'name'          => 'fax',
                                    'id'            => 'fax',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('fax')
                            ),set_value('fax',$RowData->fax));
        ?>
</div>
<div class="form-group m-form__group">
        <?php echo form_label($this->lang->line('logo'),'logo');?>
        <?php echo form_upload(array(
                                    'name'          => 'logo',
                                    'id'            => 'logo',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('logo')
                            ),set_value('logo'));
                echo form_hidden("logo_lama",$RowData->logo);              
        ?>
</div>
<div class="form-group m-form__group m--margin-bottom-20">
        <div class="col-sm-12">
            <?php 
                if($RowData->logo!=""){
                    $LinkFoto= base_url('assets/upload/logo/'.$RowData->logo);
                }else{
                    $LinkFoto= base_url('assets/img/NoImage.png');
                } 
            ?>
            <div id="image-holder"><img src="<?php echo $LinkFoto?>" class="thumb-image" style="width: 150px; height: 150px;"/></div>
        </div>
</div>