<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 h-screen flex flex-col" x-data="quizManager()" x-init="init()">

@include('quiz.header')
@include('quiz.body')
@include('quiz.footer')
@include('quiz.modal')

</body>
</html>