<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<table class="table table-bordered table-hover custom-table">
    <thead>
            <tr>    
                    <!--<th><b>#</b></th>-->
                    <th><b><?php echo $this->lang->line('nm_measurement');?></b></th>
                    <th  width="100"><b><?php echo $this->lang->line('bulan');?></b></th>
                    <th><b><?php echo $this->lang->line('target');?></b></th>
            </tr>
    </thead>
    <tbody>
        <?php
        $no=1;
        $KdMSTemp="";
        foreach($DataMeasurement->result() as $row)
        {
            if($row->kd_measurement!=$KdMSTemp){
                $KdMSTemp=$row->kd_measurement;
        ?>
        <tr>
            <td rowspan="12" valign="middle"><?php echo $row->nm_measurement; ?></td>
            <td><?php echo getNamaBulan($row->bulan); ?></td>
            <td>
                <?php echo form_input(array(
                                                        'name'          => 'target'.$KdMSTemp.$row->bulan,
                                                        'id'            => 'target'.$KdMSTemp.$row->bulan,
                                                        'class'         => 'form-control m-input target',
                                                ),set_value('target'.$KdMSTemp.$row->bulan,$row->target_departemen)); 
                                       
                ?>
            </td>
        </tr>
        <?php
            }else{
        ?>
        <tr>
            <td><?php echo getNamaBulan($row->bulan); ?></td>
            <td>
                <?php echo form_input(array(
                                                        'name'          => 'target'.$KdMSTemp.$row->bulan,
                                                        'id'            => 'target'.$KdMSTemp.$row->bulan,
                                                        'class'         => 'form-control m-input target',
                                                ),set_value('target'.$KdMSTemp.$row->bulan,$row->target_departemen)); 
                ?>
            </td>
        </tr>
        
        <?php
            }
        }
        ?>
    </tbody>
</table>
