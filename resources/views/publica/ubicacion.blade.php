<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ubicacion</title>
    <!-- Stylesheet -->
    <style>
         body {
            background-color: #03bfae;
            /* Color de fondo de toda la página */
        }

        .text-l:hover {
            color: #6cca9b !important;
        }

    </style>

    @vite('resources/css/tailwind.css')
    @vite('resources/js/app.js')
</head>

<body class="antialiased font-sans text-gray-900">

    <main class="w-full">
        <header class="absolute top-0 left-0 w-full z-50 px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64">
            <div class="flex flex-wrap items-center justify-between py-6">
                <div class="w-1/2 md:w-auto">
                    <a href="/resources/views/inicio.blade.php">
                        <img src="{{ asset('/img/logo.png') }}" alt="Healthy Smiles" class="h-16 md:h-20 max-w-full" />
                    </a>
                </div>

                <label for="menu-toggle" class="pointer-cursor md:hidden block">
                    <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
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
                    <nav class="py-2"> <!-- Altura reducida -->
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
                                <a class="block py-2 text-white bg-blue-500 rounded transition duration-200 hover:bg-blue-400" href="/resources/views/auth/login.blade.php">Iniciar sesión</a>
                                @endif
                            </li>
                        </ul>
                    </nav>
                </div>


        </header>


        <div>
            <section class="cover px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 overflow-hidden py-48 flex items-center min-h-screen">
                <div class="container px-6 py-12 mx-auto">
                    <div class="grid grid-cols-1 gap-6 mt-10 lg:grid-cols-3">
                        <div class="grid grid-cols-1 gap-12 sm:grid-cols-2 lg:grid-cols-1">
                            <div>
                                <span class="inline-block p-3 text-blue-500 rounded-full bg-white ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                </span>
                                <h2 class="mt-4 text-base font-bold text-white dark:text-white">Email</h2>
                                <p class="text-white font-bold">Para cualquier consulta o pregunta, no dudes en ponerte en contacto con nosotros:</p>
                                <a class="text-yellow font-bold" href="mailto:healthysmilessv@gmail.com">Enviar correo</a>
                            </div>

                            <div>
                                <span class="inline-block p-3 text-white  rounded-full bg-white">
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg">
                                        <title>WhatsApp icon</title>
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                    </svg>
                                </span>
                                <h2 class="mt-4 text-base font-bold text-white dark:text-white">WhatsApp</h2>
                                <a class="text-yellow font-bold" href="https://wa.me/50378538743">Escribe a nuestro WhatsApp</a>
                            </div>

                            <div>
                                <span class="inline-block p-3 text-white  rounded-full bg-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                </span>
                                <h2 class="mt-4 text-base font-bold text-white dark:text-white">Teléfono</h2>
                                <p class="mt-2 text-sm text-white font-bold dark:text-gray-400">Atendemos de Lunes a Sábado de 9am a 5pm.</p>
                                <p class="mt-2 text-sm text-yellow font-bold  dark:text-blue-400">+503 7853 8743</p>
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-lg lg:col-span-2 h-96 lg:h-auto">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3876.547769744995!2d-89.23046332544237!3d13.685240398832127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f63318c858255c7%3A0x543fb6cd1014815b!2sDra.%20Nadia%20Gomez%20Healthy%20Smiles!5e0!3m2!1ses!2ssv!4v1727408568798!5m2!1ses!2ssv" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
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
            if (this.checked) {
                mobileMenu.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
    <script>
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
                    // Si el usuario confirma, envía el formulario
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
