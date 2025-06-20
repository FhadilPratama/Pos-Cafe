<header class="header-container">
    <div class="logo">
        VintageCafe
    </div>
    <div class="user-info">
        @auth
            <span class="user-name">Halo, {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="auth-link">Login</a>
            <a href="{{ route('register') }}" class="auth-link">Register</a>
        @endauth
    </div>
</header>
