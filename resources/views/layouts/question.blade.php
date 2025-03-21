<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 h-screen flex flex-col" x-data="quizManager()" x-init="init()">

    <!-- ✅ Header -->
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
                    <div class="h-full bg-green-400 transition-all duration-300" :style="'width:' + ((currentIndex + 1) / questions.length * 100) + '%'">
                    </div>
                </div>
                <div class="text-white text-sm font-semibold mt-2">
                    <span x-text="currentIndex + 1"></span> / <span x-text="questions.length"></span>
                </div>
            </div>
            <button @click="endQuiz()" class="bg-red-500 px-4 py-2 rounded text-white hover:bg-red-600">
                End Quiz
            </button>
        </div>
    </header>

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

    <!-- ✅ Footer -->
    <footer class="bg-black text-white p-4 flex justify-between  items-center text-lg">
        <!-- ✅ Left Side (Settings, Options, Help) -->
        <div class="flex space-x-4">
            <!-- ⚙ Settings -->
            <button @click="showPopup = true"
                class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center space-x-2 hover:bg-green-600">
                ⚙ <span></span>
            </button>
            <!-- 🔲 Grid Option -->
            <button class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center space-x-2 hover:bg-green-600">
                🔲 <span></span>
            </button>
            <!-- ❓ Help -->
            <button @click="showHelp = true"
                class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center space-x-2 hover:bg-green-600">
                ❓ <span></span>
            </button>

            <button @click="showCalculator = true"
                class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center space-x-2 hover:bg-green-600">
                🖩 <span></span>
            </button>
        </div>

        <!--Right Side (Chat, Flag, Navigation) -->
        <div class="flex space-x-4">
            <!--Chat -->
            <button class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center space-x-2 hover:bg-green-600">
                💬 <span></span>
            </button>
            <!--  Flag -->
            <button class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center space-x-2 hover:bg-green-600">
                🚩 <span></span>
            </button>
            <!-- ⬅ Back & Next Buttons -->
            <button @click="prevQuestion()"
                class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center space-x-2 hover:bg-green-600">
                <span>Back</span>
            </button>
            <button @click="nextQuestion()"
                class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center space-x-2 hover:bg-green-600">
                <span>Next</span>
            </button>
        </div>
    </footer>

    <!-- show calculator -->
    <template x-if="showCalculator">
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded shadow-lg w-96">
                <h2 class="text-lg font-bold mb-4">Calculator</h2>
                <input type="text" x-model="calcInput"
                    class="w-full p-3 border rounded mb-4 text-gray-900 text-right text-xl">
                <div class="grid grid-cols-4 gap-3">
                    <template x-for="btn in calcButtons" :key="btn">
                        <button @click="calculate(btn)"
                            class="p-4 rounded text-gray-200 text-xl font-bold shadow-md transition-transform transform hover:scale-105"
                            :class="btn === 'C' ? 'bg-red-500 hover:bg-red-600' :
                                btn === '=' ? 'bg-green-500 hover:bg-green-600' : ['+', '-', '*', '/'].includes(
                                    btn) ? 'bg-blue-500 hover:bg-blue-600' :
                                'bg-gray-500 hover:bg-gray-600'">
                            <span x-text="btn" class="text-gray-100"></span>
                        </button>
                    </template>
                </div>
                <button @click="showCalculator = false"
                    class="mt-4 bg-red-500 px-4 py-3 rounded text-white hover:bg-red-600 w-full">Close</button>
            </div>
        </div>
    </template>

    <!-- ✅ Settings Modal -->
    <div x-show="showPopup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 dark:text-white p-6 rounded-lg shadow-md w-96 text-black">
            <h3 class="text-xl font-semibold mb-4">Settings</h3>
            <div class="flex flex-col space-y-4">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" x-model="isDarkMode" @change="toggleDarkMode()" class="h-5 w-5">
                    <span>Enable Dark Mode</span>
                </label>
            </div>
            <button class="bg-red-500 px-4 py-2 rounded text-white hover:bg-red-600 mt-4 w-full"
                @click="showPopup = false">
                Close
            </button>
        </div>
    </div>

    <!-- ✅ help Modal -->
    <div x-show="showHelp" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 dark:text-white p-6 rounded-lg shadow-md w-96 text-black">
            <h3 class="text-xl font-semibold mb-4">Settings</h3>
            <div class="flex flex-col space-y-4">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" x-model="isDarkMode" @change="toggleDarkMode()" class="h-5 w-5">
                    <span>Enable Dark Mode</span>
                </label>
            </div>
            <button class="bg-red-500 px-4 py-2 rounded text-white hover:bg-red-600 mt-4 w-full"
                @click="showHelp = false">
                Close
            </button>
        </div>
    </div>
</body>
</html>
