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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @php( $password_email_url = View::getSection('password_email_url') ?? config('adminlte.password_email_url', 'password/email') )

    @if (config('adminlte.use_route_url', false))
        @php( $password_email_url = $password_email_url ? route($password_email_url) : '' )
    @else
        @php( $password_email_url = $password_email_url ? url($password_email_url) : '' )
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
                        <form action="{{ $password_email_url }}" method="POST" class="register-form" id="login-form">
                            @csrf
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus/>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>
                    
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" 
                                    class="form-submit" 
                                    value="Enviar">
                            </div>
                            @if(session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
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