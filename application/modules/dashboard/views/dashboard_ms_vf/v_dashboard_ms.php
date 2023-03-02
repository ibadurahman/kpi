<!--Begin::Section Judul Perspective-->
<div class="row mb-3">
    <div class="col-12">
        <h3 class="m-subheader__title m-subheader__title--separator"><?php echo $nm_measurement; ?></h3>
    </div>
</div>
<!--End::Section Judul Perspective-->
<!--Begin::Section perusahaan-->
<div class="row mb-3">
	<div class="col-xl-4">
            <div class="row">
            
                    <div class="col-12">
                        <div class="m-portlet m-portlet--tab m-portlet--full-height">
<!--                                <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                        <span class="m-portlet__head-icon m--hide">
                                                                <i class="la la-gear"></i>
                                                        </span>
                                                        <h3 class="m-portlet__head-text">
                                                                <?php // echo $this->lang->line('company_score'); ?>
                                                        </h3>
                                                </div>
                                        </div>
                                </div>-->
                                <div class="m-portlet__body">
                                        <div id="basic-gauge" style="height: 200px;"></div>
                                </div>
                        </div>
                    </div>
            
		<!--end:: Widgets/Tasks -->
            </div>
        </div>
    <div class="col-xl-8">
        <div class="row">
            <div class="col-xl-12">
		<!--begin:: Widgets/New Users-->
		<div class="m-portlet m-portlet--full-height ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('bd_detail'); ?>
						</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<ul class="nav nav-pills nav-pills--success m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_widget4_tab1_content" role="tab">
								<?php echo $this->lang->line('tab_company_grafik'); ?>
							</a>
						</li>
						<!-- <li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_widget4_tab2_content" role="tab">
								<?php //echo $this->lang->line('tab_company_detail'); ?>
							</a>
						</li> -->
					</ul>
				</div>
			</div>
			<div class="m-portlet__body">
				<div class="tab-content">
					<div class="tab-pane active" id="m_widget4_tab1_content">

						<!--begin::Widget 14-->
						<div class="m-widget4">

							<div id="m_amcharts_7" style="height: 300px;"></div>
						</div>

						<!--end::Widget 14-->
					</div>
					<!-- <div class="tab-pane" id="m_widget4_tab2_content">

						<div class="m-widget11">
							<div class="table-responsive">

								<table class="table">

									<thead>
										<tr>
											<td class="m-widget11__label">#</td>
											<td class="m-widget11__app"><?php //echo $this->lang->line('dept_kpi'); ?></td>
											<td class="m--align-right m-widget11__sales"><?php //echo $this->lang->line('gross_score'); ?></td>
											<td class="m--align-right m-widget11__price"><?php //echo $this->lang->line('weightage'); ?></td>
											<td class="m-widget11__total m--align-right"><?php //echo $this->lang->line('score'); ?></td>
										</tr>
									</thead>

									<tbody>
                                                                            <?php 
                                                                                // if(isset($data_dept)){
                                                                                //     $no=1;
                                                                                //     $TotScore=0;
                                                                                //     foreach($data_dept->result() as $row)
                                                                                //     {
                                                                                //         $listBobot= explode(",", $row->weightage_bd);
                                                                                //         $ArrBobot=array();
                                                                                //         //var_dump($listBobot);
                                                                                //         foreach($listBobot as $val){
                                                                                //             $cal=$val*100;
                                                                                //             $ArrBobot[$val]=$cal."%";
                                                                                //         }
                                                                                //         $bobot= implode(", ", $ArrBobot);
                                                                            ?>
										<tr>
											<td>
												<span class="m-widget11__title"><?php //echo $no; ?></span>
											</td>
											<td>
												<span class="m-widget11__title"><?php //echo $row->nm_departemen; ?></span>
											</td>
											<td class="m--align-right"><?php //echo $row->gross_point; ?></td>
											<td class="m--align-right"><?php //echo $bobot; ?></td>
											<td class="m--align-right m--font-brand"><?php //echo $row->point; ?></td>
										</tr>
                                                                            <?php   
                                                                                //         $TotScore=$TotScore+$row->point;
                                                                                //         $no++;
                                                                                //     }
                                                                                // }
                                                                            ?>
                                                                                <tr>
                                                                                    <td colspan="4" class="m--align-right">
                                                                                        <span class="m-widget11__title"><?php //echo $this->lang->line('tot_score'); ?></span>
                                                                                    </td>
                                                                                    <td class="m--align-right m--font-brand"><?php //echo $TotScore; ?></td>
                                                                                </tr>
									</tbody>

								</table>

							</div>
						</div>

					</div> -->
				</div>
			</div>
		</div>

		<!--end:: Widgets/New Users-->
            </div>
	</div>
    </div>
