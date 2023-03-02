<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<table class="table table-bordered table-hover custom-table">
    <thead>
            <tr>    
                    <th><b>#</b></th>
                    <th width="100"><b><?php echo $this->lang->line('kd_measurement');?></b></th>
                    <th><b><?php echo $this->lang->line('nm_measurement');?></b></th>
<!--                    <th width="100"><b><?php // echo $this->lang->line('remaining_persentage')." (%)";?></b></th>
                    <th><b><?php //echo $this->lang->line('weightage_bd')." (%)";?></b></th>-->
                    <th><b><?php echo $this->lang->line('weightage_kpi');?></b></th>
                            <th width="100"><?php echo "Total (%)";?></th>
            </tr>
    </thead>
    <tbody>
        <?php
        $no=1;
        $KdDBTemp="";
        $TotalKPI= array_sum($weightage_kpi);
        $TotalPersen=0;
        foreach($DataMeasurement->result() as $row)
        {
            $JmlPersen=round(($weightage_kpi[$row->kd_measurement]/$TotalKPI)*100,2);
            $TotalPersen=$TotalPersen+$JmlPersen;
            if($row->kd_bd!=$KdDBTemp){
                $KdDBTemp=$row->kd_bd;
        ?>
        <tr>
            <td colspan="6"><b><?php echo $row->nm_bd;?></b></td>
        </tr>
        <?php
            }
        ?>
            <tr>
                <td scope="row"><?php echo $no; ?></td>
                <td><?php echo $row->kd_ms;?></td>
                <td><?php echo $row->nm_measurement;?></td>
<!--                <td>
                    <?php 
                            /*    $clsWeightage="m-badge--success";
                                if($row->remaining_pesen < 100){
                                    $clsWeightage="m-badge--danger";
                                }
                             * 
                             */
                    ?>
                    <span class="m-badge <?php //echo $clsWeightage; ?> m-badge--wide"><?php //echo $row->remaining_pesen."%"; ?></span>
                </td>
                <td><?php //echo $weightage_bd[$row->kd_measurement] ?></td>-->
                <td align="right"><?php echo $weightage_kpi[$row->kd_measurement] ?></td>
                <td align="right"><?php echo $JmlPersen."%" ?></td>
            </tr>
        <?php 
                $no++;
            }
            $TotalPersen=($TotalPersen>100)?100:$TotalPersen;
        ?>
            <tr>
                        <td colspan="3" align="right"><b>Total</b></td>
                            <td id="total" align="right"><?php echo $TotalKPI; ?></td>
                            <td id="total_persen" align="right"><?php echo $TotalPersen."%"; ?></td>
                    </tr>
    </tbody>
</table>
