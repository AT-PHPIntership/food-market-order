<html>
<head>
    <title>{{ __('404 Error') }}</title>
    @include('layouts.partials.style')
</head>
<body>
    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> {{ __('Oops! Page not found.') }}</h3>

            <p>
                {{ __('We could not find the page you were looking for.
                Meanwhile, you may') }} <a href="{{ route('dashboard')  }}"> {{ __('return to dashboard') }}</a>
            </p>

        </div>
        <!-- /.error-content -->
    </div>
</body>
</html>
