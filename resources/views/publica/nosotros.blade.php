<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-Qv8BP+3n6w3oY5u0mOmAb5MVd2zfrbxm4+Y7j/aFnn2JhKQ/dxkBbF6ntR2o10gCZi36BpZfT+ULU4mHZvLcTQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/js/app.js')
    @vite('resources/css/taiwind.css')

    <title>Healthy Smile Dra. Nadia Gomez</title>

    <style>
        body {
            background-color: #03bfae;
            /* Color de fondo de toda la página */
        }
    </style>
</head>

<body class="antialiase font-sans text-gray-900">

    <main class="w-full">
        <header class="absolute top-0 left-0 w-full z-50 px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64">
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
                    <nav class="w-full bg-transparent text-white rounded shadow-lg px-6 py-4 mt-4 text-center md:bg-teal-500 md:p-0 md:mt-0 md:shadow-none">
                        <ul class="md:flex items-center">
                            <li><a class="py-2 inline-block text-xl md:text-white md:hidden lg:block font-bold" href="/resources/views/inicio.blade.php">Inicio</a></li>
                            <li class="md:ml-4">
                                @guest
                                <a class="py-2 inline-block text-xl md:text-white md:px-2 font-bold" href="{{ route('login') }}">Citas</a>
                                @else
                                <a class="py-2 inline-block text-xl md:text-white md:px-2 font-bold" href="/resources/views/cita.blade.php">Citas</a>
                                @endguest
                            </li>
                            <li class="md:ml-4"><a class="py-2 inline-block text-xl md:text-white md:px-2 font-bold" href="/resources/views/trabajosD.blade.php">Servicios Dentales</a></li>
                            <li class="md:ml-4 md:hidden lg:block"><a class="py-2 inline-block text-xl md:text-white md:px-2 font-bold" href="/resources/views/ubicacion.blade.php">Ubicación</a></li>
                            <li class="md:ml-4"><a class="py-2 inline-block md:text-white text-xl md:px-2 font-bold" href="/resources/views/nosotros.blade.php">Nosotros</a></li>
                            <li class="md:ml-6 mt-3 md:mt-0">
                                @if(Auth::check())
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="button" onclick="confirmLogout()" class="inline-block font-bold px-4 text-xl py-2 text-black md:bg-transparent md:text-white">
                                        {{ Auth::user()->name }}
                                    </button>
                                </form>
                                @else
                                <a class="inline-block font-bold px-4 py-2 text-black md:bg-transparent md:text-white text-xl border border-white rounded" href="/resources/views/auth/login.blade.php">Iniciar sesión</a>
                                @endif
                            </li>
                        </ul>
                    </nav>
                </div>


                <!-- Menú móvil -->
                <div class="items-center justify-center md:hidden w-full bg-blue-600 shadow-lg rounded-lg" id="mobile-menu">
                    <nav class="py-2">
                        <ul class="space-y-2">
                            <li class="text-center">
                                <a class="block py-2 text-white bg-blue-500 rounded transition duration-200 hover:bg-blue-400" href="/resources/views/inicio.blade.php">Inicio</a>
                            </li>
                            <li class="text-center">
                                @guest
                                <a class="block py-2 text-white bg-blue-500 rounded transition duration-200 hover:bg-blue-400" href="{{ route('login') }}">Citas</a>
                                @else
                                <a class="block py-2 text-white bg-blue-500 rounded transition duration-200 hover:bg-blue-400" href="/resources/views/cita.blade.php">Citas</a>
                                @endguest
                            </li>
                            <li class="text-center">
                                <a class="block py-2 text-white bg-blue-500 rounded transition duration-200 hover:bg-blue-400" href="/resources/views/trabajosD.blade.php">Trabajos Dentales</a>
                            </li>
                            <li class="text-center">
                                <a class="block py-2 text-white bg-blue-500 rounded transition duration-200 hover:bg-blue-400" href="/resources/views/ubicacion.blade.php">Ubicación</a>
                            </li>
                            <li class="text-center">
                                <a class="block py-2 text-white bg-blue-500 rounded transition duration-200 hover:bg-blue-400" href="/resources/views/nosotros.blade.php">Nosotros</a>
                            </li>
                            <li class="text-center">
                                @if(Auth::check())
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="block py-2 text-white bg-blue-500 rounded transition duration-200 hover:bg-blue-400">
                                    @csrf
                                    <button type="button" onclick="confirmLogout()">
                                        {{ Auth::user()->name }}
                                    </button>
                                </form>
                                @else
                                <a class="block py-2 text-white bg-blue-500 rounded transition duration-200 hover:bg-blue-500" href="/resources/views/auth/login.blade.php">Iniciar sesión</a>
                                @endif
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <div class="bg-esmerald" >
            <section class="relative bg-esmerald px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 overflow-hidden py-48 flex flex-col items-center min-h-screen">


                <div class="text-center mb-12 relative z-10">
                    <h1 class="text-4xl font-bold text-white">¿Quiénes somos?</h1>
                    <p class="mt-4 text-lg font-bold text-white">Somos el lugar perfecto para cuidar y crear las mejores sonrisas y sobre todo llevar salud y alegría a toda la familia.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mx-auto max-w-5xl mb-12 relative z-10">
                    <div class="bg-white shadow-md rounded-lg p-4 transition-transform duration-200 hover:scale-105">
                        <h2 class="text-lg font-semibold">Misión</h2>
                        <p class="mt-2 text-sm">Cuidar la Sonrisa de los pacientes con una odontología de vanguardia y amigable.</p>
                    </div>
                    <div class="bg-white shadow-md rounded-lg p-4 transition-transform duration-200 hover:scale-105">
                        <h2 class="text-lg font-semibold">Visión</h2>
                        <p class="mt-2 text-sm">Ser la Clínica Odontológica de primer escoge para quienes necesitan atención personalizada.</p>
                    </div>
                    <div class="bg-white shadow-md rounded-lg p-4 transition-transform duration-200 hover:scale-105">
                        <h2 class="text-lg font-semibold">Valores</h2>
                        <p class="mt-2 text-sm">Transparencia, Honestidad, Empatía, Respeto, Amor.</p>
                    </div>
                </div>

                <div class="text-center mb-12 relative z-10">
                    <h2 class="text-2xl font-semibold text-white">Síguenos en nuestras redes sociales</h2>
                </div>

                <div class="flex justify-center gap-4 mb-12 relative z-10">
                    <a href="https://www.facebook.com/Dra.NadiaGomez?mibextid=ZbWKwL" target="_blank" rel="noopener noreferrer" class="flex items-center">
                        <img src="{{ asset('img/face.ico') }}" alt="Facebook" class="w-8 h-8 filter brightness-0 invert">
                    </a>
                    <a href="https://www.tiktok.com/@dranadiagomez" target="_blank" rel="noopener noreferrer" class="flex items-center">
                        <img src="{{ asset('img/tikis.ico') }}" alt="TikTok" class="w-8 h-8 filter brightness-0 invert">
                    </a>
                    <a href="https://www.instagram.com/dranadiagomezsv?igsh=bXVmZ3M5dHRoZ2xt" target="_blank" rel="noopener noreferrer" class="flex items-center">
                        <img src="{{ asset('img/insta.png') }}" alt="Instagram" class="w-8 h-8 filter brightness-0 invert">
                    </a>
                    <a href="https://wa.me/78538743" target="_blank" rel="noopener noreferrer" class="flex items-center">
                        <img src="{{ asset('img/wha.ico') }}" alt="WhatsApp" class="w-8 h-8 filter brightness-0 invert">
                    </a>
                </div>

            </section>
        </div>



        <footer class="relative bg-gray-900 text-white px-2 py-3">
            <div class="flex flex-col items-center">
                <div class="w-full max-w-sm text-center">
                    <h3 class="font-bold text-xl">Healthy Smiles</h3>
                    <p class="text-gray-400">Dra. Nadia Gomez</p>
                    <p class="text-sm text-gray-400 mt-4">© 2024 DERA. <br class="hidden lg:block">Todos Los Derechos Reservados.</p>
                </div>
            </div>
        </footer>
    </main>

    <script>
        document.getElementById('menu-toggle').addEventListener('change', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden', !this.checked);
        });

        function confirmLogout() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres cerrar sesión?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar sesión!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
