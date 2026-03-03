<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colocation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100 text-gray-800">

<nav class="bg-white shadow p-4 flex justify-between">
    <h1 class="font-semibold text-lg">Colocation: {{ $coloc->title }}</h1>

    <div class="space-x-4">
        <a href="/admin/dashboard" class="text-sm hover:underline">Admin</a>

        <form action="/logout" method="POST" class="inline">
            @csrf
            <button class="text-red-600 text-sm">Logout</button>
        </form>
    </div>
</nav>


<div class="max-w-5xl mx-auto mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- MEMBERS SECTION --}}
    <div class="bg-white p-6 rounded shadow">

        <h2 class="font-semibold mb-4">Members</h2>

        @php
            $isOwner = $coloc->user()
                ->where('user_id', auth()->id())
                ->wherePivot('role','owner')
                ->exists();
        @endphp
        @if($isOwner)
        <div class="max-w-xl mx-auto mt-12 bg-white p-8 rounded-lg shadow-sm">

            <h2 class="text-xl font-semibold mb-6">
                members
            </h2>
        <form action="/add_member/{{$coloc->id}}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Email
                    </label>
                    <input type="text" 
                        name="email"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-800">
                </div>

                <button type="submit"
                        class="w-full bg-gray-800 text-white py-2 rounded text-sm hover:bg-gray-700 transition">
                    invite
                </button>
            </form>
        </div>
        @endif
        @foreach($users as $user)
            <div class="flex justify-between items-center border-b py-2 text-sm">
                <div>
                    {{ $user->name }}
                    <span class="text-xs text-gray-500">
                        (Balance: {{ $user->balance }})
                    </span>
                </div>

                @if($isOwner && $user->id != auth()->id())
                    <form action="/colocation/{{$coloc->id}}/kick/{{$user->id}}" method="POST">
                        @csrf
                        <button class="bg-red-500 text-white px-2 py-1 text-xs rounded">
                            Kick
                        </button>
                    </form>
                @endif
            </div>
        @endforeach


        {{-- Quit Button --}}
        @if(!$isOwner)
            <form action="/colocation/{{$coloc->id}}/quit/{{auth()->id()}}" 
                  method="POST" 
                  class="mt-4">
                @csrf
                <button class="bg-red-600 text-white px-3 py-1 text-sm rounded w-full">
                    Quit Colocation
                </button>
            </form>
        @endif

    </div>



    {{-- CREATE SECTION --}}
    <div class="bg-white p-6 rounded shadow">

        {{-- Add Category --}}
        <form action="/create_Categories/{{$coloc->id}}" method="POST" class="mb-6">
            @csrf
            <h3 class="font-semibold mb-2">Add Category</h3>
            <input type="text" name="title"
                   class="border w-full px-2 py-1 mb-2 text-sm"
                   placeholder="Category title">
            <button class="bg-gray-800 text-white px-3 py-1 text-sm rounded w-full">
                Add
            </button>
        </form>


        {{-- Add Expense --}}
        <form action="/colocation/{{$coloc->id}}/expense" method="POST">
            @csrf
            <h3 class="font-semibold mb-2">Add Expense</h3>

            <input type="text" name="title"
                   class="border w-full px-2 py-1 mb-2 text-sm"
                   placeholder="Expense title">

            <input type="number" step="0.01" name="amount"
                   class="border w-full px-2 py-1 mb-2 text-sm"
                   placeholder="Amount">

            <select name="category_id"
                    class="border w-full px-2 py-1 mb-2 text-sm">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">
                        {{$category->title}}
                    </option>
                @endforeach
            </select>

            <button class="bg-gray-800 text-white px-3 py-1 text-sm rounded w-full">
                Add Expense
            </button>
        </form>

    </div>

</div>



{{-- EXPENSES SECTION --}}
<div class="max-w-5xl mx-auto mt-8 bg-white p-6 rounded shadow">

    <h2 class="font-semibold mb-4">Expenses</h2>

    @foreach($expenses as $expense)

        <div class="border rounded p-4 mb-4 bg-gray-50">

            <div class="flex justify-between font-semibold">
                <span>{{ $expense->title }}</span>
                <span>{{ $expense->amount }}</span>
            </div>

            <div class="text-xs text-gray-500 mb-2">
                Paid by: {{ $expense->payer->name ?? '' }}
            </div>

            {{-- Shares --}}
            @foreach($expense->shares as $user)
                <div class="flex justify-between items-center border-t pt-2 mt-2 text-sm">

                    <span>
                        {{ $user->name }} owes {{ $user->pivot->amount }}
                    </span>

                    @if(auth()->id() == $user->id)
                        <form action="/expense/{{$expense->id}}/pay/{{$user->id}}" method="POST" class="inline">
                            @csrf
                            <button class="bg-blue-600 text-white px-2 py-1 text-xs rounded">Pay</button>
                        </form>
                    @endif

                </div>
            @endforeach

        </div>

    @endforeach

    <div class="font-semibold text-right">
        Total: {{$total}}
    </div>

</div>

</body>
</html>