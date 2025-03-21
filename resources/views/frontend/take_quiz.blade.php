@extends('layouts.header')

@section('quizzes')

<div x-data="{ questionIndex: 0, timeLeft: 600 }" class="container mx-auto bg-white p-6">
    <h2 class="text-xl font-bold mb-4">📝 {{ $test->title }}</h2>

    <form id="quizForm" action="{{ route('quizzes.submit', $test->id) }}" method="POST">
        @csrf
        
        @foreach($test->questions as $index => $question)
            <div x-show="questionIndex === {{ $index }}" class="mb-4 p-4 border">
                <p class="font-bold">{{ $index + 1 }}. {{ $question->question_text }}</p>

                @foreach($question->answers as $answer)
                    <label class="block">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" required>
                        {{ $answer->answer_text }}
                    </label>
                @endforeach

                <div class="mt-4 flex justify-between">
                    <button x-show="{{ !$loop->first }}" @click.prevent="questionIndex--" class="bg-gray-500 text-white px-4 py-2">السابق</button>
                    <button x-show="{{ !$loop->last }}" @click.prevent="questionIndex++" class="bg-blue-500 px-4 py-2">التالي</button>
                    <button x-show="{{ $loop->last }}" type="submit" class="bg-green-500 px-4 py-2">إرسال الإجابات</button>
                </div>
            </div>
        @endforeach
    </form>

    <div class="bg-red-500 text-black p-2 text-center">
        ⏳ الوقت المتبقي: <span x-text="timeLeft"></span>s
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('quizTimer', () => ({
                timeLeft: 600,
                init() {
                    setInterval(() => {
                        if (this.timeLeft > 0) {
                            this.timeLeft--;
                        } else {
                            document.getElementById('quizForm').submit();
                        }
                    }, 1000);
                }
            }));
        });
    </script>
</div>

@endsection
