<!DOCTYPE html>
<html>
<head>
    <title>{{ $page }}</title>
    <script src="{{ asset($js_script) }}"></script>
</head>
<body>
    <h1>{{ $page }}</h1>
    <form id="loginForm" method="POST" action="{{ url('/user/loginp') }}">
        @csrf
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
