
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="bg-gray-100 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-1/5 bg-white border-r p-6 flex flex-col justify-between">
        <div>
            <h1 class="text-xl font-bold mb-10 ml-16 ">Dashboard</h1>
            <div class="flex flex-col items-center mb-6">
                <div class="bg-gray-200 rounded-full p-4 mb-2">
                    <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <p class="font-bold">Satrio Wiseso</p>
            </div>
            <ul class="space-y-3">
                <li>
                    <a href="{{ url('/') }}"
                        class="hover:text-indigo-500 px-3 py-1 rounded {{ request()->is('/') ? 'bg-gray-100 text-indigo-500 font-semibold' : '' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('bringin') }}"
                        class="hover:text-indigo-500 px-3 py-1 rounded {{ request()->routeIs('bringin') ? 'bg-indigo-100 text-indigo-600 font-semibold' : '' }}">
                        Bring In/Out
                    </a>
                </li>
                <li>
                    <a href="{{ route('overview') }}"
                        class="hover:text-indigo-500 px-3 py-1 rounded {{ request()->routeIs('overview') ? 'bg-indigo-100 text-indigo-600 font-semibold' : '' }}">
                        Overview
                    </a>
                </li>
                <li>
                    <a href="{{ route('approval') }}"
                        class="hover:text-indigo-500 px-3 py-1 rounded {{ request()->routeIs('approval') ? 'bg-indigo-100 text-indigo-600 font-semibold' : '' }}">
                        Approval
                    </a>
                </li>
            </ul>
        </div>
        <div class="mt-10">
            <a href="#" class="text-xs text-black flex items-center"><span class="mr-2">&#8592;</span> Log Out</a>
        </div>
    </aside>

    <main class="flex-1 p-10">
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
