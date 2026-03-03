<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Easycoloc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold">Admin Dashboard</h1>

            <div class="flex items-center space-x-4">
                <a href="/Dashboard" 
                   class="text-sm text-gray-700 hover:text-black transition">
                    Dashboard
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

    <div class="max-w-6xl mx-auto mt-10 px-6 space-y-10">

        <!-- USERS SECTION -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-xl font-semibold mb-6">Users</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3">ID</th>
                            <th class="p-3">Name</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Status</th>
                            <th class="p-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b">
                                <td class="p-3">{{ $user->id }}</td>
                                <td class="p-3">{{ $user->name }}</td>
                                <td class="p-3">{{ $user->email }}</td>
                                <td class="p-3">
                                    @if($user->is_banned)
                                        <span class="text-red-600 font-medium">
                                            Banned
                                        </span>
                                    @else
                                        <span class="text-green-600 font-medium">
                                            Active
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3 text-right">
                                @if(!$user->hasRole('admin'))
                                    @if(!$user->is_banned)
                                        <form action="{{ route('admin.ban', $user) }}" 
                                              method="POST"
                                              class="inline">
                                            @csrf
                                            <button class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition">
                                                Ban
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.unban', $user) }}" 
                                              method="POST"
                                              class="inline">
                                            @csrf
                                            <button class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 transition">
                                                Unban
                                            </button>
                                        </form>
                                    @endif
                                @else
                                        <span class="text-grey-600 font-medium">
                                            Protected
                                        </span>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <!-- COLOCATIONS SECTION -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-xl font-semibold mb-6">Colocations</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3">ID</th>
                            <th class="p-3">Title</th>
                            <th class="p-3">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($colocs as $coloc)
                            <tr class="border-b">
                                <td class="p-3">{{ $coloc->id }}</td>
                                <td class="p-3">{{ $coloc->title }}</td>
                                <td class="p-3">{{ $coloc->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>