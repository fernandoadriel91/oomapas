<!doctype html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8" />
		<title>Metronic | Login Page - 6</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
				google: {
					"families": ["Titillium Web:300,400,500,600,700", "Roboto:300,400,500,600,700"]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>

		<link href="assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
    	<link href="assets/theme/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles -->
		<link rel="shortcut icon" href="assets/theme/media/img/logo/favicon.ico" />
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-grid--hor-tablet-and-mobile m-login m-login--6" id="m_login">
				<div class="m-grid__item   m-grid__item--order-tablet-and-mobile-2  m-grid m-grid--hor m-login__aside " style="background-image: url(../../../assets/app/media/img//bg/bg-4.jpg);">
					<div class="m-grid__item">
						<div class="m-login__logo">
							<a href="#">
								<img src="assets/theme/media/img/logo/logo.png" style="width: 50%">
							</a>
						</div>
					</div>
					<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver">
						<div class="m-grid__item m-grid__item--middle">
							<span class="m-login__title">Whatever CTA's wave purpose important exit element</span>
							<span class="m-login__subtitle">Lorem ipsum amet estudiat</span>
						</div>
					</div>
					<div class="m-grid__item">
						<div class="m-login__info">
							<div class="m-login__section">
								<a href="#" class="m-link">&copy 2018 Metronic</a>
							</div>
							<div class="m-login__section">
								<a href="#" class="m-link">Privacy</a>
								<a href="#" class="m-link">Legal</a>
								<a href="#" class="m-link">Contact</a>
							</div>
						</div>
					</div>
				</div>
				<div class="m-grid__item m-grid__item--fluid  m-grid__item--order-tablet-and-mobile-1  m-login__wrapper">

					<!--begin::Head-->
					<div class="m-login__head">
						<span>Don't have an account?</span>
						<a href="#" class="m-link m--font-danger">Sign Up</a>
					</div>

					<!--end::Head-->

					<!--begin::Body-->
					<div class="m-login__body">

						<!--begin::Signin-->
						<div class="m-login__signin">
							<div class="m-login__title">
								<h3>Create Account</h3>
							</div>

							<!--begin::Form-->
							<form class="m-login__form m-form" action="">
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Username" name="username" autocomplete="off">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
								</div>
							</form>

							<!--end::Form-->

							<!--begin::Action-->
							<div class="m-login__action">
								<a href="#" class="m-link">
									<span>Forgot Password ?</span>
								</a>
								<a href="#">
									<button id="m_login_signin_submit" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Sign In</button>
								</a>
							</div>

							<!--end::Action-->

							<!--begin::Divider-->
							<div class="m-login__form-divider">
								<div class="m-divider">
									<span></span>
									<span>OR</span>
									<span></span>
								</div>
							</div>

							<!--end::Divider-->

							<!--begin::Options-->
							<div class="m-login__options">
								<a href="#" class="btn btn-primary m-btn m-btn--pill  m-btn  m-btn m-btn--icon">
									<span>
										<i class="fab fa-facebook-f"></i>
										<span>Facebook</span>
									</span>
								</a>
								<a href="#" class="btn btn-info m-btn m-btn--pill  m-btn  m-btn m-btn--icon">
									<span>
										<i class="fab fa-twitter"></i>
										<span>Twitter</span>
									</span>
								</a>
								<a href="#" class="btn btn-danger m-btn m-btn--pill  m-btn  m-btn m-btn--icon">
									<span>
										<i class="fab fa-google"></i>
										<span>Google</span>
									</span>
								</a>
							</div>

							<!--end::Options-->
						</div>

						<!--end::Signin-->
					</div>

					<!--end::Body-->
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!--begin::Global Theme Bundle -->
		<script src="assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    	<script src="assets/theme/base/scripts.bundle.js" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts -->
		<script src="../../../assets/snippets/custom/pages/user/login6.js" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>