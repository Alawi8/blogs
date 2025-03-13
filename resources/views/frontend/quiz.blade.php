@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-xl font-bold mb-4">📜 قائمة الاختبارات</h2>
    <ul class="list-disc pl-5">
        @foreach($tests as $test)
            <li class="mb-2">
                <a href="{{ route('quizzes.show', $test->id) }}" class="text-blue-500 hover:underline">
                    {{ $test->title }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
