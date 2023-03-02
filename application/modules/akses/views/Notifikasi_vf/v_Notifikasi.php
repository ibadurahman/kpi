<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>

<div class="row">
	
	<div class="col-xl-9 col-lg-8">
		<div class="m-portlet m-portlet--full-height ">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							<?php echo isset($activity_header)?$activity_header:""; ?>
						</h3>
					</div>
				</div>
                                <div class="m-portlet__head-tools">
                                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>
                                    </div>
				</div>
				
			</div>
			<div class="m-portlet__body">
                            <div class="m-scrollable" id="list-timeline" data-scrollable="true" data-height="400" style="height: 400px; overflow: hidden;">
							
						</div>
			</div>
		</div>
	</div>
</div>