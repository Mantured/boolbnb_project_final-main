<header>
  <div class="back-header">
    <nav class="navbar">
      <div class="container d-flex align-items-center">
        <a class="logo" href="{{ url('/') }}"><img src="{{ asset('/images/logo-boolbnb.png') }}" alt="boolbnb_logo"></a>
        <div class="d-flex justify-content-end">
          <ul class="navbar-nav ml-auto">
            @guest

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle border border-light rounded-pill my-2 shadow"
                    href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Area Riservata
                </a>

                <div class="dropdown-menu dropdown-menu-end border-0 shadow pt-3"
                    aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('login') }}">
                        {{ __('Login') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('register') }}">
                        {{ __('Registrati') }}
                    </a>
                </div>
            </li>
        	  @else
            <li class="nav-item dropdown ">
                <a class="px-3 nav-username nav-link dropdown-toggle border border-light rounded-pill p-2 my-2 shadow text-dark"
                    href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ ucfirst(Auth::user()->first_name) }}
                </a>

                <div class="dropdown-menu dropdown-menu-end border-0 shadow pt-3"
                    aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('home', Auth::id()) }}">
                        {{ __('Account') }}
                    </a>
                    <hr>
                    <a class="dropdown-item" href="{{ route('registered.apartments.create') }}">
                        {{ __('Aggiungi Alloggio') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        {{ __('Esci') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
            @endguest
            </ul>
    </div>


      </div>
    </nav>
  </div>  
</header>
