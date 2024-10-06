<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-Qv8BP+3n6w3oY5u0mOmAb5MVd2zfrbxm4+Y7j/aFnn2JhKQ/dxkBbF6ntR2o10gCZi36BpZfT+ULU4mHZvLcTQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')

    <title>Healthy Smile Dra. Nadia Gomez</title>
</head>
<body class="antialiased font-sans text-gray-900 bg-[#03bfae]">

<header class="absolute top-0 left-0 w-full z-50 px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 bg-[#03bfae] shadow-none"> <!-- Cambié shadow-md a shadow-none -->
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
            <nav class="w-full md:bg-[#03bfae] rounded shadow-none px-6 py-4 mt-4 text-center md:p-0 md:mt-0"> <!-- Cambié shadow-lg a shadow-none -->
                <ul class="md:flex items-center">
                    <li><a class="py-2 inline-block md:text-white md:hidden lg:block font-semibold" href="/resources/views/inicio.blade.php">Inicio</a></li>
                    <li class="md:ml-4"><a class="py-2 inline-block md:text-white md:px-2 font-semibold" href="/resources/views/cita.blade.php">Citas</a></li>
                    <li class="md:ml-4"><a class="py-2 inline-block md:text-white md:px-2 font-semibold" href="/resources/views/trabajosD.blade.php">Trabajos Dentales</a></li>
                    <li class="md:ml-4 md:hidden lg:block"><a class="py-2 inline-block md:text-white md:px-2 font-semibold" href="/resources/views/ubicacion.blade.php">Ubicación</a></li>
                    <li class="md:ml-4"><a class="py-2 inline-block md:text-white md:px-2 font-bold" href="/resources/views/nosotros.blade.php">Nosotros</a></li>
                    <li class="md:ml-6 mt-3 md:mt-0">
                        @if(Auth::check())
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="button" onclick="confirmLogout()" class="inline-block font-bold px-4 py-2 text-white md:bg-transparent md:text-white">
                                    {{ Auth::user()->name }}
                                </button>
                            </form>
                        @else
                            <a class="inline-block font-bold px-4 py-2 text-white md:bg-transparent md:text-white border border-white rounded" href="/resources/views/auth/login.blade.php">Iniciar sesión</a>
                        @endif
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>



<div class="fon">
    <div class="mb-12">
        <img src="{{ asset('img/fondo de nosotros.jpg') }}" alt="fondo" class="w-full object-cover mb-12">
    </div>
</div>

<div class="text-center mb-12">
    <h1 class="text-3xl font-bold">¿Quiénes somos?</h1>
    <p class="mt-4 text-lg">Somos el lugar perfecto para cuidar y crear las mejores sonrisas y sobre todo llevar salud y alegría a toda la familia.</p>
</div>

<div class="flex flex-wrap justify-center gap-6 mx-auto max-w-5xl mb-12">
    <div class="bg-white shadow-md rounded-lg p-4 flex-1 min-w-[200px] max-w-[250px] transition-transform duration-200 hover:scale-105">
        <h2 class="text-lg font-semibold">Misión</h2>
        <p class="mt-2 text-sm">Cuidar la Sonrisa de los pacientes con una odontología de vanguardia y amigable, creando una atmósfera de confianza recíproca en la que los pacientes resuelvan sus expectativas de salud bucal, refiriendo pacientes por la experiencia agradable vivida y los profesionales comprometidos en la excelencia para que nuestros usuarios, NO DEJEN DE SONREIR.</p>
    </div>
    <div class="bg-white shadow-md rounded-lg p-4 flex-1 min-w-[200px] max-w-[250px] transition-transform duration-200 hover:scale-105">
        <h2 class="text-lg font-semibold">Visión</h2>
        <p class="mt-2 text-sm">Ser la Clínica Odontológica de primer escoge para quienes necesitan atención personalizada con calidad y calidez, con tratamientos realizados por profesionales especializados y en capacitación continua, que además de brindar atención odontológica, practican la empatía con cada paciente y los hacen sentir en un ambiente acogedor.</p>
    </div>
    <div class="bg-white shadow-md rounded-lg p-4 flex-1 min-w-[200px] max-w-[250px] transition-transform duration-200 hover:scale-105">
        <h2 class="text-lg font-semibold">Valores</h2>
        <p class="mt-2 text-sm">Transparencia.<br>Honestidad.<br>Empatía.<br>Respeto.<br>Amor.<br>Confianza.<br>Compromiso.<br>Profesionalismo.<br>Calidad.</p>
    </div>
</div>


<div class="text-center mb-12">
    <h2 class="text-2xl font-semibold">Síguenos en nuestras redes sociales</h2>
</div>

<div class="flex justify-center gap-4 mb-12">
    <a href="https://www.facebook.com/Dra.NadiaGomez?mibextid=ZbWKwL" target="_blank" rel="noopener noreferrer" class="flex items-center">
        <img src="{{ asset('img/face.ico') }}" alt="Facebook" class="w-4 h-4"> <!-- Reduced size -->
    </a>
    <a href="https://www.tiktok.com/@dranadiagomez" target="_blank" rel="noopener noreferrer" class="flex items-center">
        <img src="{{ asset('img/tikis.ico') }}" alt="TikTok" class="w-4 h-4"> <!-- Reduced size -->
    </a>
    <a href="https://www.instagram.com/dranadiagomezsv?igsh=bXVmZ3M5dHRoZ2xt" target="_blank" rel="noopener noreferrer" class="flex items-center">
        <img src="{{ asset('img/insta.png') }}" alt="Instagram" class="w-4 h-4"> <!-- Reduced size -->
    </a>
    <a href="https://wa.me/78538743" target="_blank" rel="noopener noreferrer" class="flex items-center">
        <img src="{{ asset('img/wha.ico') }}" alt="WhatsApp" class="w-4 h-4"> <!-- Reduced size -->
    </a>
</div>
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

    .fon {
        margin-top: 150px;
    }
    .flex.justify-center.gap-4.mb-12 {
    justify-content: center; /* Center the icons horizontally */
}

.flex.items-center img {
    width: 90px; /* Set a fixed width for the icons */
    height: 50px; /* Set a fixed height for the icons */
    margin: 0 40px; /* Add some margin between icons */
    
}

</style>
