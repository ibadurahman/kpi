<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$ci= new CI_Controller();
$ci =& get_instance();
?>
<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>404 Page Not Found</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

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

		<!--begin::Base Styles -->
		<link href="<?php echo base_url();?>assets/metronic/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="../../../assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link href="<?php echo base_url();?>assets/metronic/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="../../../assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<!--end::Base Styles -->
		<link rel="shortcut icon" href="<?php echo base_url();?>assets/metronic/assets/demo/default/media/img/logo/favicon.ico" />
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
	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid  m-error-1" style="background-image: url(<?php echo base_url();?>assets/metronic/assets/app/media/img//error/bg1.jpg);">
				<div class="m-error_container">
<!--					<span class="m-error_number">
						<h1><?php //echo $heading; ?></h1>
					</span>
					<p class="m-error_desc">
						<?php //echo $message; ?>
					</p>-->
                                        <span class="m-error_number">
						<h1>404</h1>
					</span>
					<p class="m-error_desc">
						OOPS! Something went wrong here
					</p>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!--begin::Base Scripts -->
		<script src="<?php echo base_url();?>assets/metronic/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>assets/metronic/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>

		<!--end::Base Scripts -->
	</body>

	<!-- end::Body -->
</html>