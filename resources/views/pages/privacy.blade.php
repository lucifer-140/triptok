@extends(Auth::check() ? 'layouts.app' : 'layouts.guest')

@section('content')
<div class="container">
    <h1>Privacy Policy</h1>
    <p>Your privacy is important to us. Read our policy to learn more.</p>
</div>
@endsection
