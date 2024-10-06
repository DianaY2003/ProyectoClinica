<!doctype html>
<html lang="en">
    <head>
        <title>Healthy Smiles</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous" />
        <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    </head>
    <body>
        <section class="vh-50" style="background-color: #6cca9b;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-xl-10">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row g-0">
                                <h1><br> </h1>
                                <div class="col-md-6 col-lg-5 d-none d-md-block">
                                    <img src="{{ asset('img/clinica.jpg') }}" alt="login form" class="img-fluid"
                                        style="padding-left: 50px; border-radius: 10px;" />
                                </div>
                                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                    <div class="card-body p-4 p-lg-5 text-black">
                                        <!-- Mostrar errores de validación -->
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="d-flex align-items-center mb-3 pb-1">
                                                <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                                <p class="h1 fw-bold mb-0">Iniciar Sesión</p>
                                            </div>
                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <label class="form-label" for="form2Example17">Correo electrónico</label>
                                                <input type="email" name="email" id="form2Example17"
                                                    class="form-control form-control-lg" value="{{ old('email') }}" required />
                                            </div>
                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <label class="form-label" for="form2Example27">Contraseña</label>
                                                <input type="password" name="password" id="form2Example27"
                                                    class="form-control form-control-lg" required />
                                            </div>
                                            <div class="pt-1 mb-4">
                                                <button data-mdb-button-init data-mdb-ripple-init
                                                    class="btn btn-dark btn-lg btn-block" type="submit">Iniciar sesión</button>
                                            </div>
                                            <a class="small text-muted" href="#!">¿Olvidaste tu contraseña?</a>
                                            <p class="mb-5 pb-lg-2" style="color: #393f81;">¿No tienes una cuenta? Registrar aquí
                                                <a href="{{ route('register') }}" style="color: #393f81;">Registrarse</a>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"></script>
    </body>
</html>
