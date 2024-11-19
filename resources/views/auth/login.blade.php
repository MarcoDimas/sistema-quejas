<style>
    /* Estilo general de la página */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #FFC3D0;
        margin: 0;
        padding: 0;
        height: 100vh; /* Hacer que el body ocupe toda la altura */
        overflow: hidden; /* Evitar que el contenido haga scroll */
    }

    /* Contenedor de pantalla dividida */
    .login-container {
        display: flex;
        height: 100vh; /* Hacer que el contenedor ocupe toda la altura de la ventana */
    }

    /* Panel izquierdo con fondo de marca de agua */
    .left-panel {
        width: 50%;
        background-size: contain;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #FFC3D0;
        overflow: hidden; /* Evitar desplazamiento en el panel izquierdo */
    }

    /* Formulario en el panel derecho */
    .right-panel {
        width: 50%;
        padding: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fff;
        overflow-y: auto; /* Permite scroll solo si el contenido excede la altura */
        box-sizing: border-box; /* Asegura que el padding no afecte el tamaño */
    }

    .login-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        padding: 40px;
        box-sizing: border-box;
        height: auto;
    }

    .login-card h1 {
        font-size: 2rem;
        color:  #4A001F;
        text-align: center;
        margin-bottom: 20px;
    }

    .login-card h2 {
        font-size: 1.1rem;
        color: #666;
        text-align: center;
        margin-bottom: 30px;
    }

    .login-card .form-group {
        margin-bottom: 20px;
    }

    .login-card label {
        font-size: 0.9rem;
        color: #333;
        font-weight: 600;
        display: block; /* Asegura que los labels estén en línea con el campo */
        margin-bottom: 10px; /* Separar el texto del campo de entrada */
    }

    .login-card .form-control {
        border-radius: 8px;
        padding: 12px;
        font-size: 1rem;
        border: 1px solid #ddd;
        box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.1);
        width: 100%; /* Asegura que los campos de entrada ocupen todo el ancho disponible */
        margin-bottom: 15px; /* Separación entre los campos */
    }

    .login-card .form-control:focus {
        border-color: #004d7f;
        box-shadow: 0 0 10px rgba(0, 77, 127, 0.2);
    }

    .login-card .btn-login {
        background-color:  #4A001F;
        color: #fff;
        font-weight: 700;
        padding: 12px 30px;
        border-radius: 5px;
        border: none;
        width: 100%;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .login-card .btn-login:hover {
        background-color: #003b60;
    }

    .login-card .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
        margin-bottom: 20px;
    }

    .logo-container {
        text-align: center;
        margin-bottom: 30px;
    }

    .logo-container img {
        width: 300px;
        margin-bottom: 15px;
    }

    /* Estilos para pie de página */
    .footer-links {
        text-align: center;
        font-size: 0.9rem;
        color: #888;
        margin-top: 20px;
    }

    .footer-links a {
        color: #004d7f;
        text-decoration: none;
    }

    .footer-links a:hover {
        text-decoration: underline;
    }

</style>

<div class="login-container">
    <!-- Panel izquierdo con marca de agua -->
    <div class="left-panel">
        <div class="logo-container">
            <img src="{{ asset('imagenes/logoFinanzas.png') }}" alt="Logo">
        </div>
    </div>

    <!-- Panel derecho con formulario -->
    <div class="right-panel">
        <div class="login-card">
            <div class="text-center mb-10">
                <h1>Buzón de Quejas</h1>
                <h2>Iniciar sesión para registrar tu queja</h2>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group">
                    <label for="email">{{ __('Correo Electrónico') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Contraseña') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn-login">{{ __('Iniciar sesión') }}</button>
                </div>
            </form>

            <!-- Mostrar errores de validación -->
            @if ($errors->any())
                <div class="mt-4">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
        </div>
    </div>
</div>
