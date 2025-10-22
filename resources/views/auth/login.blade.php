<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-plane me-2"></i>
            <strong>X-FLY</strong>
        </a>
        
        <div class="navbar-nav ms-auto">
            @auth
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i> {{ Auth::user()->first_name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('bookings.index') }}">
                            <i class="fas fa-ticket-alt me-2"></i>Mis Reservas
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a class="nav-link" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                </a>
                <a class="nav-link" href="{{ route('register') }}">
                    <i class="fas fa-user-plus me-1"></i> Registrarse
                </a>
            @endauth
        </div>
    </div>
</nav>