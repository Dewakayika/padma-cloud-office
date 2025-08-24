@props(['project', 'feedbackExists' => false])

@if(!$feedbackExists && $project->status === 'done')
<div x-data="{ open: true }" x-show="open" class="fixed inset-0 z-[9999] flex justify-center items-center" style="display: none;">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-30 transition-opacity z-[9998]" @click="open = false"></div>
    <div class="relative w-full max-w-lg bg-white rounded-xl shadow-2xl z-[10000] p-8">
        <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl focus:outline-none z-[10001]">&times;</button>
        <h2 class="text-xl font-bold mb-4">Give Feedback to Talent</h2>
        <form method="POST" action="{{ route('company.project.feedback', $project) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Feedback</label>
                <textarea name="feedback_text" rows="4" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" placeholder="Share your feedback about the talent's work..."></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" @click="open = false" class="px-4 py-2 text-gray-600 border border-gray-300 rounded hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded">Submit Feedback</button>
            </div>
        </form>
    </div>
</div>
@endif
