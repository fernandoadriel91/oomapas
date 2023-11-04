<!doctype html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8" />
		<title>CS | Iniciar Sesión</title>
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

		<meta http-equiv="X-UA-Compatible" content="IE=11" />
		<link href="assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
    	<link href="assets/theme/base/style.bundle.css" rel="stylesheet" type="text/css" />
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
								<img hidden src="assets/theme/media/img/logo/logo.png" style="width: 50%">
							</a>
						</div>
					</div>
					<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver">
						<div hidden class="m-grid__item m-grid__item--middle">
							<span class="m-login__title">Whatever CTA's wave purpose important exit element</span>
							<span class="m-login__subtitle">Lorem ipsum amet estudiat</span>
						</div>
					</div>
					<div class="m-grid__item">
						<div class="m-login__info">
							<div class="m-login__section">
								<a href="#" class="m-link">&copy 2023</a>
							</div>
							<div hidden class="m-login__section">
								<a href="#" class="m-link">Privacy</a>
								<a href="#" class="m-link">Legal</a>
								<a href="#" class="m-link">Contact</a>
							</div>
						</div>
					</div>
				</div>
				<div class="m-grid__item m-grid__item--fluid  m-grid__item--order-tablet-and-mobile-1  m-login__wrapper">

					<!--begin::Head-->
					<div hidden class="m-login__head">
						<span>Don't have an account?</span>
						<a href="#" class="m-link m--font-danger">Sign Up</a>
					</div>

					<!--end::Head-->

					<!--begin::Body-->
					<div class="m-login__body">

						<!--begin::Signin-->
						<div class="m-login__signin">
							<div class="m-login__title">
								<h1>Login</h1>
							</div>

							<!--begin::Form-->
							<form class="m-login__form m-form" id="loginForm">
							{{ csrf_field() }}
								<div class="form-group m-form__group">
									<div class="input-group m-input-group">
										<input type="text" tabindex="1" class="form-control m-input" style="" placeholder="Usuario" name="username" id="username_input" autocomplete="off" aria-describedby="basic-addon2">
										<div hidden class="input-group-append">
											<span class="input-group-text" id="basic-addon2" style="border: 0; padding:0" tabindex="3">
												<select name="company" class="form-control m-input" id="company_input" style="padding:0; margin:0">
													<option value="@heroicanogales.gob.mx">@heroicanogales.gob.mx</option>
													<option value="@nogalessonora.gob.mx">@nogalessonora.gob.mx</option>
													<option value="@oomapasnogales.gob.mx">@oomapasnogales.gob.mx</option>
													<option value="@miprepanogales.mx">@miprepanogales.mx</option>
													<option value="@difnogales.org.mx">@difnogales.org.mx</option>
												</select>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" tabindex="2" type="password" placeholder="Contraseña" name="password"id="password_input" >
								</div>
								
							

							<!--end::Form-->

							<!--begin::Action-->
							<div class="m-login__action">
								<a href="#" class="m-link">
									<span></span>
								</a>
							
								<div class="m-login__form-action">
									<button type="submit" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Entrar</button>
								</div>
								
							</div>
						</form>

							<!--end::Action-->

							

							
						</div>

						<!--end::Signin-->
					</div>

					<!--end::Body-->
				</div>
			</div>
		</div>

		<script src="assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="assets/theme/base/scripts.bundle.js" type="text/javascript"></script>
		<script src="js/common.js" type="text/javascript"></script>
		<script src="js/login.js" type="text/javascript"></script>
	</body>

	<!-- end::Body -->
</html>