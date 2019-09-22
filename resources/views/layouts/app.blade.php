<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="section">
    <div id="app">
        <nav class="bg-grey-light">
        
            <div class="w-full flex justify-between items-center py-2 px-4">
                    
                <a class="text-black no-underline hover:text-red mr-2" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <!-- Right Side Of Navbar -->
                <div class="flex items-center ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        
                            <a class="text-black no-underline hover:text-red mr-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                        
                        @if (Route::has('register'))
                            
                                <a class="text-black no-underline hover:text-red mr-2" href="{{ route('register') }}">{{ __('Register') }}</a>
                            
                        @endif
                    @else
                    
                        <div  
                            class="flex items-center text-default no-underline text-sm focus:outline-none">
                            <img src="https://gravatar.com/avatar/{{md5(Auth::user()->email)}}?s=60" alt="{{Auth::user()->name}}'s avatar" class="rounded-full mr-3" width="35">  <span class="caret"></span>
                        </div>
                    
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="hover:text-red">Logout</button>
                    </form>
                    @endguest
                </div>
                    
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
