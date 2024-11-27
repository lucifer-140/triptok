@extends(Auth::check() ? 'layouts.app' : 'layouts.guest')

@section('content')
<div class="container">
    <h1>Terms of Service</h1>
    <p>By using our service, you agree to our terms and conditions.</p>
</div>
@endsection
