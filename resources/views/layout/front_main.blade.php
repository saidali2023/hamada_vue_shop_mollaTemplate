<!DOCTYPE html>
<html lang="en">
<head>
  @include('layout.front_head')
</head>
<body>
    <div class="page-wrapper">
      @include('layout.front_header')
      <main class="main">

        @yield('content')

        </main><!-- End .main -->
        @include('layout.front_footer_two')
      </div><!-- End .page-wrapper -->
      @include('layout.front_footer')

 </body>


 <!-- molla/index-4.html  22 Nov 2019 09:54:18 GMT -->
 </html>
