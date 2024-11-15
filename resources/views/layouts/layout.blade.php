<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/Stylos.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    
</head>

<body>
<nav class="navbar justify-content-between shadow-sm bg-white boderBottom--Rosa position-static">
    <a class="navbar-brand" href="#">
        <img class="logo-header" src="{{ asset('imagenes/logoFinanzas.png') }}" alt="">
    </a>
    <a class="navbar-brand" href="#">
        <img class="logo-headerG" src="{{ asset('imagenes/Sello Logo  Principal.png') }}" alt="">
    </a>
    <a class="navbar-brand" href="#">
        <img class="logo-header" src="{{asset ("imagenes/200_mejor.png")}}" alt="" style="width: 220px; height: auto;">
    </a>
</nav>

    <div class="container-fluid vh-100 d-flex">
        <div class="menuLateral pb-3 px-3">
            <br><br>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('menuPrincipal') }}"><i class="bi bi-house-door me-2"></i>Inicio</a>
                </li>
                
                <li class="nav-item dropdown">
                 
                    <a class="nav-link dropdown-toggle custom-dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-file-earmark-text me-2"></i>Informe Dependecia
                            </a>
                            <ul class="dropdown-menu custom-dropdown-menu" id="sssubMenu">
                                <li>
                                    <a class="dropdown-item custom-dropdown-item"  style="padding: 3px 12px;" href="{{ route('dependencias.create') }}">
                                        <i class="bi bi-building me-2" style="font-size: 1.3rem;"></i>Alta dependencia
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item custom-dropdown-item"  style="padding: 3px 12px;" href="{{ route('dependencias.index') }}">
                                        <i class="bi bi-journal-text me-2" style="font-size: 1.3rem;"></i>Ver Depedencias
                                    </a>
                                </li>
                            </ul>
            
                </lix>

                <li class="nav-item dropdown">
                 
                    <a class="nav-link dropdown-toggle custom-dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-file-earmark-text me-2"></i>Informe Areas
                            </a>
                            <ul class="dropdown-menu custom-dropdown-menu" id="sssubMenu">
                                <li>
                                    <a class="dropdown-item custom-dropdown-item"  style="padding: 3px 12px;" href="{{ route('areas.create') }}">
                                        <i class="bi bi-building me-2" style="font-size: 1.3rem;"></i>Alta area
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item custom-dropdown-item"  style="padding: 3px 12px;" href="{{ route('areas.index') }}">
                                        <i class="bi bi-journal-text me-2" style="font-size: 1.3rem;"></i>Ver Areas
                                    </a>
                                </li>
                            </ul>
            
                </li>
                                                                     
            </ul>
           
        </div>
        <div class="container-fluid pt-5 content">
            @yield('content')
        </div>
    </div>

<div class="container-fluid pt-5 content">
    @yield('content')
    <div id="loader-overlay">
        <div id="loader">
            <img src="{{ asset('imagenes/Logo3.gif') }}" alt="Loader" style="width: 340px; height: 270px;" class="loaderGif">
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    function toggleDropdown(event, menuId) {
        event.preventDefault();
        var subMenu = document.getElementById(menuId);
        
        // Alternar el menú seleccionado
        subMenu.style.display = (subMenu.style.display === 'none' || subMenu.style.display === '') ? 'block' : 'none';

        // Cerrar otros submenús
        var allMenus = ['sssubMenu', 'subMenu', 'otrosubMenu'];
        allMenus.forEach(function(id) {
            if (id !== menuId) {
                document.getElementById(id).style.display = 'none';
            }
        });
    }

    function showLoader() {
        document.getElementById('loader-overlay').style.display = 'block';
        const tiempoDeEjecucion = 3000;
        setTimeout(function() {
            document.getElementById('loader-overlay').style.display = 'none';
        }, tiempoDeEjecucion);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                showLoader();
                this.submit();
            });
        });

        // Cerrar el submenú al hacer clic fuera de él
        document.addEventListener('click', function(event) {
            const allMenus = ['sssubMenu', 'subMenu', 'otrosubMenu'];
            allMenus.forEach(function(id) {
                const menu = document.getElementById(id);
                if (menu.style.display === 'block' && !menu.contains(event.target) && !event.target.closest('.dropdown-toggle')) {
                    menu.style.display = 'none';
                }
            });
        });
    });
</script>


</body>

</html>
