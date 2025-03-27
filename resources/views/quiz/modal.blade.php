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
        <button class="bg-red-500 px-4 py-2 rounded text-white hover:bg-red-600 mt-4 w-full" @click="showPopup = false">
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
        <button class="bg-red-500 px-4 py-2 rounded text-white hover:bg-red-600 mt-4 w-full" @click="showHelp = false">
            Close
        </button>
    </div>
</div>

<!-- Confirmation Pop-up -->
<div x-show="showEndTestModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
        <h2 class="text-lg font-bold mb-4 text-red-600">Warning!</h2>
        <p class="mb-4 text-gray-700">Are you sure you want to end the quiz? <br> You will not be able to retake it
            later.</p>
        <div class="flex justify-center space-x-4">
            <button @click="showEndTestModal = false"
                class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded">
                Cancel
            </button>
            <button @click="confirmEndQuiz()" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded">
                Confirm
            </button>
        </div>
    </div>
</div>

<!-- ✅ Filter Bar -->
<div x-show="showFilterPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-left">
        <h2 class="text-lg font-bold mb-4 text-gray-700">Filter Questions</h2>

        <div class="space-y-3">
            <label class="flex items-center space-x-2">
                <input type="radio" name="filterType" value="answered" x-model="filter.selected"
                    class="form-radio text-blue-600">
                <span>Answered</span>
            </label>

            <label class="flex items-center space-x-2">
                <input type="radio" name="filterType" value="unanswered" x-model="filter.selected"
                    class="form-radio text-yellow-500">
                <span>Unanswered</span>
            </label>

            <label class="flex items-center space-x-2">
                <input type="radio" name="filterType" value="flagged" x-model="filter.selected"
                    class="form-radio text-red-600">
                <span>Flagged</span>
            </label>

            <label class="flex items-center space-x-2">
                <input type="radio" name="filterType" value="" x-model="filter.selected"
                    class="form-radio text-gray-400">
                <span>Show All</span>
            </label>
        </div>

        <div class="flex justify-end mt-6">
            <button @click="showFilterPopup = false"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Close
            </button>
        </div>
    </div>
</div>

