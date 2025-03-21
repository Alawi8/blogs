    <!-- ✅ Green Section -->
    <div class="bg-green-500 text-white py-4 text-2xl space-x-4 font-bold">
        Test
    </div>

    <!-- ✅ Main Content -->
    <template x-if="!timeUp">
        <div class="flex flex-1">
            <!-- ✅ Sidebar for Question Navigation -->
            <aside class="w-1/10 bg-white p-4 text-center border-r border-gray-300 overflow-y-auto"
                style="max-height: 70vh">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Questions</h3>
                <div class="flex flex-col space-y-2">
                    <template x-for="(question, index) in questions" :key="index">
                        <button
                            class="py-2 rounded-md border border-gray-300 text-black font-semibold transition-all duration-200"
                            :class="currentIndex === index ? 'bg-white text-black border-gray-600' :
                                'bg-green-500 text-white hover:bg-green-600'"
                            @click="selectQuestion(index)">
                            <span x-text="(index + 1)"></span>
                        </button>
                    </template>
                </div>
            </aside>
            <!-- ✅ Display Question Content -->
            <main class="flex-1 bg-white p-6 flex flex-col items-start justify-center relative w-full">
                <h2 class="text-2xl font-semibold mb-6 w-full " x-text="currentTitle"></h2>
                <ul class="space-y-4 w-full">
                    <template x-for="(option, index) in currentOptions" :key="option.answer_text">
                        <li class="w-full" @contextmenu.prevent="toggleStrikeThrough(currentIndex, index)">
                            <label
                                class="flex items-center space-x-4 w-full p-4 border rounded-lg cursor-pointer transition-all duration-300 text-lg"
                                :class="{
                                    'bg-green-500 text-white border-green-700': userAnswers[currentIndex] === option
                                        .answer_text && !isStrikethrough(currentIndex, index),
                                    'line-through text-white bg-red-500 opacity-75 border-red-400': isStrikethrough(
                                        currentIndex, index),
                                    'hover:bg-gray-100': !userAnswers[currentIndex] && !isStrikethrough(currentIndex,
                                        index)
                                }"
                                @click="selectAnswer(currentIndex, option.answer_text, index)">
                                <span class="font-bold text-lg "><span
                                        x-text="String.fromCharCode(65 + index)"></span>.</span>
                                <span x-text="option.answer_text" class="flex-1"></span>
                                <input type="radio" :name="'question_' + currentIndex" :value="option.answer_text"
                                    x-model="userAnswers[currentIndex]" class="hidden">
                            </label>
                        </li>
                    </template>
                </ul>
            </main>
        </div>
    </template>

    <template x-if="timeUp">
        <div class="flex flex-1 items-center justify-center">
            <h2 class="text-3xl font-bold text-red-600">Time is up! You can no longer answer questions.</h2>
        </div>
    </template>
    