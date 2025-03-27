<x-app-layout>
    <div x-data="quizManager" x-init="init" class="max-w-4xl mx-auto px-6 py-10 space-y-6">

        <!-- Page Title -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">🧪 Manage Tests</h1>

        <!-- Create New Test -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow flex items-center space-x-4">
            <input
                type="text"
                x-model="newTestTitle"
                placeholder="Enter new test title..."
                class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded focus:outline-none focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-white"
            >
            <button
                @click="createTest"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded transition"
            >
                + Add Test
            </button>
        </div>

        <!-- Test List -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow divide-y divide-gray-200 dark:divide-gray-700">
            <template x-if="tests.length === 0">
                <p class="text-gray-500 dark:text-gray-400">No tests found. Start by adding one above.</p>
            </template>

            <template x-for="test in tests" :key="test.id">
                <div class="py-3 flex justify-between items-center">
                    <span class="text-lg font-medium text-gray-800 dark:text-white" x-text="test.title"></span>
                    <a
                        :href="`/admin/tests/${test.id}/questions`"
                        class="text-blue-600 hover:underline text-sm"
                    >
                        Manage Questions →
                    </a>
                </div>
            </template>
        </div>
    </div>
    <script>
        window.testsFromServer = @json($tests);
    </script>
    
</x-app-layout>
