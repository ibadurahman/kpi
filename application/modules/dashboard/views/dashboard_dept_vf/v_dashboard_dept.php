<!--Begin::line chart Dept-->
<div class="row mb-3">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-md-12">
                <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                                <span class="m-portlet__head-icon m--hide">
                                                        <i class="la la-gear"></i>
                                                </span>
                                                <h3 class="m-portlet__head-text">
                                                        <?php echo $this->lang->line('dept_chart'); ?>
                                                </h3>
                                        </div>
                                </div>
                        </div>
                        <div class="m-portlet__body">
                                <div id="chart-line-dept" style="height: 300px;"></div>
                        </div>
                </div>

            </div>
	</div>
    </div>
</div>
<!--End::line chart Dept-->
<!--Begin::detail kpi Dept-->
<?php
if(isset($DeptKpiDetail)){
?>
<div class="row mb-3">
        <?php
        foreach($DeptKpiDetail->result() as $row){
            $kd_dept=$row->kd_departemen;
            $nm_dept=$row->nm_departemen;

        ?>
    <div class="col-xl-6">
        <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                        <span class="m-portlet__head-icon m--hide">
                                                <i class="la la-gear"></i>
                                        </span>
                                        <h3 class="m-portlet__head-text">
                                                <?php echo $nm_dept; ?>
                                        </h3>
                                </div>
                        </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget3">
                            <div class="m-widget3__item">
                                    <div class="m-widget3__header">
                                            <div class="m-widget3__info">
                                                    <span class="m-widget3__username">
                                                            Score
                                                    </span>
                                                    <br>
                                            </div>
                                    </div>
                                    <div class="m-widget3__body">
                                            <div id="<?php echo "chart-line-".$kd_dept ?>" style="height: 300px;"></div>
                                            <div class="m-widget11__action m--align-right">
							<a href="<?php echo site_url("dashboard/DashboardDept/dept/".$kd_dept."/".$DataTahun."/".$DataBulan); ?>" class="btn m-btn--pill btn-outline-success m-btn m-btn--custom">View</a>
						</div>
                                    </div>
                            </div>
                           
                    </div>
                        
                </div>
        </div>
    </div>
    
        <?php
        }
        ?>
 
</div>
<?php
}
?>
<!--End::detail kpi Dept-->
		
		