<!DOCTYPE html>

<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title><?php echo $title; ?></title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
                <?php
                        /** -- Copy from here -- */
                        if(!empty($meta))
                        foreach($meta as $name=>$content){
                                echo "\n\t\t";
                                ?><meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" /><?php
                                         }
                        echo "\n";


                        /** -- to here -- */
                ?>
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
				google: {
					"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>

		<!--end::Web font -->

		<!--begin::Page Vendors Styles -->
		<link href="<?php echo base_url();?>assets/metronic/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<!--end::Page Vendors Styles -->

		<!--begin::Base Styles -->
		<link href="<?php echo base_url();?>assets/metronic/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link href="<?php echo base_url();?>assets/metronic/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<!--end::Base Styles -->
		<link rel="shortcut icon" href="<?php echo base_url();?>assets/metronic/assets/demo/default/media/img/logo/favicon.ico" />
                
                <?php

                        if(!empty($canonical))
                        {
                                echo "\n\t\t";
                                ?><link rel="canonical" href="<?php echo $canonical?>" /><?php

                        }
                        echo "\n\t";

                        foreach($css as $file){
                                echo "\n\t\t";
                                ?><link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" /><?php
                        } echo "\n\t";

                ?>
                                        
		<script>
			(function(i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] || function() {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
			ga('create', 'UA-37564768-1', 'auto');
			ga('send', 'pageview');
		</script>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Header -->
			
                        <?php echo $this->load->get_section('t_header');?>
			<!-- END: Header -->

			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

				<!-- BEGIN: Left Aside -->
                                
				<?php echo $this->load->get_section('t_sidebar');?>

				<!-- END: Left Aside -->
				<!-- BEGIN: content -->
				<?php echo $output;?>

				<!-- END: content -->
			</div>

			<!-- end:: Body -->

			<!-- begin::Footer -->
			
                        <?php echo $this->load->get_section('t_footer');?>
			<!-- end::Footer -->
		</div>

		<!-- end:: Page -->

		<!-- begin::Quick Sidebar -->
		<?php echo $this->load->get_section('t_qsidebar');?>

		<!-- end::Quick Sidebar -->

		<!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
			<i class="la la-arrow-up"></i>
		</div>

		<!-- end::Scroll Top -->

		<!-- begin::Quick Nav -->
		<ul class="m-nav-sticky" style="margin-top: 30px;">
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Purchase" data-placement="left">
				<a href="https://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" target="_blank">
					<i class="la la-cart-arrow-down"></i>
				</a>
			</li>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Documentation" data-placement="left">
				<a href="https://keenthemes.com/metronic/documentation.html" target="_blank">
					<i class="la la-code-fork"></i>
				</a>
			</li>
			<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Support" data-placement="left">
				<a href="https://keenthemes.com/forums/forum/support/metronic5/" target="_blank">
					<i class="la la-life-ring"></i>
				</a>
			</li>
		</ul>

		<!-- begin::Quick Nav -->

		<!--begin::Base Scripts -->
		<script src="<?php echo base_url();?>assets/metronic/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>assets/metronic/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
                
		<!--end::Base Scripts -->

		<!--begin::Page Vendors Scripts -->
		<script src="<?php echo base_url();?>assets/metronic/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>

		<!--end::Page Vendors Scripts -->

		<!--begin::Page Snippets -->
		<script src="<?php echo base_url();?>assets/metronic/assets/app/js/dashboard.js" type="text/javascript"></script>

		<!--end::Page Snippets -->
                <?php

                        foreach($js as $file){
                                        echo "\n\t\t";
                                        ?><script src="<?php echo $file; ?>"></script><?php
                        } echo "\n\t";

                ?>
	</body>

	<!-- end::Body -->
</html>