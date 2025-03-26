<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Home Page</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full">
    <div class="flex h-screen bg-gray-100">

        {{--NAVIGATION SIDEBAR--}}
        <div id="sidebar" class="hidden md:flex flex-col w-64 bg-[#2d3745] transition-all duration-300">
            {{--Logo, Title & Toggle button--}}
            <div class="flex items-center h-16 px-4 justify-between">
                <span id="sidebar-title" class="text-white font-bold uppercase ml-2">SPARK</span>
                <button id="toggle-btn" class="text-white focus:outline-none ml-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            {{--Navigation Items with icons--}}
            <div class="flex flex-col flex-1 overflow-y-auto">
                <nav class="flex-1 px-2 py-4">
                    <x-nav-link href="/" :active="request()->is('/')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2 sidebar-icon shrink-0">--}}
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span class="sidebar-text">Inicio</span>
                    </x-nav-link>

                    <x-nav-link href="/planes-estrategicos" :active="request()->is('planes-estrategicos')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2 sidebar-icon shrink-0">--}}
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        <span class="sidebar-text">Planes Estratégicos</span>
                    </x-nav-link>

                    <x-nav-link href="/reportes" :active="request()->is('reportes')">
                        <svg class="h-6 w-6 mr-2 sidebar-icon shrink-0"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round" >
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />  <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                        </svg>
                        <span class="sidebar-text">Reportes</span>
                    </x-nav-link>

                    <a href="https://oiip.uprm.edu/" target="_blank" class="flex items-center px-3 py-2 mt-2 text-gray-100 hover:bg-gray-700 transition duration-150 ease-in-out rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 sidebar-icon shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                        </svg>
                        <span class="sidebar-text">Equipo</span>
                    </a>

                    <x-nav-link href="/configuracion" :active="request()->is('configuracion')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2 sidebar-icon shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span class="sidebar-text">Configuración</span>
                    </x-nav-link>
                </nav>
            </div>
        </div>

        {{--Script to toggle Navigation Menu--}}
        <script>
            document.getElementById("toggle-btn").addEventListener("click", function () {
                let sidebar = document.getElementById("sidebar");
                let title = document.getElementById("sidebar-title");
                let textElements = document.querySelectorAll(".sidebar-text");

                sidebar.classList.toggle("w-64");
                sidebar.classList.toggle("w-16");

                title.classList.toggle("hidden");
                textElements.forEach(text => text.classList.toggle("hidden"));
            });
        </script>

        <style>
            .w-16 {
                width: 4rem !important;
            }
            .sidebar-text {
                transition: opacity 0.3s ease;
            }
        </style>


        {{--MAIN CONTENT--}}
        <main class="flex flex-col flex-1 overflow-y-auto">
            {{--HEADER--}}
            <header class="flex items-center justify-between h-16 bg-[#1F2937] border-b border-gray-200">
                {{--Add SPARK name & logo here when side panel is closed--}}

                {{--Direct Button to SAML--}}
                @guest
                    <a href="{{ route('saml.login') }}"
                       class="text-white border border-white px-4 py-2 rounded hover:bg-gray-700 focus:outline-none ml-auto mr-2">
                        Iniciar Sesión
                    </a>
                @endguest

                @auth
                    <form action="{{ route('logout') }}" method="POST" class="ml-auto mr-2">
                        @csrf
                        <button type="submit" class="text-white border border-white px-4 py-2 rounded hover:bg-gray-700 focus:outline-none">
                            Cerrar Sesión
                        </button>
                    </form>
                @endauth


            </header>
            {{--PAGE CONTENT--}}

            <header class="bg-white shadow-sm">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 sm:flex sm:justify-between">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $heading }}</h1>
                </div>
            </header>

            {{$slot}}

        </main>

    </div>

    {{--FOOTER--}}
    <div class="flex flex-col flex-1 overflow-y-auto">
        <div class="flex items-center justify-center h-16 bg-[#1F2937]">
            <p class="text-white text-center">Estamos localizados en: Edificio Celis Oficina 121 Tel: 787-265-3877, 787-832-4040 Exts. 2004, 3877, 5465, 2680 Fax: 787-831-3022</p>
        </div>
    </div>
</body>

</html>

