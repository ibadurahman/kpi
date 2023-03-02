<!--Begin::Section Judul Departemen-->
<div class="row mb-3">
    <div class="col-12">
        <h3 class="m-subheader__title m-subheader__title--separator"><?php echo $DetailKPIDept['nm_departemen']; ?></h3>
    </div>
</div>
<!--End::Section Judul Departemen-->
<!--Begin::Section Departemen-->
<div class="row mb-3">
	<div class="col-md-5">
            <div class="m-portlet m-portlet--tab m-portlet--full-height">
<!--                    <div class="m-portlet__head">
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
                            <div class="mt-5" id="basic-gauge" style="height: 300px;"></div>
                    </div>
            </div>
        </div>
    <div class="col-md-7">
	<!--begin:: Widgets/New Users-->
	<div class="m-portlet m-portlet--full-height ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('dept_detail'); ?>
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
				</div>
			</div>
		</div>

	<!--end:: Widgets/New Users-->
    </div>
</div>
<!--End::Section Departemen-->
<!--Begin::Section Measurement-->
<!--Begin::Section Measurement Header-->
<div class="row mb-3">
    <div class="col-12">
        <h3 class="m-subheader__title m-subheader__title--separator"><?php echo $this->lang->line('ms_dept'); ?></h3>
    </div>
</div>
<!--End::Section Measurement Header-->
<div class="row">
    <div class="col">
        <div class="m-portlet m-portlet--bordered m-portlet--unair">
            <div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo $this->lang->line('pg_detail'); ?>
						</h3>
					</div>
				</div>
			</div>
            <div class="m-portlet__body">
                <div class="table-responsive">

                    <!--begin::Table-->
                    <table class="table">

                                <!--begin::Thead-->
                                <thead>
                                        <tr>
                                                <td class="m-widget11__label">#</td>
                                                <td class="m-widget11__app"><?php echo $this->lang->line('period'); ?></td>
                                                <td class="m-widget11__app"><?php echo $this->lang->line('nip'); ?></td>
                                                <td class="m-widget11__app"><?php echo $this->lang->line('nama'); ?></td>
                                                <td class="m-widget11__price"><?php echo $this->lang->line('kd_departemen'); ?></td>
                                                <td class="m-widget11__total"><?php echo $this->lang->line('jabatan'); ?></td>
                                                <td class="m--align-right m-widget11__sales"><?php echo $this->lang->line('score'); ?></td>
                                                <td class="m--align-right m-widget11__sales"></td>
                                        </tr>
                                </thead>

                                <!--end::Thead-->

                                <!--begin::Tbody-->
                                <tbody>
                                    <?php 
                                        $avg=0;
                                        if(isset($peg_kpi)){
                                            $no=1;
                                            $TotScore=0;
                                            $score=[];
                                            foreach($peg_kpi->result() as $row)
                                            {
                                                $score[]=$row->point;
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
                                                <td><?php echo $row->nm_departemen; ?></td>
                                                <td><?php echo $row->nm_jabatan; ?></td>
                                                <td class="m--align-right m--font-brand"><?php echo $row->point; ?></td>
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
</div>

<!--End::Section Departemen-->

		
		