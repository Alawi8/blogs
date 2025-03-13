<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $test->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="w-full max-w-2xl bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4 text-center">{{ $test->title }}</h1>
        <p class="text-gray-600 text-center mb-6">{{ $test->description }}</p>

        <!-- عرض المؤقت -->
        <div class="text-center text-red-600 text-lg font-bold mb-4">
            الوقت المتبقي: <span id="timer">{{ $test->duration }}:00</span> دقيقة
        </div>

        @if(session('message'))
            <div class="p-4 mb-4 text-green-700 bg-green-200 rounded-lg text-center">
                {{ session('message') }}
            </div>
        @endif

        @if($test->questions->count() > 0)
            <form id="quiz-form" method="POST" action="{{ url('/submit-test/'.$test->id) }}">
                @csrf
                @foreach($test->questions as $index => $question)
                    <div class="mb-4 p-4 border rounded">
                        <p class="font-semibold">{{ $index + 1 }}. {{ $question->question_text }}</p>

                        @foreach($question->answers as $answer)
                            <label class="block">
                                <input type="radio" name="question_{{ $question->id }}" value="{{ $answer->id }}" class="mr-2">
                                {{ $answer->answer_text }}
                            </label>
                        @endforeach
                    </div>
                @endforeach

                <button type="submit" class="w-full mt-4 bg-blue-500 text-white p-2 rounded hover:bg-blue-700">
                    إرسال الإجابات
                </button>
            </form>
        @else
            <p class="text-red-500 text-center">لا توجد أسئلة متاحة لهذا الاختبار.</p>
        @endif
    </div>

    <script>
        let timeLeft = {{ $test->duration }} * 60; // تحويل الدقائق إلى ثواني
        let timerElement = document.getElementById("timer");

        function updateTimer() {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;
            timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            if (timeLeft <= 0) {
                document.getElementById("quiz-form").submit(); // إرسال النموذج تلقائيًا
            }
            timeLeft--;
        }

        setInterval(updateTimer, 1000);
    </script>

</body>
</html>
