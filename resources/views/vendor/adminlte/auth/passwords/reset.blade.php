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
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>
<body>

    @php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

    @if (config('adminlte.use_route_url', false))
        @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
    @else
        @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
    @endif

    <div class="main">

        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="{{ asset('images/signin-image.jpg') }}" alt="sing up image"></figure>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Restablecer la contraseña</h2>
                        <form action="{{ $password_reset_url }}" method="POST" class="register-form" id="login-form">
                            @csrf
                            {{-- Token field --}}
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus/>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ __('adminlte::adminlte.password') }}"/>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="{{ trans('adminlte::adminlte.retype_password') }}"/>
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- Login Button --}}
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" 
                                    class="form-submit" 
                                    value=" {{ __('adminlte::adminlte.reset_password') }}">
                            </div>
                            
                        </form>

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