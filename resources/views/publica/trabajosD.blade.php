<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Healthy Smile - Servicios</title>
    <style>
        #menu-toggle:checked + #menu {
            display: block;
        }

        /* Menú estilos */
        a,
        span {
            position: relative;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        a.arrow,
        span.arrow {
            display: flex;
            align-items: center;
            font-weight: 600;
            line-height: 1.5;
        }

        body {
            background-color: #03bfae; /* Color de fondo de toda la página */
        }

        .card {
            background-color: white; /* Color de fondo blanco para las tarjetas */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 400px; /* Ancho fijo de la tarjeta */
            height: 450px; /* Altura fija de la tarjeta */
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Evita que haya contenido adicional */
        }

        .card img {
            height: 100%; /* La imagen ocupa toda la altura de la tarjeta */
            width: 100%; /* Asegura que la imagen ocupe el 100% del ancho */
            object-fit: cover; /* Asegura que la imagen mantenga su proporción */
            flex-shrink: 0; /* Evita que la imagen se reduzca */
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body class="antialiased font-sans text-gray-900">

    <header class="absolute top-0 left-0 w-full z-50 px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 bg #5fc98b">
        <div class="flex flex-wrap items-center justify-between py-6">
            <div class="w-1/2 md:w-auto">
                <a href="/resources/views/inicio.blade.php">
                    <img src="{{ asset('/img/logo.png') }}" alt="Healthy Smiles" class="h-16 md:h-20 max-w-full" />
                </a>
            </div>

            <label for="menu-toggle" class="pointer-cursor md:hidden block">
                <svg class="fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                    <title>menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                </svg>
            </label>

            <input class="hidden" type="checkbox" id="menu-toggle">

            <div class="hidden md:block w-full md:w-auto" id="menu">
                <nav class="w-full md:bg-transparent rounded shadow-lg px-6 py-4 mt-4 text-center md:p-0 md:mt-0 md:shadow-none">
                    <ul class="md:flex items-center">
                        <li><a class="py-2 inline-block md:text-black md:hidden lg:block font-semibold" href="/resources/views/inicio.blade.php">Inicio</a></li>
                        <li class="md:ml-4"><a class="py-2 inline-block md:text-black md:px-2 font-semibold" href="/resources/views/cita.blade.php">Citas</a></li>
                        <li class="md:ml-4"><a class="py-2 inline-block md:text-black md:px-2 font-semibold" href="/resources/views/trabajosD.blade.php">Trabajos Dentales</a></li>
                        <li class="md:ml-4 md:hidden lg:block"><a class="py-2 inline-block md:text-black md:px-2 font-semibold" href="/resources/views/ubicacion.blade.php">Ubicación</a></li>
                        <li class="md:ml-4"><a class="py-2 inline-block md:text-black md:px-2 font-bold" href="/resources/views/nosotros.blade.php">Nosotros</a></li>
                        <li class="md:ml-6 mt-3 md:mt-0">
                            @if(Auth::check())
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="button" onclick="confirmLogout()" class="inline-block font-bold px-4 py-2 text-black md:bg-transparent md:text-black">
                                    {{ Auth::user()->name }}
                                </button>
                            </form>
                            @else
                            <a class="inline-block font-bold px-4 py-2 text-black md:bg-transparent md:text-black border border-black rounded" href="/resources/views/auth/login.blade.php">Iniciar sesión</a>
                            @endif
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="w-full mt-24">
        <div class="container mx-auto p-6 rounded-lg shadow-md">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="card rounded-lg">
                    <img src="{{asset('/img/ortopedia.jpeg')}}" alt="Ortopedia">
                </div>

                <div class="card rounded-lg">
                    <img src="{{asset('/img/implantes.jpeg')}}" alt="Implantes Dentales">
                </div>

                <div class="card rounded-lg">
                    <img src="{{asset('/img/ortodoncia.jpeg')}}" alt="Ortodoncia">
                </div>

                <div class="card rounded-lg">
                    <img src="{{asset('/img/adontologia.jpeg')}}" alt="Odontología Infantil">
                </div>

                <div class="card rounded-lg">
                    <img src="{{asset('/img/cirugia de cordales.jpg')}}" alt="Cirugía de Cordales">
                </div>

                <div class="card rounded-lg">
                    <img src="{{asset('/img/rellenos.jpg')}}" alt="Rellenos">
                </div>

                <div class="card rounded-lg">
                    <img src="{{asset('/img/blanqueamiento dental.jpg')}}" alt="Blanqueamiento Dental">
                </div>

                <div class="card rounded-lg">
                    <img src="{{asset('/img/odontologia prenatal.jpg')}}" alt="Odontología Prenatal">
                </div>

                <div class="card rounded-lg">
                    <img src="{{asset('/img/recontrucion.jpg')}}" alt="Reconstrucción de Borde Encisal">
                </div>
            </div>
        </div>
    </main>
    <footer class="relative bg-gray-900 text-white px-4 py-8">
            <div class="flex flex-col items-center">
                <div class="w-full max-w-xs text-center">
                    <h3 class="font-bold text-xl">Healthy Smiles</h3>
                    <p class="text-gray-400">Dra. Nadia Gomez</p>
                    <p class="text-sm text-gray-400 mt-4">© 2024 DERA. <br class="hidden lg:block">Todos Los Derechos Reservados.</p>
                </div>
            </div>
        </footer>
</body>
</html>