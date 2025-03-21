<!-- frontend/quiz.blade.php -->
@extends('layouts.header')

@section('quizzes-menu')
<div class="container mx-auto">
    <h2 class="text-xl font-bold mb-4">quizes menu</h2>
    <ul class="list-decimal pl-5">
        @foreach($tests as $test)
            <li class="mb-2">
                <a href="{{ route('quizzes.show', $test->id) }}" class="text-blue-500 hover:underline">
                    {{ $loop->iteration }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection