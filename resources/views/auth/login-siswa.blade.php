<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Siswa</title>
    <link href="{{ asset('styleLogin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
</head>
<body>
    <div class="container-login">
        <div class="login-area">
            <form class="login-box" method="POST" action="{{ route('loginn')}}">
                @csrf
                <h1>Login</h1>
                <input type="text" name="nisn" placeholder="nisn" autocomplete="off" required>
                <input type="password" name="password" placeholder="Password" required>

                <button class="btn-login">Masuk</button>
                <div class="text-center mt-2">
                    <a href="/guru/login">Masuk sebagai Guru</a>
                </div>
            </form>
        </div>
        <div class="img-area">
            <img src="{{ asset('img/siswa.svg') }}" alt="img">
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
