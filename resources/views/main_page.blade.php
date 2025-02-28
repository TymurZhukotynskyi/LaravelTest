<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<h1>Register</h1>

@if (isset($link))
{{--    <p>Your link: <a href="{{ route('page_a', $link) }}">{{ route('page_a', $link) }}</a></p>--}}
@else
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label for="name">Username:</label>
            <input type="text" name="name" id="username" required>
            @error('name')
            <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" required>
            @error('phone')
            <span>{{ $message }}</span>
            @enderror
        </div>
        <button type="submit">Register</button>
    </form>
@endif
</body>
</html>
