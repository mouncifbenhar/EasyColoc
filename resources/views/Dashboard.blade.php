<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Easycoloc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 text-gray-800">

  
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold">Dashboard</h1>

            <div class="flex items-center space-x-4">
                <a href="/admin_page" 
                   class="text-sm text-gray-700 hover:text-black transition">
                    Admin
                </a>

                <form action="/logout" method="POST">
                    @csrf
                    <button class="text-sm text-red-600 hover:text-red-800 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    
    <div class="max-w-xl mx-auto mt-12 bg-white p-8 rounded-lg shadow-sm">

        <h2 class="text-xl font-semibold mb-6">
            Create New Colocation
        </h2>

        <form action="/create_colocation" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">
                    Title
                </label>
                <input type="text" 
                       name="title"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-800">
            </div>

            <button type="submit"
                    class="w-full bg-gray-800 text-white py-2 rounded text-sm hover:bg-gray-700 transition">
                Create
            </button>
        </form>

    </div>

</body>
</html>