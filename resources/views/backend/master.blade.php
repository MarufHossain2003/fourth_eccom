<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>
  @include('backend.includes.style')
  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  @include('backend.includes.navbar')
  @include('backend.includes.sidebar')
  
  <div class="content-wrapper">
    @yield('content')
  </div>
  
  @include('backend.includes.footer')

  
</div>
<!-- ./wrapper -->
@include('backend.includes.script')

</body>
</html>
