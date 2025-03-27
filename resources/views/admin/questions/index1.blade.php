<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">🧠 Question Bank</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Manage all quiz questions and their answers.</p>
            </div>
            <a href="{{ route('admin.questions.create') }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-green-700 transition">
                ➕ Add Question
            </a>
        </div>

        {{-- Table --}}
        <div
            class="overflow-x-auto bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                            #</th>
                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                            Question</th>
                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                            Test</th>
                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                            Answers</th>
                        <th
                            class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($questions as $question)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $question->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">
                                {{ $question->question_text }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-100">
                                {{ $question->test->title ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-100">
                                <ul class="space-y-1">
                                    @foreach ($question->answers as $ans)
                                        <li>
                                            {{ $ans->answer_text }}
                                            @if ($ans->is_correct)
                                                <span
                                                    class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                    ✔ Correct
                                                </span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 text-sm text-right whitespace-nowrap space-x-2">
                                <a href="{{ route('admin.questions.edit', $question->id) }}"
                                    class="inline-block text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form method="POST" action="{{ route('admin.questions.destroy', $question->id) }}"
                                    class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this question?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                No questions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $questions->links() }}
        </div>
    </div>
</x-app-layout>
