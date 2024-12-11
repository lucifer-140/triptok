@extends(Auth::check() ? 'layouts.app' : 'layouts.guest')

@section('content')
<div class="container">
    <h1>Contact Us</h1>
    <p>If you have any questions, feel free to reach out.</p>
    <form>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <label for="message">Message:</label>
        <textarea id="message" name="message"></textarea>
        <button type="submit">Submit</button>
    </form>
</div>
@endsection