</div>
<!--End::Section perusahaan-->
<!--Begin::Section Perspective-->
<!--Begin::Section Perpective Header-->
<div class="row mb-3">
    <div class="col-12">
        <h3 class="m-subheader__title m-subheader__title--separator"><?php echo $this->lang->line('ms_peg'); ?></h3>
    </div>
</div>
<!--End::Section Perpective Header-->
<!--Begin::Section Perspective Detail chart-->
<div class="row">
    <div class="col-12">
        <div class="m-portlet">
                <div class="m-portlet__body  m-portlet__body--no-padding">
                        <div class="row m-row--no-padding m-row--col-separator-xl">
                          
                                <div class="col-xl-12">

                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="m-widget14">
                                          
                                            <div class="row  align-items-center">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">

                                                        <!--begin::Table-->
                                                        <table class="table">

                                                                    <!--begin::Thead-->
                                                                    <thead>
                                                                            <tr>
                                                                                    <td class="m-widget11__label">#</td>
                                                                                    <td class="m-widget11__app"><?php echo $this->lang->line('period'); ?></td>
                                                                                    <td class="m-widget11__app"><?php echo $this->lang->line('nip'); ?></td>
                                                                                    <td class="m--align-right m-widget11__app"><?php echo $this->lang->line('nama'); ?></td>
                                                                                    <td class="m--align-right m-widget11__price"><?php echo $this->lang->line('kd_departemen'); ?></td>
                                                                                    <td class="m-widget11__total m--align-right"><?php echo $this->lang->line('kd_jabatan'); ?></td>
                                                                                    <td class="m--align-right m-widget11__sales"><?php echo $this->lang->line('score'); ?></td>
                                                                                    <td class="m--align-right m-widget11__sales"></td>
                                                                            </tr>
                                                                    </thead>

                                                                    <!--end::Thead-->

                                                                    <!--begin::Tbody-->
                                                                    <tbody>
                                                                        <?php 
                                                                            $avg=0;
                                                                            if(isset($data_peg)){
                                                                                $no=1;
                                                                                $TotScore=0;
                                                                                $score=[];
                                                                                foreach($data_peg->result() as $row)
                                                                                {
                                                                                    $score[]=$row->point_result;
                                                                                    if(isset($row->bulan)){
                                                                                        $period = getNamaBulanMin($row->bulan)." ".$row->tahun;
                                                                                    }else{
                                                                                        $period = $row->tahun;
                                                                                    }
                                                                        ?>
                                                                            <tr>
                                                                                    <td>
                                                                                            <span class="m-widget11__title"><?php echo $no; ?></span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span class="m-widget11__title"><?php echo $period; ?></span>
                                                                                            <!--<span class="m-widget11__sub">Vertex To By Again</span>-->
                                                                                    </td>
                                                                                    <td>
                                                                                            <span class="m-widget11__title"><?php echo $row->nip; ?></span>
                                                                                    </td>
                                                                                    <td>
                                                                                            <span class="m-widget11__title"><?php echo $row->nama; ?></span>
                                                                                    </td>
                                                                                    <td class="m--align-right"><?php echo $row->nm_departemen; ?></td>
                                                                                    <td class="m--align-right"><?php echo $row->nm_jabatan; ?></td>
                                                                                    <td class="m--align-right m--font-brand"><?php echo $row->point_result; ?></td>
                                                                                    <td class="m--align-center">
                                                                                        <a href="<?php echo site_url("dashboard/DashboardPeg/index/".$row->nip."/".$DataTahun."/".$DataBulan); ?>" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill button_view_kpi">
                                                                                            <i class="la la-file-text"></i>
                                                                                        </a>
                                                                                    </td>
                                                                            </tr>
                                                                        <?php   
                                                                                    //$TotScore=$TotScore+$row->point;
                                                                                    $no++;
                                                                                }
                                                                                $avg=round(array_sum($score) / count($score));
                                                                            }
                                                                        ?>
                                                                            <tr>
                                                                                <td colspan="6" class="m--align-right">
                                                                                    <span class="m-widget11__title"><?php echo $this->lang->line('avg_score'); ?></span>
                                                                                </td>
                                                                                <td class="m--align-right m--font-brand"><?php echo $avg; ?></td>
                                                                            </tr>
                                                                    </tbody>

                                                                    <!--end::Tbody-->
                                                        </table>

                                                        <!--end::Table-->
                                                    </div>
							                    </div>
                                            </div>
                                    </div>

                                        <!--end:: Widgets/Profit Share-->
                                </div>
                        </div>
                </div>
        </div>        
    </div>
</div>
<!--End::Section Perspective Detail chart-->
<!--End::Section Perspective-->

		
		