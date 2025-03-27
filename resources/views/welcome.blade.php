<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz System - Home</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100 flex flex-col min-h-screen" x-data="quizManager">
    @role('admin')
    <p>أنت المدير ✨</p>
@endrole

    <!-- Header -->
    <header
        class="bg-green-600 text-white p-4 text-center font-bold text-xl shadow-md flex justify-between items-center">
        <div class="ml-4">
            <a href="{{ url('/') }}" class="text-white text-xl font-bold">Quiz System</a>
        </div>

        <div class="mr-4">
            @auth
                <span class="mr-4">welcome , {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 px-3 py-1 rounded text-white hover:bg-red-700">logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-blue-500 px-3 py-1 rounded text-white hover:bg-blue-700">login</a>
            @endauth
        </div>
    </header>

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
        <strong class="font-bold">Oops! </strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center" x-data="{ isLoggedIn: {{ auth()->check() ? 'true' : 'false' }} }">
        <div class="text-center bg-white p-8 rounded-lg shadow-lg max-w-lg">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome to the Quiz System</h1>

            <!-- ✅ عرض الزر فقط إذا فيه بيانات -->
            <template x-if="questions.length > 0">
                <a href="/questions"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg mt-4">
                    Start Quiz
                </a>
            </template>

            <!-- ❌ إذا ما فيه بيانات -->
            <template x-if="questions.length === 0">
                <div class="text-red-500 text-sm font-medium mt-4">
                    No quiz questions are available right now. Please try again later.
                </div>
            </template>
        </div>
    </main>




    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-8 shadow-md">
        &copy; 2025 Quiz System. All rights reserved.
    </footer>

</body>

</html>
