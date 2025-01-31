<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('vendor/laravel-sso-login/css/login.css') }}">
</head>
<body>
<div class="main-container">
    <div class="form-container">
        <p class="title">Welcome back</p>

        <form class="form" id="tina4-login" method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" class="input" placeholder="Email" value="{{ old('email', session('loginEmail')) }}" required>
            <input type="password" name="password" class="input" placeholder="Password" required>

            <p class="page-link">
                <span class="page-link-label">Forgot Password?</span>
            </p>

            <button class="form-btn" type="submit">Log in</button>
        </form>

        @if (session('message'))
        <span class="alert alert-danger d-block mx-auto text-center" role="alert">
                    {{ session('message') }}
                </span>
        @endif

        <div class="buttons-container">
            @if (!empty($integrations['google']))
            <button class="google-login-button" onclick="location.assign('{{ $integrations['google']['link'] }}')">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" x="0px" y="0px" class="google-icon" viewBox="0 0 48 48" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12
                                c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24
                                c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                    <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657
                                C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                    <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36
                                c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                    <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571
                                c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                </svg>
                <span>{{ $integrations['google']['text'] }}</span>
            </button>
            @endif

            @if (!empty($integrations['amazon']))
            <div href id="LoginWithAmazon" onclick="location.assign('{{ $integrations['amazon']['link'] }}')">
                <img border="0" alt="Login with Amazon"
                     src="https://images-na.ssl-images-amazon.com/images/G/01/lwa/btnLWA_gold_156x32.png"
                     width="156" height="32" />
            </div>
            @endif
        </div>
    </div>
</div>
</body>
</html>
