<!--Begin::Section-->
<div class="m-portlet ">
	<div class="m-portlet__body  m-portlet__body--no-padding">
		<div class="row m-row--no-padding m-row--col-separator-xl">
			<div class="col-md-12 col-lg-6 col-xl-3">

				<!--begin::Total Profit-->
                                <div class="m-widget24">
					<div class="m-widget24__item">
                                            <div style="margin: 20px auto; padding: 10px;">
                                                <?php
                                                    if($logo!=""){
                                                        $LinkFoto= base_url('assets/upload/logo/'.$logo);
                                                    }else{
                                                        $LinkFoto= base_url('assets/img/NoImage.png');
                                                    } 
                                                ?>
                                                <img src="<?php echo $LinkFoto; ?>" alt="" style="width: 220px;">
                                            </div>
					</div>
				</div>

				<!--end::Total Profit-->
			</div>
			<div class="col-md-12 col-lg-6 col-xl-3">

				<!--begin::New Feedbacks-->
				<div class="m-widget24">
					<div class="m-widget24__item">
						<h4 class="m-widget24__title">
							<?php echo $this->lang->line('jml_pegawai_aktif'); ?>
						</h4>
						<br>
						<span class="m-widget24__desc">
							<?php echo $this->lang->line('jml_pegawai_aktif')." ".$DataTahun; ?>
						</span>
						<span class="m-widget24__stats m--font-accent">
							<?php echo $tot_pegawai; ?>
						</span>
						<div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                        <?php
                                                        if($tot_pegawai==0){
                                                            $tot_pegawai=1;
                                                            $persenTotalPeg=0*100;
                                                        }else{
                                                            $persenTotalPeg=round(($tot_pegawai/$tot_pegawai)*100,2);
                                                        }
                                                            
                                                        ?>
							<div class="progress-bar m--bg-accent" role="progressbar" style="width: <?php echo $persenTotalPeg."%"; ?>;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							
						</span>
						<span class="m-widget24__number">
							<?php echo $persenTotalPeg."%"; ?>
						</span>
					</div>
				</div>

				<!--end::New Feedbacks-->
			</div>
			<div class="col-md-12 col-lg-6 col-xl-3">

				<!--begin::New Users-->
				<div class="m-widget24">
					<div class="m-widget24__item">
						<h4 class="m-widget24__title">
							<?php echo $this->lang->line('jml_pegawai_baru'); ?>
						</h4>
						<br>
						<span class="m-widget24__desc">
							<?php echo $this->lang->line('jml_pegawai_baru')." ".$DataTahun; ?>
						</span>
						<span class="m-widget24__stats m--font-success">
							<?php echo $tot_pegawai_baru; ?>
						</span>
						<div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                        <?php
                                                            $persenTotalPegBaru=round(($tot_pegawai_baru/$tot_pegawai)*100,2);
                                                        ?>
							<div class="progress-bar m--bg-success" role="progressbar" style="width: <?php echo $persenTotalPegBaru."%"; ?>;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							
						</span>
						<span class="m-widget24__number">
							<?php echo $persenTotalPegBaru."%"; ?>
						</span>
					</div>
				</div>

				<!--end::New Users-->
			</div>
			<div class="col-md-12 col-lg-6 col-xl-3">

				<!--begin::New Orders-->
				<div class="m-widget24">
					<div class="m-widget24__item">
						<h4 class="m-widget24__title">
							<?php echo $this->lang->line('jml_pegawai_keluar'); ?>
						</h4>
						<br>
						<span class="m-widget24__desc">
							<?php echo $this->lang->line('jml_pegawai_keluar')." ".$DataTahun; ?>
						</span>
						<span class="m-widget24__stats m--font-danger">
							<?php echo $tot_pegawai_keluar; ?>
						</span>
						<div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                        <?php
                                                            $persenTotalPegKeluar=round(($tot_pegawai_keluar/$tot_pegawai)*100,2);
                                                        ?>
							<div class="progress-bar m--bg-danger" role="progressbar" style="width: <?php echo $persenTotalPegKeluar."%"; ?>;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<span class="m-widget24__change">
							
						</span>
						<span class="m-widget24__number">
							<?php echo $persenTotalPegKeluar."%"; ?>
						</span>
					</div>
				</div>

				<!--end::New Orders-->
			</div>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-md-4">
        
        <div class="m-portlet m-portlet--tab">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
					</span>
					<h3 class="m-portlet__head-text">
						<?php echo $this->lang->line('performa_perusahaan'); ?>
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<div id="m_amcharts_9" style="height: 300px;"></div>
		</div>
	</div>
    </div>
    <div class="col-md-8">
        <div class="m-portlet m-portlet--tab">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
					</span>
					<h3 class="m-portlet__head-text">
						<?php echo $this->lang->line('performa_perusahaan_history'); ?>
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<div id="m_amcharts_7" style="height: 300px;"></div>
		</div>
	</div>
        
    </div>
