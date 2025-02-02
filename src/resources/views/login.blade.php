<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
<!--    <link rel="stylesheet" href="{{ asset('vendor/laravel-sso-login/css/login.css') }}">-->

    <style>
        .main-container {
            overflow: hidden;
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            /*centers items on the line (the x-axis by default)*/
            align-items: center;
            /*centers items on the cross-axis (y by default)*/
        }
        .form-container {
            width: 350px;
            height: fit-content;
            background-color: #fff;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            border-radius: 10px;
            box-sizing: border-box;
            padding: 20px 30px;
        }
        .title {
            text-align: center;
            font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande", "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
            margin: 10px 0 30px 0;
            font-size: 28px;
            font-weight: 800;
        }
        .form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-bottom: 15px;
        }
        .form .input {
            border-radius: 20px;
            border: 1px solid #c0c0c0;
            outline: 0 !important;
            box-sizing: border-box;
            padding: 12px 15px;
        }
        .form .sign-up-label {
            margin: 0;
            font-size: 10px;
            color: #747474;
            font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande", "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
        }
        .form .sign-up-label .sign-up-link {
            margin-left: 1px;
            font-size: 11px;
            text-decoration: underline;
            text-decoration-color: teal;
            color: teal;
            cursor: pointer;
            font-weight: 800;
            font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande", "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
        }
        .form .form-btn {
            padding: 10px 15px;
            font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande", "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
            border-radius: 20px;
            border: 0 !important;
            outline: 0 !important;
            background: teal;
            color: white;
            cursor: pointer;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }
        .form .form-btn:active {
            box-shadow: none;
        }
        .page-link {
            text-decoration: underline;
            margin: 0;
            text-align: end;
            color: #747474;
            text-decoration-color: #747474;
        }
        .page-link-label {
            cursor: pointer;
            font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande", "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
            font-size: 9px;
            font-weight: 700;
        }
        .page-link-label:hover {
            color: #000;
        }
        .buttons-container {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            margin-top: 20px;
            gap: 15px;
        }
        .apple-login-button, .google-login-button {
            border-radius: 20px;
            box-sizing: border-box;
            padding: 10px 15px;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande", "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
            font-size: 11px;
            gap: 5px;
        }
        .apple-login-button {
            background-color: #000;
            color: #fff;
            border: 2px solid #000;
        }
        .google-login-button {
            border: 2px solid #747474;
        }
        .apple-icon, .google-icon {
            font-size: 18px;
            margin-bottom: 1px;
        }

    </style>
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

        @if ($errors->any())
        <div class="alert alert-danger d-block mx-auto text-center">
            @foreach ($errors->all() as $error)
            {{ $error }}
            @endforeach
        </div>
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
