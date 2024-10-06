<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="stylesheet" href="build/app.css">

    <title>Healthy Smiles</title>
    @vite('resources/css/app.css')
    <style>
        #menu-toggle:checked+#menu {
            display: block;
        }

        #dropdown-toggle:checked+#dropdown {
            display: block;
        }

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

        a.arrow .arrow_icon,
        span.arrow .arrow_icon {
            position: relative;
            margin-left: 0.5em;
        }

        a.arrow .arrow_icon svg,
        span.arrow .arrow_icon svg {
            transition: transform 0.3s 0.02s ease;
            margin-right: 1em;
        }

        a.arrow .arrow_icon::before,
        span.arrow .arrow_icon::before {
            content: "";
            display: block;
            position: absolute;
            top: 50%;
            left: 0;
            width: 0;
            height: 2px;
            background: #38b2ac;
            transform: translateY(-50%);
            transition: width 0.3s ease;
        }

        a.arrow:hover .arrow_icon::before,
        span.arrow:hover .arrow_icon::before {
            width: 1em;
        }

        a.arrow:hover .arrow_icon svg,
        span.arrow:hover .arrow_icon svg {
            transform: translateX(0.75em);
        }

        /* .cover {
            border-bottom-right-radius: 128px;
        }*/

        .bg-blue-teal-gradient {
            background: rgb(49, 130, 206);
            background: linear-gradient(90deg, rgba(49, 130, 206, 1) 0%, rgba(56, 178, 172, 1) 100%);
        }

        /* @media (min-width: 1024px) {
      .cover {
        border-bottom-right-radius: 256px;
      }
    } */
    </style>
</head>

<body class="antialiased bg-white font-sans text-gray-900">

    <main class="w-full">

        <!-- start header -->
        <header class="absolute top-0 left-0 w-full z-50 px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64">

            <div class="flex flex-wrap items-center justify-between py-6">
                <div class="w-1/2 md:w-auto">
                    <a href="/resources/views/inicio.blade.php">
                        <img src="{{ asset('/img/logo.png') }}" alt="Healthy Smiles" class="h-16 md:h-20 max-w-full" />
                    </a>
                </div>


                <label for="menu-toggle" class="pointer-cursor md:hidden block"><svg class="fill-current text-white"
                        xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <title>menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                    </svg></label>

                <input class="hidden" type="checkbox" id="menu-toggle">

                <div class="hidden md:block w-full md:w-auto" id="menu">
                    <nav
                        class="w-full md:bg-transparent rounded shadow-lg px-6 py-4 mt-4 text-center md:p-0 md:mt-0 md:shadow-none">
                        <ul class="md:flex items-center">
                            <li><a class="py-2 inline-block md:text-white md:hidden lg:block font-semibold"
                                    href="/resources/views/inicio.blade.php">Inicio</a></li>
                            <li class="md:ml-4">
                                @guest
                                <a class="py-2 inline-block md:text-white md:px-2 font-semibold"
                                    href="{{ route('login') }}">Citas</a>
                                @else
                                <a class="py-2 inline-block md:text-white md:px-2 font-semibold"
                                    href="/resources/views/cita.blade.php">Citas</a>
                                @endguest
                            </li>
                            <li class="md:ml-4"><a class="py-2 inline-block md:text-white md:px-2 font-semibold"
                                    href="/resources/views/trabajosD.blade.php">Trabajos Dentales</a></li>
                            <li class="md:ml-4 md:hidden lg:block"><a
                                    class="py-2 inline-block md:text-white md:px-2 font-semibold"
                                    href="/resources/views/ubicacion.blade.php">Ubicacion</a></li>
                            <li class="md:ml-4"><a class="py-2 inline-block md:text-white md:px-2 font-bold"
                                    href="/resources/views/nosotros.blade.php">Nosotros</a></li>
                            <li class="md:ml-6 mt-3 md:mt-0">
                                @if(Auth::check())
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="button" onclick="confirmLogout()" class="inline-block font-bold px-4 py-2 text-black md:bg-transparent md:text-white">
                                        {{ Auth::user()->name }}
                                    </button>
                                </form>
                                @else
                                <a class="inline-block font-bold px-4 py-2 text-black md:bg-transparent md:text-white border border-white rounded" href="/resources/views/auth/login.blade.php">Iniciar sesión</a>
                                @endif
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            </div>
        </header>
        <!-- end header -->

        <!-- start hero -->
        <div class="bg-gray-100">
            <section class="cover bg-blue-teal-gradient relative bg-blue-600 px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 overflow-hidden py-48 flex
      items-center min-h-screen">
                <div class="h-screen absolute top-0 left-0 z-0">
                    <img src="{{ asset('/img/fondo2.png') }}" alt="" class="w-full h-full object-cover opacity-60">
                </div>

                <div class="lg:w-3 xl:w-2/4 relative z-10 h-100 lg:mt-16">
                    <div>
                        <h1 class="text-white text-4xl md:text-5xl xl:text-6xl font-bold leading-tight">NO DEJES DE SONREIR</h1>
                        <p class="text-blue-100 text-xl md:text-2xl leading-snug mt-4">Dra. Nadia Gomez</p>
                        @guest
                        <a href="{{ route('login') }}"
                            class="px-8 py-4 bg-teal-500 text-white rounded inline-block mt-8 font-semibold">Agenda tu Cita</a>
                        @else
                        <a href="/resources/views/cita.blade.php"
                            class="px-8 py-4 bg-teal-500 text-white rounded inline-block mt-8 font-semibold">Agenda tu Cita</a>
                        @endguest
                    </div>
                </div>
            </section>
        </div>
        <!-- end hero -->

        <!-- start footer -->
        <<footer class="relative bg-gray-900 text-white px-4 py-8">
            <div class="flex flex-col items-center">
                <div class="w-full max-w-xs text-center">
                    <h3 class="font-bold text-xl">Healthy Smiles</h3>
                    <p class="text-gray-400">Dra. Nadia Gomez</p>
                    <p class="text-sm text-gray-400 mt-4">© 2024 DERA. <br class="hidden lg:block">Todos Los Derechos Reservados.</p>
                </div>
            </div>
            </footer>
            <!-- end footer -->

    </main>
    <script>
        document.getElementById('menu-toggle').addEventListener('change', function() {
            const menu = document.getElementById('menu');
            if (this.checked) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
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
