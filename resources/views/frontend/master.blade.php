
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
	{!! renderMetaTags() !!}

    <title>{{ config('app.name', 'Laravel') }}</title>
	@include('frontend.includes.style')

</head>
<body>
	@include('frontend.includes.header')
	<main>
        @yield('content')
    </main>
	@include('frontend.includes.footer')
	@include('frontend.includes.script')

	<!-- Structured Data -->
	{!! renderStructuredData() !!}
</body>
</html>
@stack('script')