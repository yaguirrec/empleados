

	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="img/login1.png" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form id="loginForm">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" id="txtNomina" class="form-control input_user" placeholder="Número de nómina" autofocus>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" id="txtClave" class="form-control input_pass" placeholder="Clave de acceso">
						</div>
						<hr>
						<div class="d-flex justify-content-center mt-3 login_container">
							<button type="submit" class="btn btn-block login_btn" id="btnEntrar">Ingresar</button>
							<input type="hidden" id="type" value="login">
						</div>
					</form>
				</div>
				<div class="mt-4">
					<div class="d-flex justify-content-center">
						<a href="#" class="links">¿Olvidaste tu contraseña?</a>
					</div>
				</div>
			</div>
		</div>
	</div>