<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation - Easycoloc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center text-gray-800">

    <div class="bg-white shadow-sm rounded-lg p-8 w-full max-w-md text-center">

        <h1 class="text-xl font-semibold mb-6">
            Invitation
        </h1>

        <div class="space-y-4">

            <a href="/accept/{{$token}}"
               class="block w-full bg-gray-800 text-white py-2 rounded text-sm hover:bg-gray-700 transition">
                Accept Invitation
            </a>

            <a href="/Dashboard"
               class="block w-full border border-gray-300 py-2 rounded text-sm hover:bg-gray-100 transition">
                Go to Dashboard
            </a>

            <a href="http://127.0.0.1:8000/Rigester"
               class="block w-full bg-gray-800 text-white py-2 rounded text-sm hover:bg-gray-700 transition">
                if you dont hava accaount Rigester 
            </a>

        </div>

    </div>

</body>
</html>