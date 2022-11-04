<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/logo/logo.jpeg" type="image/x-icon" />
    <title>@yield('title', 'dashboard')</title>
    @include('template.head')
    @stack('css')
  </head>
  <body>
    @include('template.sidebar')

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
      <!-- ========== header start ========== -->
        @include('template.navbar')
      <!-- ========== header end ========== -->

      <!-- ========== section start ========== -->
        @yield('content')
      <!-- ========== section end ========== -->
      <!-- ========== footer start =========== -->
      <!-- ========== footer end =========== -->
      @include('template.footer')
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    @yield('modal')
    @include('template.script')
    @stack('js')
  </body>
</html>
