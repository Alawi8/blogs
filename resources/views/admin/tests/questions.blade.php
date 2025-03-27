<x-app-layout>
    <div x-data="questionManager(@json($test), @json($questions))" x-init="$nextTick(() => console.log('Loaded', questions)) 
        class="max-w-5xl mx-auto px-6 py-10 space-y-6">

        <!-- عنوان الصفحة -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            📝 Manage Questions for: <span x-text="test.title"></span>
        </h1>

        <!-- إضافة سؤال جديد -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Add New Question</h2>

            <form @submit.prevent="submitQuestion" class="space-y-4">
                <!-- نص السؤال -->
                <textarea x-model="form.question_text" placeholder="Question text"
                    class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white" required></textarea>

                    <div x-text="questions.length"></div>


                <!-- زر الحفظ -->
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Save Question
                </button>
            </form>
        </div>

        <!-- قائمة الأسئلة -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <template x-if="questions.length === 0">
                <p class="text-gray-500 dark:text-gray-400">No questions added yet.</p>
            </template>

            <template x-for="question in questions" :key="question.id">
                <div class="border-b py-4">
                    <p class="font-medium text-gray-900 dark:text-white" x-text="question.question_text"></p>
                    <ul class="list-disc pl-6 mt-2 text-gray-700 dark:text-gray-300">
                        <template x-for="(ans, i) in question.answers" :key="i">
                            <li>
                                <span x-text="ans.answer_text"></span>
                                <span x-show="ans.is_correct" class="text-green-600 font-semibold">✔</span>
                            </li>
                        </template>
                    </ul>
                </div>
            </template>
        </div>
    </div>

    <!-- Alpine Component -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function questionManager(test, initialQuestions) {
            return {
                test,
                questions: initialQuestions,
                form: {
                    question_text: '',
                    answers: ['', '', '', ''],
                    correct_answer: 0,
                },

                async submitQuestion() {
                    try {
                        const response = await axios.post(`/admin/tests/${this.test.id}/questions`, this.form);
                        this.questions.push(response.data.question);
                        this.form = {
                            question_text: '',
                            answers: ['', '', '', ''],
                            correct_answer: 0,
                        };
                    } catch (error) {
                        alert("❌ Failed to save question.");
                        console.error(error);
                    }
                }
            };
        }
    </script>
</x-app-layout>
