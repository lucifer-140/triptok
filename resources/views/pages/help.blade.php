@extends(Auth::check() ? 'layouts.app' : 'layouts.guest')

@section('content')
<div class="container">
    <h1>Help</h1>
    <p>Need assistance? Check out our FAQs or contact support.</p>
</div>
@endsection
