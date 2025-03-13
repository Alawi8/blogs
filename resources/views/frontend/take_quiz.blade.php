@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-xl font-bold mb-4">📝 {{ $test->title }}</h2>

    <form action="{{ route('quizzes.submit', $test->id) }}" method="POST">
        @csrf

        {{-- شريط التقدم بالأرقام --}}
        <div class="mb-4">
            @foreach($test->questions as $index => $question)
                <span class="px-3 py-1 border {{ $loop->first ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                    {{ $index + 1 }}
                </span>
            @endforeach
        </div>

        {{-- عرض كل سؤال --}}
        @foreach($test->questions as $index => $question)
            <div class="mb-4 p-4 border {{ $loop->first ? 'bg-gray-100' : '' }}">
                <p class="font-bold">{{ $index + 1 }}. {{ $question->question_text }}</p>

                @foreach($question->answers as $answer)
                    <label class="block">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" required>
                        {{ $answer->answer_text }}
                    </label>
                @endforeach
            </div>
        @endforeach

        <button type="submit" class="bg-green-500 text-white px-4 py-2">إرسال الإجابات</button>
    </form>
</div>
<script>
    let timeLeft = 600; // 10 دقائق
    function updateTimer() {
        if (timeLeft <= 0) {
            document.getElementById('quizForm').submit();
        }
        document.getElementById('timer').innerText = timeLeft + " ثانية";
        timeLeft--;
        setTimeout(updateTimer, 1000);
    }
    window.onload = updateTimer;
</script>

<div class="bg-red-500 text-white p-2">
    ⏳ الوقت المتبقي: <span id="timer"></span>
</div>

@endsection
