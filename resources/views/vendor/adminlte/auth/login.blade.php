<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GEST_DOC |</title>
    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('fonts/material-icon/css/material-design-iconic-font.min.css')}}">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    @section('adminlte_css_pre')
        <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    @stop

    @php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
    @php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
    @php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

    @if (config('adminlte.use_route_url', false))
        @php( $login_url = $login_url ? route($login_url) : '' )
        @php( $register_url = $register_url ? route($register_url) : '' )
        @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
    @else
        @php( $login_url = $login_url ? url($login_url) : '' )
        @php( $register_url = $register_url ? url($register_url) : '' )
        @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
    @endif

    <div class="main">

        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Iniciar Sesión</h2>
                        <form action="{{ $login_url }}" method="POST" class="register-form" id="login-form">
                            @csrf
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus/>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ __('adminlte::adminlte.password') }}"/>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- Remember Me --}}
                            <div class="form-group">
                                <input type="checkbox" name="remember" id="remember-me" 
                                    class="agree-term" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember-me" class="label-agree-term">
                                    <span><span></span></span>{{ __('adminlte::adminlte.remember_me') }}
                                </label>
                            </div>
                            {{-- Login Button --}}
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" 
                                    class="form-submit" 
                                    value="{{ __('adminlte::adminlte.sign_in') }}">
                            </div>
                            
                        </form>
                        {{-- Password reset link --}}
                        @if($password_reset_url)
                            <p class="my-0">
                                <a href="{{ $password_reset_url }}">
                                    {{ __('adminlte::adminlte.i_forgot_my_password') }}
                                </a>
                            </p>
                        @endif

                        <div class="social-login">
                            <img src="{{ asset('logo.png')}}" alt="Logo de Gestión Documental Maestri On Track S.A.S" style="max-width: 100px; height: auto; margin-right: 10px;">
                            <span class="social-label">&copy; Gestión Documental</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</body>
</html>