</div>      
<div class="row">
    <div class="col-md-6">
        <div class="m-portlet m-portlet--full-height ">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						<?php echo $this->lang->line('top10')." ".$DataTahun; ?>
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<div class="m-widget6">
				<div class="m-widget6__head">
					<div class="m-widget6__item">
						<span class="m-widget6__caption">
							<?php echo $this->lang->line('top_nip'); ?>
						</span>
						<span class="m-widget6__caption">
							<?php echo $this->lang->line('top_nama'); ?>
						</span>
						<span class="m-widget6__caption m--align-right">
							<?php echo $this->lang->line('top_score'); ?>
						</span>
					</div>
				</div>
				<div class="m-widget6__body">
                                    <?php
                                    foreach($list_top10->result() as $row_top10){
                                    ?>
                                        <div class="m-widget6__item">
						<span class="m-widget6__text">
							<?php echo $row_top10->nip;?>
						</span>
						<span class="m-widget6__text">
							<?php echo $row_top10->nama;?>
						</span>
						<span class="m-widget6__text m--align-right m--font-boldest m--font-brand">
							<?php echo $row_top10->score_avg;?>
						</span>
					</div>
                                    <?php
                                    }
                                    ?>
					
				</div>
			</div>
		</div>
	</div>
    </div>
    <div class="col-md-6">
        <div class="m-portlet m-portlet--full-height ">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						<?php echo $this->lang->line('bottom10')." ".$DataTahun; ?>
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			<div class="m-widget6">
				<div class="m-widget6__head">
					<div class="m-widget6__item">
						<span class="m-widget6__caption">
							<?php echo $this->lang->line('top_nip'); ?>
						</span>
						<span class="m-widget6__caption">
							<?php echo $this->lang->line('top_nama'); ?>
						</span>
						<span class="m-widget6__caption m--align-right">
							<?php echo $this->lang->line('top_score'); ?>
						</span>
					</div>
				</div>
				<div class="m-widget6__body">
                                    <?php
                                    foreach($list_bottom10->result() as $row_bottom10){
                                    ?>
                                        <div class="m-widget6__item">
						<span class="m-widget6__text">
							<?php echo $row_bottom10->nip;?>
						</span>
						<span class="m-widget6__text">
							<?php echo $row_bottom10->nama;?>
						</span>
						<span class="m-widget6__text m--align-right m--font-boldest m--font-brand">
							<?php echo $row_bottom10->score_avg;?>
						</span>
					</div>
                                    <?php
                                    }
                                    ?>
					
				</div>
			</div>
		</div>
	</div>
    </div>
</div>
		<!--Begin::Section-->
		

		<!--End::Section-->

		
                
<div class="modal fade" id="home_modal" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="form_header"><?php echo (isset($header_modal))?$header_modal:""; ?></h5>
<!--				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="la la-remove"></span>
				</button>-->
			</div>
                        <?php echo form_open('dashboard/Home/pilih_perusahaan',["class"=>"m-form m-form--state","id"=>"form_input"]);?>
			<!--<form class="m-form m-form--fit m-form--label-align-right">-->
				<div class="modal-body">
                                        
                                    <div class="form-group m-form__group m--margin-bottom-20">
                                            <?php echo form_label($this->lang->line('kd_perusahaan')."<span class='m--font-danger'>*</span>",'kd_perusahaan');?>
                                            <?php echo form_dropdown('kd_perusahaan', 
                                                                        $ListMenuPerusahaan, 
                                                                        set_value('kd_perusahaan'),
                                                                        "id='kd_perusahaan' style='width: 100%' class='select2 form-control m-select2' 
                                                                        data-placeholder='".$this->lang->line('kd_perusahaan')."'"); 

                                            ?>
                                    </div>
				</div>
				<div class="modal-footer">
                                    <button type="submit" class="btn btn-success" id="tombol_submit">Submit</button>
                                    <!--<button type="button" class="btn btn-secondary" id="tombol-cancel" data-dismiss="modal">Close</button>-->
				</div>
			<!--</form>-->
                        <?php echo form_close(); ?>
		</div>
	</div>
</div>
		