<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData=$DataKpiPegawai->row();
?>
<!--<div class="m-form__heading">
	<h3 class="m-form__heading-title"><?php //echo $this->lang->line('header_bobot_title')." ".$RowData->nm_measurement." (".$RowData->kd_measurement.")"; ?></h3>
</div>-->
<div class="form-group m-form__group row">
        <?php echo form_label($this->lang->line('bulan_efektif'),'bulan',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
        <div class="col-xl-9 col-lg-9">
            <span class="m-form__control-static"><?php echo getNamaBulan($RowData->bulan); ?></span>
        </div>
</div>
<div class="form-group m-form__group row">
        <?php echo form_label($this->lang->line('tahun_efektif'),'tahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
        <div class="col-xl-9 col-lg-9">
                <span class="m-form__control-static"><?php echo $RowData->tahun; ?></span>
        </div>
</div>
<div class="form-group m-form__group row">
        <?php echo form_label($this->lang->line('nm_departemen'),'nm_departemen',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
        <div class="col-xl-9 col-lg-9">
                <span class="m-form__control-static"><?php echo $RowData->nm_departemen; ?></span>
        </div>
</div>
<div class="form-group m-form__group row">
        <?php echo form_label($this->lang->line('deskripsi'),'tahun',['class'=>"col-xl-3 col-lg-3 col-form-label"]);?>
        <div class="col-xl-9 col-lg-9">
                <span class="m-form__control-static"><?php echo $RowData->deskripsi; ?></span>
        </div>
</div>
<div class="form-group m-form__group">
	<?php echo form_label($this->lang->line('nm_measurement')."<span class='m--font-danger'>*</span>",'weightage');?>
    <div class="m-section__content " id="alert_error_section"></div>
        <table class="table table-bordered table-hover">
            <thead>
                    <tr>
                        <th>No</th>
                        <th><?php echo $this->lang->line('kd_measurement')?></th>
                        <th><?php echo $this->lang->line('nm_measurement')?></th>
                        <th><?php echo $this->lang->line('weightage_kpi')?></th>
                        <th><?php echo "Total (%)"?></th>

                    </tr>
            </thead>
            <tbody>
                <?php
                $no=1;
                $KdDBTemp="";
                $Total=0;
                $TotalPersen=0;
                foreach($DataKpiPegawai->result() as $row)
                {
                    $Total=$Total+$row->weightage_kpi;
                    $Persen_kpi=round(($row->weightage_kpi/$row->Tot_bobot_kpi)*100,2);
                    $TotalPersen=$TotalPersen+$Persen_kpi;
                        if($row->kd_bd!=$KdDBTemp){
                        $KdDBTemp=$row->kd_bd;
                ?>
                <tr>
                    <td colspan="5"><b><?php echo $row->nm_bd;?></b></td>
                </tr>
                <?php
                    }
                ?>

                    <tr>
                            <td scope="row"><?php echo $no; ?></td>
                            <td><?php echo $row->kd_measurement; ?></td>
                            <td><?php echo $row->nm_measurement; ?></td>
                            <td align="right"><?php echo $row->weightage_kpi; ?></td>
                            <td align="right">
                                <a class="m-badge m-badge--success m-badge--wide button_bobot_kpi" data-id="<?php echo $row->nip; ?>" data-total-persen="<?php echo $Persen_kpi; ?>"><?php echo $Persen_kpi." %"; ?></a>
                            </td>
                    </tr>
                <?php 
                        $no++;
                    }
                    
                ?>
                    <tr>
                        <td colspan="3">Total</td>
                        <td align="right"><?php echo $Total; ?></td>
                        <td align="right"><?php echo $TotalPersen."%"; ?></td>
                    </tr>
            </tbody>
        </table>
</div>

