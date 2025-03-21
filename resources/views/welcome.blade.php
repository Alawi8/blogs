<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz System - Home</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    
    <!-- Header -->
    <header class="bg-green-600 text-white p-4 text-center font-bold text-xl shadow-md flex justify-between items-center">
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
    
    
    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center">
        <div class="text-center bg-white p-8 rounded-lg shadow-lg max-w-lg">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome to the Quiz System</h1>
            <p class="text-gray-600 mb-6">Test your knowledge with exciting quizzes!</p>
            
            <a href="/questions" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg">
                Start Quiz
            </a>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-8 shadow-md">
        &copy; 2025 Quiz System. All rights reserved.
    </footer>

</body>
</html>
