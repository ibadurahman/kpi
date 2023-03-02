<div class="row">
        <div class="col-xl-4">
            <div class="row">
                <div class="col-xl-12">
                    <div class="m-portlet m-portlet--skin-dark m--bg-accent">
			<div class="m-portlet__body">
                            <div class="m-stack m-stack--hor m-stack--general">
                                <div class="m-stack__item m-stack__item--right">
                                    <h1 class="">30</h1>
                                    <h4 class=""><?php echo $this->lang->line('avg_age'); ?></h4>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="m-portlet m-portlet--skin-dark m--bg-warning">
			<div class="m-portlet__body">
                            <div class="m-stack m-stack--hor m-stack--general">
                                <div class="m-stack__item m-stack__item--right">
                                    <h1 class="">1.1 %</h1>
                                    <h4 class=""><?php echo $this->lang->line('turnover_rate'); ?></h4>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
	</div>
	<div class="col-xl-4">

		<!--begin:: Widgets/Support Requests-->
		<div class="m-portlet  m-portlet--full-height ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('total_peg'); ?>
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body pt-0">
                            <?php
                            if(count($gender_pie)>0){
                            ?>
                                <div class="m-widget16">
					<div class="row">
						<div class="col-md-12">
							<div class="m-widget16__stats mt-0">
								<div class="m-widget16__visual">
									<div id="jml_peg_pie" class="m-widget16__chart" style="height: 180px">
										<div class="m-widget16__chart-number"><?php echo $gender_pie['total'] ?></div>
									</div>
								</div>
								<div class="m-widget16__legends">
                                                                    <?php
                                                                    if(count($gender_pie['detail'])>0){
                                                                        foreach ($gender_pie['detail'] as $val){
                                                                            $label="";
                                                                            if($val['label']=='L'){
                                                                                $label=$this->lang->line('pria');
                                                                            }else if($val['label']=='P'){
                                                                                $label=$this->lang->line('wanita');
                                                                            }
                                                                    ?>
                                                                        <div class="m-widget16__legend">
										<span class="m-widget16__legend-bullet m--bg-<?php echo $val['color'];?>"></span>
										<span class="m-widget16__legend-text"><?php echo $val['value']." ".$label;?></span>
									</div>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
								</div>
							</div>
						</div>
					</div>
				</div>
                            <?php
                            }
                            ?>
                        </div>
		</div>

		<!--end:: Widgets/Support Requests-->
	</div>
	<div class="col-xl-4">
            
            <div class="row">
                <div class="col-xl-12">
                    <div class="m-portlet m-portlet--skin-dark m--bg-success">
			<div class="m-portlet__body">
                            <div class="m-stack m-stack--hor m-stack--general">
                                <div class="m-stack__item m-stack__item--left">
                                    <h1 class=""><?php echo $hire_left['hire']; ?></h1>
                                    <h4 class=""><?php echo $this->lang->line('total_hire')." ".$DataTahun; ?></h4>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="m-portlet m-portlet--skin-dark m--bg-danger">
			<div class="m-portlet__body">
                            <div class="m-stack m-stack--hor m-stack--general">
                                <div class="m-stack__item m-stack__item--left">
                                    <h1 class=""><?php echo $hire_left['left']; ?></h1>
                                    <h4 class=""><?php echo $this->lang->line('total_resign')." ".$DataTahun; ?></h4>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
	</div>
</div>

<!--End::line chart Dept-->

<div class="row">
	<div class="col-xl-6">

		<!--begin:: Widgets/Support Cases-->
		<div class="m-portlet  m-portlet--full-height ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('range_umur'); ?>
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
                            <?php
                            if(count($kelompok_umur_pie)>0){
                            ?>
				<div class="m-widget16">
					<div class="row">
						<div class="col-md-12">
							<div class="m-widget16__stats">
								<div class="m-widget16__visual">
									<div id="kelompok_umur_pie" style="height: 180px">
									</div>
								</div>
								<div class="m-widget16__legends">
                                                                    <?php
                                                                    foreach($kelompok_umur_pie as $val){
                                                                    ?>
                                                                        <div class="m-widget16__legend">
										<span class="m-widget16__legend-bullet m--bg-<?php echo $val['color'] ?>"></span>
										<span class="m-widget16__legend-text"><?php echo $val['label'] ?></span>
									</div>
                                                                    <?php
                                                                    }
                                                                    ?>
								</div>
							</div>
						</div>
					</div>
				</div>
                            <?php
                            }
                            ?>
			</div>
		</div>

		<!--end:: Widgets/Support Stats-->
	</div>
	<div class="col-xl-6">

		<!--begin:: Widgets/Support Cases-->
		<div class="m-portlet  m-portlet--full-height ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('jml_peg_dept'); ?>
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
                            <?php
                            if(isset($tot_peg_dept_pie) and count($tot_peg_dept_pie)>0){
                            ?>
				<div class="m-widget16">
					<div class="row">
						<div class="col-md-12">
							<div class="m-widget16__stats">
								<div class="m-widget16__visual">
									<div id="jml_peg_dept_pie" style="height: 180px">
									</div>
								</div>
								<div class="m-widget16__legends">
                                                                    <?php
                                                                    foreach($tot_peg_dept_pie as $val){
                                                                    ?>
                                                                        <div class="m-widget16__legend">
                                                                            <span class="m-widget16__legend-bullet" style="background-color: <?php echo $val['color_code'] ?> !important"></span>
										<span class="m-widget16__legend-text"><?php echo $val['label'] ?></span>
									</div>
                                                                    <?php
                                                                    }
                                                                    ?>
								</div>
							</div>
						</div>
					</div>
				</div>
                            <?php
                            }
                            ?>
			</div>
		</div>

		<!--end:: Widgets/Support Stats-->
	</div>
</div>

<div class="row">
        <div class="col-xl-6">

		<!--begin:: Widgets/Support Requests-->
		<div class="m-portlet  m-portlet--full-height ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('total_peg_period'); ?>
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
                                <div id="chart-bar-pegawai" style="height: 300px;"></div>
                        </div>
		</div>

		<!--end:: Widgets/Support Requests-->
	</div>
	<div class="col-xl-6">

		<!--begin:: Widgets/Support Requests-->
		<div class="m-portlet  m-portlet--full-height ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('turnover'); ?>
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
                                <div id="chart-bar-turnover" style="height: 300px;"></div>
                        </div>
		</div>

		<!--end:: Widgets/Support Requests-->
	</div>
</div>
<div class="row">
        <div class="col-xl-6">

		<!--begin:: Widgets/Support Requests-->
		<div class="m-portlet  ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('total_peg_period'); ?>
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
                                <div id="chart-bar-kpi" style="height: 1000px;"></div>
                        </div>
		</div>

		<!--end:: Widgets/Support Requests-->
	</div>
</div>		
		