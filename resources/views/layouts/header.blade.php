<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 h-screen flex flex-col" x-data="questionManager()" x-init="startTimer()">

    <!-- ✅ Header -->
    <header class="bg-black text-white p-4 flex justify-between items-center w-full">
        <div class="text-lg font-semibold">
            Question <span x-text="currentIndex + 1"></span> - Section <span x-text="currentSection"></span>
        </div>

        <div class="text-lg font-semibold">
            Time Left: <span x-text="timeLeft"></span>
        </div>

        <div class="flex items-center space-x-4">
            <div class="w-40 h-2 bg-gray-600 rounded-full overflow-hidden">
                <div class="h-full bg-green-400 transition-all duration-300" :style="'width:' + progress + '%'">
                </div>
            </div>
            <button @click="endQuiz()" class="bg-red-500 px-4 py-2 rounded text-white hover:bg-red-600">
                End Quiz
            </button>
        </div>
    </header>

    <!-- ✅ Green Section -->
    <div class="bg-green-500 text-white text-center py-4 text-2xl font-bold">
        Test
    </div>

    <!-- ✅ Main Content -->
    <div class="flex flex-1">
        <!-- ✅ Left Sidebar (Questions List) -->
        <aside class="w-1/6 bg-white p-4 text-center border-r border-gray-300">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Questions</h3>
            <div class="flex flex-col space-y-2">
                <template x-for="(question, index) in questions" :key="index">
                    <button
                        class="py-2 rounded-md border border-gray-300 text-black font-semibold transition-all duration-200"
                        :class="currentIndex === index ? 'bg-white text-black border-gray-600' : 'bg-green-500 text-white hover:bg-green-600'"
                        @click="selectQuestion(index)">
                        <span x-text="index + 1"></span>
                    </button>
                </template>
            </div>
        </aside>

        <!-- ✅ Display Question Content -->
        <main class="flex-1 bg-white p-6 flex items-center justify-center">
            <div class="text-center">
                <h3 class="text-xl font-semibold mb-3" x-text="currentTitle" x-show="!timeUp">Select a question from the
                    list</h3>
                <p class="text-gray-700" x-text="currentContent" x-show="!timeUp"></p>

                <!-- Time Expired Message -->
                <div x-show="timeUp" class="text-center text-red-600 font-bold text-xl">
                    You cannot continue the quiz, time is up!
                </div>
            </div>
        </main>
    </div>

    <!-- ✅ Footer -->
    <!-- ✅ Footer -->
    <footer class="bg-black text-white p-4 flex justify-between items-center text-lg">
        <!-- ✅ Left Side (Settings, Options, Help) -->
        <div class="flex space-x-4">
            <!-- ⚙ Settings -->
            <button @click="showSettings = true"
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
        </div>

        <!-- ✅ Right Side (Chat, Flag, Navigation) -->
        <div class="flex space-x-4">
            <!-- 💬 Chat -->
            <button class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center space-x-2 hover:bg-green-600">
                💬 <span></span>
            </button>
            <!-- 🚩 Flag -->
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


    <!-- ✅ Settings Modal -->
    <!-- ✅ Settings Modal -->
    <div x-show="showSettings" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 dark:text-white p-6 rounded-lg shadow-md w-96 text-black">
            <h3 class="text-xl font-semibold mb-4">Settings</h3>
            <div class="flex flex-col space-y-4">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" x-model="isDarkMode" @change="toggleDarkMode()" class="h-5 w-5">
                    <span>Enable Dark Mode</span>
                </label>
            </div>
            <button class="bg-red-500 px-4 py-2 rounded text-white hover:bg-red-600 mt-4 w-full"
                @click="showSettings = false">
                Close
            </button>
        </div>
    </div>



    <script>
    function questionManager() {
        return {
            questions: [{
                    title: "What is the capital of Saudi Arabia?",
                    content: "The capital of Saudi Arabia is Riyadh.",
                    section: "1"
                },
                {
                    title: "How many planets are in the solar system?",
                    content: "There are 8 planets in the solar system.",
                    section: "2"
                },
                {
                    title: "What is the largest ocean in the world?",
                    content: "The Pacific Ocean is the largest ocean in the world.",
                    section: "3"
                },
            ],
            currentIndex: 0,
            currentTitle: "Select a question from the list",
            currentContent: "The question content will be displayed here after selection.",
            currentSection: "1",
            timeLeft: "02:00",
            timeUp: false,
            progress: 0,
            showSettings: false,
            isDarkMode: localStorage.getItem('darkMode') === 'true',

            startTimer() {
                let totalSeconds = 2 * 60;
                const timer = setInterval(() => {
                    if (totalSeconds <= 0) {
                        clearInterval(timer);
                        this.timeUp = true;
                        return;
                    }
                    totalSeconds--;
                    let minutes = Math.floor(totalSeconds / 60);
                    let seconds = totalSeconds % 60;
                    this.timeLeft = String(minutes).padStart(2, '0') + ":" + String(seconds).padStart(2, '0');
                }, 1000);
            },

            selectQuestion(index) {
                this.currentIndex = index;
                this.currentTitle = this.questions[index].title;
                this.currentContent = this.questions[index].content;
                this.currentSection = this.questions[index].section;
                this.updateProgress();
            },

            prevQuestion() {
                if (this.currentIndex > 0) {
                    this.selectQuestion(this.currentIndex - 1);
                }
            },

            nextQuestion() {
                if (this.currentIndex < this.questions.length - 1) {
                    this.selectQuestion(this.currentIndex + 1);
                }
            },

            updateProgress() {
                this.progress = ((this.currentIndex + 1) / this.questions.length) * 100;
            },

            endQuiz() {
                this.timeUp = true;
            },

            toggleDarkMode() {
                this.isDarkMode = !this.isDarkMode;
                localStorage.setItem('darkMode', this.isDarkMode);

                // Apply dark mode to HTML element
                if (this.isDarkMode) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
                
            }
            

        };
    }
    </script>


</body>

</html>