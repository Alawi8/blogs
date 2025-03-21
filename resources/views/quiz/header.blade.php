<header class="bg-black text-white p-4 flex justify-between items-center w-full">
    <div class="text-lg font-semibold">
        Question <span x-text="currentIndex + 1"></span> - Section <span x-text="currentSection"></span>
    </div>

    <!-- ✅ Timer Section -->
    <div class="text-lg font-semibold">
        Time Left: <span x-text="timeLeft"></span>
    </div>

    <div class="flex items-center space-x-4">
        <!-- ✅ Progress Bar -->
        <div class="flex flex-col items-center w-full max-w-lg">
            <div class="w-full h-4 bg-gray-600 rounded-full overflow-hidden relative mt-2">
                <div class="h-full bg-green-400 transition-all duration-300"
                    :style="'width:' + ((currentIndex + 1) / questions.length * 100) + '%'">
                </div>
            </div>
            <div class="text-white text-sm font-semibold mt-2">
                <span x-text="currentIndex + 1"></span> / <span x-text="questions.length"></span>
            </div>
        </div>
        <!-- End Quiz Button -->
        <button @click="endQuiz()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            End Quiz
        </button>
    </div>
</header>
