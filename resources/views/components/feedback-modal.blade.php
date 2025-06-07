@props(['project', 'role', 'feedbackExists' => false])

@if(!$feedbackExists && $project->status === 'done')
<div x-data="{ open: true }" x-show="open" class="fixed inset-0 z-[9999] flex justify-center items-center" style="display: none;">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-30 transition-opacity z-[9998]" @click="open = false"></div>
    <div class="relative w-full max-w-lg bg-white rounded-xl shadow-2xl z-[10000] p-8">
        <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl focus:outline-none z-[10001]">&times;</button>
        <h2 class="text-xl font-bold mb-4">{{ $role === 'company' ? 'Give Feedback to Talent' : 'Give Feedback & Rate Project' }}</h2>
        <form method="POST" action="{{ $role === 'company' ? route('company.project.feedback', $project) : route('talent.project.feedback', $project) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Feedback</label>
                <textarea name="feedback_text" rows="4" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"></textarea>
            </div>
            @if($role === 'talent')
            <div class="mb-4" x-data="{ rating: 0 }">
                <label class="block text-gray-700 font-semibold mb-2">Project Rating</label>
                <div class="flex space-x-2">
                    <template x-for="i in 5" :key="i">
                        <svg @click="rating = i" :class="rating >= i ? 'text-yellow-400' : 'text-gray-300'" class="w-8 h-8 cursor-pointer transition-colors duration-150" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </template>
                </div>
                <input type="hidden" name="project_rate" x-model="rating" required>
            </div>
            @endif
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit Feedback</button>
            </div>
        </form>
    </div>
</div>
@endif
