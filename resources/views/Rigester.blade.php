<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50 text-gray-800">

    <form action="/create_user" method="POST" class="w-full max-w-sm bg-white p-6 rounded-lg shadow-sm space-y-4">
        @csrf

        <div>
            <label class="block text-sm mb-1">Username</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-300">
        </div>

        <div>
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-300">
        </div>

        <div>
            <label class="block text-sm mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-300">
        </div>

        <button type="submit" class="w-full bg-gray-800 text-white py-2 rounded text-sm hover:bg-gray-700">
            Register
        </button>

        <p class="text-xs text-center text-gray-500">
            Already have an account?
            <a href="/login" class="underline">Login</a>
        </p>
    </form>

</body>
</html>
