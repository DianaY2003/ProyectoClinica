<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="stylesheet" href="build/app.css">

    <title>Healthy Smiles</title>
    @vite('resources/css/tailwind.css')
    <style>
        body {
            background-color: #03bfae;
            /* Color de fondo de toda la página */
        }

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

<body class="antialiased font-sans text-gray-900">

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
                            <li><a class="py-2 inline-block text-xl md:text-white md:hidden lg:block font-bold"
                                    href="/resources/views/inicio.blade.php">Inicio</a></li>
                            <li class="md:ml-4"><a class="py-2 text-xl inline-block md:text-white md:px-2 font-bold"
                                    href="/resources/views/cita.blade.php">Citas</a></li>
                            <li class="md:ml-4"><a class="py-2 text-xl inline-block md:text-white md:px-2 font-bold"
                                    href="/resources/views/trabajosD.blade.php">Trabajos Dentales</a></li>
                            <li class="md:ml-4 md:hidden lg:block"><a
                                    class="py-2 text-xl inline-block md:text-white md:px-2 font-bold"
                                    href="/resources/views/ubicacion.blade.php">Ubicacion</a></li>
                            <li class="md:ml-4"><a class="py-2 text-xl inline-block md:text-white md:px-2 font-bold"
                                    href="/resources/views/nosotros.blade.php">Nosotros</a></li>
                            <li class="md:ml-6 mt-3 md:mt-0">
                                @if(Auth::check())
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="button" onclick="confirmLogout()" class="inline-block text-xl font-bold px-4 py-2 text-black md:bg-transparent md:text-white">
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
            <section class="cover  px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 overflow-hidden py-48 flex
      items-center min-h-screen">

                <div class="mx-auto  text-center">
                    <form action="{{ route('publicas.store') }}" method="POST" class="mx-auto mt-30 lg:mt-50" id="citaForm" onsubmit="return mostrarAlerta(event)">
                        @csrf
                        <div class="grid grid-cols-1 gap-x-8 gap-y-8 sm:grid-cols-2">
                            <div>
                                <div class="mt-2.5">
                                    <label for="fecha" class="block text-lg font-bold leading-6 text-white text-left">Fecha</label>
                                    <input type="date" name="fecha" id="fecha" class="block w-full rounded-md border-0 px-5.5 py-4 text-black shadow-sm shadow-blue-400 ring-1 ring-inset ring-blue-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-400 lg:text-lg lg:leading-6" required>
                                </div>
                            </div>
                            <div>
                                <div class="mt-2.5">
                                    <label for="hora" class="block text-lg font-bold leading-6 text-white text-left">Hora</label>
                                    <input type="time" name="hora" id="hora" class="block w-full rounded-md border-0 px-3.5 py-4 text-gray-900 shadow-sm shadow-blue-500 ring-1 ring-inset ring-blue-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-400 lg:text-lg lg:leading-6" required>
                                </div>
                            </div>
                            <div>
                                <div class="mt-2.5">
                                    <label for="telefono" class="block text-lg font-bold leading-8 text-white text-left">Telefono</label>
                                    <input type="tel" name="telefono" id="telefono" maxlength="8" class="block w-full rounded-md border-0 px-3.5 py-3 text-gray-900 shadow-sm shadow-blue-500 ring-1 ring-inset ring-blue-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-400 lg:text-lg lg:leading-6" required>
                                </div>

                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <div class="mt-2.5">
                                <label for="user" class="block text-lg font-bold leading-8 text-white text-left">Nombre</label>
                                <input type="text" name="user" id="user" value="{{ auth()->user()->name }}" class="block w-full rounded-md border-0 px-3.5 py-3 text-gray-900 shadow-sm ring-1 ring-inset shadow-blue-500 ring-blue-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-400 lg:text-lg lg:leading-6" required>
                                <div class="mt-2.5 flex items-center">
                                    <label for="checkbox" class="block text-sm font-bold leading-6 text-white text-left">Agendar para alguien más</label>
                                    <input type="checkbox" id="checkbox" onclick="toggleInput()">
                                </div>
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <div class="mt-2.5">
                                <label for="motivo" class="block text-lg font-bold leading-6 text-white text-left">Motivo</label>
                                <textarea name="motivo" id="motivo" rows="4" class="block w-full rounded-md border-0 px-3.5 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 lg:text-lg lg:leading-6" required></textarea>
                            </div>
                        </div>
                        <div>
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        </div>
                        <div class="mt-2.5">
                            <input type="submit"
                                class="block w-full rounded-md bg-white px-3.5 py-2.5 text-center text-lg font-semibold text-black shadow-sm hover:bg-blue-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                                value="Enviar">
                        </div>
                        @if(session('success'))
                        <div class="mt-4 text-green-600">{{ session('success') }}</div>
                        @endif
                    </form>
                </div>

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
        function mostrarAlerta(event) {
            event.preventDefault(); // Evita el envío del formulario

            const nombre = document.getElementById('user').value;
            const fecha = document.getElementById('fecha').value;
            const hora = document.getElementById('hora').value;

            // Muestra la alerta de SweetAlert con una imagen
            Swal.fire({
                title: 'Cita confirmada',
                html: `
            <div style="text-align: center; font-family: Arial, sans-serif; border: 1px solid #ccc; border-radius: 10px; padding: 20px; width: 300px; margin: auto;">
                <img src="{{ asset('/img/logo.png') }}" alt="Imagen de éxito" style="width: 100px; height: auto; margin-bottom: 10px;"/>
                <p style="font-size: 18px;"><strong>Nombre:</strong> ${nombre}</p>
                <p style="font-size: 18px;"><strong>Fecha:</strong> ${fecha}</p>
                <p style="font-size: 18px;"><strong>Hora:</strong> ${hora}</p>
            </div>
        `,
                showCloseButton: true,
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si se confirma, envía el formulario
                    event.target.submit();
                }
            });
        }
    </script>

    <script>
        const fechasElegidas = [];

        // Establecer la fecha mínima en el campo de entrada
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInput = document.getElementById('fecha');
            const fechaActual = new Date();
            const fechaFormato = fechaActual.toISOString().split('T')[0]; // Formato YYYY-MM-DD
            fechaInput.setAttribute('min', fechaFormato);
        });

        document.getElementById('fecha').addEventListener('change', function() {
            validarFechaHora();
        });

        document.getElementById('hora').addEventListener('change', function() {
            validarFechaHora();
        });

        function validarFechaHora() {
            const fechaSeleccionada = document.getElementById('fecha').value;
            const horaSeleccionada = document.getElementById('hora').value;

            if (!fechaSeleccionada || !horaSeleccionada) return; // Si no hay selección, salir

            const fechaHoraElegida = new Date(`${fechaSeleccionada}T${horaSeleccionada}`);

            // Verificar si la hora está dentro del rango permitido
            const horaInicio = new Date(fechaHoraElegida);
            horaInicio.setHours(8, 0, 0); // 8:00 AM
            const horaFin = new Date(fechaHoraElegida);
            horaFin.setHours(17, 0, 0); // 5:00 PM

            if (fechaHoraElegida < horaInicio || fechaHoraElegida > horaFin) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La hora debe estar entre las 8:00 AM y las 5:00 PM.',
                    confirmButtonText: 'Aceptar'
                });
                document.getElementById('hora').value = ''; // Limpiar el campo de hora
                return;
            }

            // Verificar si la fecha y hora ya han sido elegidas
            const fechaHoraString = fechaHoraElegida.toISOString();
            if (fechasElegidas.includes(fechaHoraString)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La fecha y hora seleccionadas ya han sido elegidas.',
                    confirmButtonText: 'Aceptar'
                });
                document.getElementById('hora').value = ''; // Limpiar el campo de hora
                return;
            }

            // Agregar la fecha y hora elegidas a la lista
            fechasElegidas.push(fechaHoraString);
            console.log("Fecha y hora seleccionadas son válidas.");
        }
    </script>
    <script>
        document.getElementById('menu-toggle').addEventListener('change', function() {
            const menu = document.getElementById('menu');
            if (this.checked) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        });



        // Guarda el nombre original del usuario
        const originalUserName = "{{ auth()->user()->name }}";

        function toggleInput() {
            const checkbox = document.getElementById('checkbox');
            const userInput = document.getElementById('user');

            // Habilitar o deshabilitar el campo de entrada según el estado del checkbox
            userInput.disabled = !checkbox.checked;

            // Si se marca el checkbox, limpiar el campo
            if (checkbox.checked) {
                userInput.value = ''; // Limpiar el campo al marcar
            } else {
                // Si se desmarca, restaurar el valor original
                userInput.value = originalUserName; // Restaurar el nombre original
            }
        }
    </script>

    <script>
        // Llama a la función al cargar la página
        window.onload = setTimeLimits;

        // Función para establecer la fecha mínima
        function setMinDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Meses son 0-indexados
            const day = String(today.getDate()).padStart(2, '0');
            const minDate = `${year}-${month}-${day}`;
            document.getElementById('fecha').setAttribute('min', minDate);
        }

        // Llama a la función al cargar la página
        window.onload = setMinDate;
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
