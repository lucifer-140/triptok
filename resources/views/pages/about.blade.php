@extends(Auth::check() ? 'layouts.app' : 'layouts.guest')

@section('content')
<div class="container">
    <h1>About Us</h1>
    <p>Welcome to our Trip Planner! We are dedicated to helping you plan the perfect journey.</p>
</div>
@endsection
