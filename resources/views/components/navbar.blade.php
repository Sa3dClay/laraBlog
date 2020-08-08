<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            
            <i class="fab fa-gg"></i>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" data-text="Home"  href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" data-text="Blog"  href="{{ url('/posts') }}">Blog</a></li>
                <li class="nav-item"><a class="nav-link" data-text="About" href="{{ url('/about') }}">About</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" data-text="Login" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-text="Register" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('notifications/index') }}" >
                            <i class="fas fa-bell"></i>
                            
                            <span id="newICON" class="badge badge-pill badge-danger hidden">
                                New
                            </span>
                        </a>
                    </li>

                    {{-- Admin --}}
                    @if(Auth::user()->role == "admin")
                        <li class="nav-item dropdown">
                            <a id="manageDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Manage <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="manageDropdown">
                                <a class="dropdown-item" href="{{ url('/users') }}">Users</a>
                                <a class="dropdown-item" href="{{ url('/') }}">Posts</a>
                            </div>
                        </li>
                    {{-- User --}}
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('/home') }}">Dashboard</a>
                                
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>

{{-- STR JS --}}
<script>
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(setInterval(function() {
        $.ajax({
            url: "{{ url('notifications/isThereNew') }}",
            method: 'post',
            success: (response) => {
                //console.log(response);
                if(response.new_notif) {
                    document.getElementById("newICON").style.display = "inline";
                } else {
                    document.getElementById("newICON").style.display = "none";
                }
            },
            error: (error)=>{
                //console.log(error);
            }
        });
    },1000 * 60 * 0.5));
    // Check The DB every 0.5 min
});
</script>
{{-- END JS --}}
