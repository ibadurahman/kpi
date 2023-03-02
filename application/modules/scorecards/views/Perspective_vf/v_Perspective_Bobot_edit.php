<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData=$DataPerspectiveBobot->row();
?>

<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label($this->lang->line('tahun')."<span class='m--font-danger'>*</span>",'tahun_baru');?>
        <p class="form-control-static"><?php echo $RowData->tahun; ?></p>
        <?php echo form_hidden("tahun_baru",$RowData->tahun);?>
        <?php /*echo form_dropdown('tahun_baru', 
                                    $ListTahun, 
                                    set_value('tahun_baru',$RowData->tahun),
                                    "id='tahun' style='width: 100%' class='select2 form-control m-select2' 
                                    data-placeholder='".$this->lang->line('tahun')."'"); 
         * 
         */
               echo form_hidden('tahun',$RowData->tahun);                     
        ?>
        <div class="error"></div>
</div>
<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label($this->lang->line('weightage')."<span class='m--font-danger'>*</span>",'tahun');?>
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
                $Total=0;
                $Total_persen=0;
                foreach($DataPerspectiveBobot->result() as $row)
                {
                    $Total=$Total+$row->weightage;
                    $Total_persen=$Total_persen+$row->bobot;
                ?>
                    <tr>
                            <td scope="row"><?php echo $no; ?></td>
                            <td>
                                <?php echo form_input(array(
                                                            'name'          => 'kd_perspective[]',
                                                            'id'            => 'kd_perspective'.$no,
                                                            'class'         => 'form-control m-input ',
                                                            'placeholder'    => $this->lang->line('kd_perspective'),
                                                            'readonly'      => true
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
                                                    ),set_value('weightage'.$no,$row->weightage));
                                ?>
                                <div class="error"></div>
                            </td>
                            <td scope="row" align="right" id="<?php echo "bobot".$no; ?>"><?php echo $row->bobot."%"; ?></td>
                    </tr>
                <?php 
                        $no++;
                    }
                ?>
                    <tr>
                        <td colspan="3" align="right"><b>Total</b></td>
                        <td id="total"><b><?php echo $Total; ?></b></td>
                        <td id="total_persen" align="right"><b><?php echo $Total_persen." %"; ?></b></td>
                        <?php echo form_input(array(
                                                            'name'          => 'total_bobot',
                                                            'id'            => 'total_bobot',
                                                            'type'  => 'hidden'
                                                    ),set_value('total_bobot',$Total_persen));
                                ?>
                    </tr>
            </tbody>
        </table>
</div>

