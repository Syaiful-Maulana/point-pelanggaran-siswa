<html>
  <head>
    <link rel="stylesheet" href="{{ asset('styleLogin/css/bootstrap.min.css')}}" />

    <link rel="stylesheet" href="{{ asset('styleLogin/Fonts/RobotoSlab-VariableFont_wght.ttf')}}" />
    <link rel="stylesheet" href="{{ asset('styleLogin/css/style.css')}}" />
    <title>Login</title>
  </head>

  <body>
    <div class="box row" style="margin-top: 100px">
      <div class="left-box col">
        <div class="content">
          <div class="item">
            <img src="{{ asset('styleLogin/img/electricity.png')}}" height="40px;" />
            <h3 style="text-align: center">Login</h3>
          </div>
 
          <form action="{{ route('login-admin')}}" method="POST">
            @csrf

          <div class="mb-3 item">
              <label for="exampleInputEmail1" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" placeholder="Username" name="username" aria-describedby="emailHelp" />
            </div>
            <div class="mb-3 item">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="min 8. characters" />
            </div>

            <input value="Submit" type="submit" id="submit" class="form-control btn item" />
          </form>
        </div>
      </div>

      <div class="right-box col">
        <div id="myCarousel" class="carousel carousel-dark slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="text" style="cursor: pointer; pointer-events: none" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" style="cursor: pointer; pointer-events: none" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3" style="cursor: pointer; pointer-events: none"></button>
          </div>

          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="{{ asset('styleLogin/img/1.gif')}}" style="cursor: pointer; pointer-events: none" class="d-block w-100" alt="..." />
            </div>
            <div class="carousel-item">
              <img src="{{ asset('styleLogin/img/2.gif')}}" style="cursor: pointer; pointer-events: none" class="d-block w-100" alt="..." />
            </div>
            <div class="carousel-item">
              <img src="{{ asset('styleLogin/img/3_.gif')}}" style="cursor: pointer; pointer-events: none" class="d-block w-100" alt="..." />
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.4/dist/sweetalert2.all.min.js"></script>
  <script src="{{ asset('styleLogin/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('styleLogin/js/script.js')}}"></script>
  <script>
    @if (session('status'))
      Swal.fire({
        icon: 'error',
        text: 'Email atau Kata Sandi Salah'
      })
    @endif

  </script>
</html>
