<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<table class="table table-bordered table-hover custom-table">
    <thead>
            <tr>    
                    <th><b>#</b></th>
                    <th width="100"><b><?php echo $this->lang->line('kd_measurement');?></b></th>
                    <th><b><?php echo $this->lang->line('nm_measurement');?></b></th>
                    <th><b><?php echo $this->lang->line('weightage_kpi');?></b></th>
                            <th width="100"><?php echo "Total (%)";?></th>
            </tr>
    </thead>
    <tbody>
        <?php
        $no=1;
        $KdDBTemp="";
        $Total=0;
        $Total_persen=0;
        $Tot_bobot_kpi=$DataMeasurement->num_rows();
        foreach($DataMeasurement->result() as $row)
        {
            if($row->kd_bd!=$KdDBTemp){
                $KdDBTemp=$row->kd_bd;
        ?>
        <tr>
            <td colspan="6"><b><?php echo $row->nm_bd;?></b></td>
        </tr>
        <?php
            }
        ?>
                    <?php 
//                        $weightage_bd=$row->remaining_pesen;
                        $weightage_kpi=1;
                        $weightage_bd="";
                        $persen_kpi=0;
//                        if(isset($ListMeasurement[$row->kd_measurement]))
//                        {
//                            $weightage_bd=$ListMeasurement[$row->kd_measurement]['weightage_bd'];
//                            $weightage_kpi=$ListMeasurement[$row->kd_measurement]['weightage_kpi'];
//                            $Tot_bobot_kpi=$ListMeasurement[$row->kd_measurement]['Tot_bobot_kpi'];
                            $Total=$Total+$weightage_kpi;
                            $persen_kpi=($weightage_kpi/$Tot_bobot_kpi)*100;
                            $Total_persen=$Total_persen+$persen_kpi;
//                            
////                            $total_kpi=$total_kpi+$weightage_kpi;
//                        }
                    ?>
            <tr>
                <td scope="row"><?php echo $no; ?></td>
                <td><?php echo $row->kd_ms;?></td>
                <td><?php echo $row->nm_measurement;?></td>
                <td>
                    <?php echo form_input(array(
                                                        'name'          => 'weightage_kpi[]',
                                                        'id'            => 'weightage_kpi'.$no,
                                                        'class'         => 'form-control m-input list-weightage weightage_kpi'
                                                ),set_value('weightage_kpi[]',$weightage_kpi));     
                            echo form_input(array(
                                                        'name'          => 'kd_measurement3[]',
                                                        'id'            => 'kd_measurement3'.$no,
                                                        'value'         => $row->kd_measurement,
                                                        'class'         => 'form-control m-input kd_measurement3',
                                                        'type'          => 'hidden'
                                                ),set_value('kd_measurement3[]'));         
                            echo form_input(array(
                                                        'name'          => 'weightage_bd[]',
                                                        'id'            => 'weightage_bd'.$no,
                                                        'class'         => 'form-control m-input weightage_bd',
                                                        'type'          => 'hidden'
                                                ),set_value('weightage_bd[]',$weightage_bd));                      
                         ?>
                </td>
                <td scope="row" align="right" id="<?php echo "bobot".$no; ?>"><?php echo $persen_kpi."%" ?></td>
            </tr>
        <?php 
                $no++;
            }
        ?>
            <tr>
                        <td colspan="3" align="right"><b>Total</b></td>
                        <td id="total"><b><?php echo $Total; ?></b></td>
                        <td id="total_persen" align="right"><b><?php echo $Total_persen."%"; ?></b></td>
                        <?php echo form_input(array(
                                                            'name'          => 'total_kpi',
                                                            'id'            => 'total_kpi',
                                                            'type'  => 'hidden'
                                                    ),set_value('total_kpi',$Total_persen));
                                ?>
    </tbody>
</table>
