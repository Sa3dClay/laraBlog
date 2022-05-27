@extends('layouts.app')

@section('content')

    <div class="about-us jumbotron my-2 py-2">
        <div class="row justify-content-around">
            <div class="col-md-4 about-img p-5">
                <img src="{{ asset('img/atef.jpg') }}" class="img-fluid" title="Abdo Atef" />
            </div>

            <div class="col-md-8 about-info">
                <h2 class="name text-center">
                    <span id="name1" class="typewriter"></span>
                </h2>
                <span class="bio">Software Engineer (C++) / Full-stack Developer (Laravel, Vue)</span>
                <p>I'm a programmer who loves coding, working in web development and have a few experiences about UI/UX, building web applications with Laravel & Vue, building DBs using oracle/Mysql. </p>
            </div>
        </div>

        <hr>

        <div class="row justify-content-around">
            <div class="col-md-8 about-info">
                <h2 class="name text-center">
                    <span id="name2" class="typewriter"></span>
                </h2>
                <span class="bio">Software Engineer (Java) / Back-end Developer (Laravel)</span>
                <p>I'm a programmer who loves coding, working in web development/Desktop app development, building web applications with Laravel/desktop apps with Java, building DBs using oracle/Mysql.</p>
            </div>

            <div class="col-md-4 about-img p-5">
                <img src="{{ asset('img/sobh.jpg') }}" class="img-fluid" title="Abdo Sobh" />
            </div>
        </div>
    </div>

    @if(Auth::guard('user')->check())
        <div class="row justify-content-around my-2">
            <a class="btn btn-primary mybtn" href="{{ url('feedbacks') }}" role="button">Contact Us</a>
        </div>
    @endif

    {{-- str JS --}}
    <script>
        $(function () {
            var i = 0,
                j = 0,
                speed = 150,
                name1text = 'Abdulrahman Atef',
                name2text = 'Abdulrahman Sobh',
                name1 = document.getElementById("name1"),
                name2 = document.getElementById("name2");

            function typeWriter() {
                if (i < name1text.length) {
                    name1.innerHTML += name1text.charAt(i)
                    i++
                }
                if (j < name2text.length) {
                    name2.innerHTML += name2text.charAt(j)
                    j++
                }
                setTimeout(typeWriter, speed)
            }

            setTimeout(typeWriter, 500)
        })
    </script>
    {{-- end JS --}}

@endsection
