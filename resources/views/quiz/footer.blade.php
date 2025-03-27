<footer class="bg-black text-white p-4 flex justify-between  items-center text-lg">
    <!-- ✅ Left Side (Settings, Options, Help) -->
    <div class="flex space-x-4">
        <!-- ⚙ Settings -->
        <button @click="showPopup = true"
            class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center space-x-2 hover:bg-green-600">
            ⚙ <span></span>
        </button>
        <!-- 🔲 Grid Option -->
        <button 
        @click="showFilterPopup = true "
        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
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