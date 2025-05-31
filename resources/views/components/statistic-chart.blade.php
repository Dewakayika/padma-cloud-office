<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Statistic Project {{ $year ?? date('Y') }}</h3>
        {{-- Placeholder for Year Selection --}}
        {{-- <select class="border rounded p-1 text-sm">
            <option value="2025">2025</option>
            <option value="2024">2024</option>
        </select> --}}
    </div>
    <div id="project-statistic-chart" class="w-full h-64 flex items-center justify-center text-gray-500">
        {{-- Chart will be rendered here using a JS library --}}
        <p>Project statistic chart goes here (requires a JS charting library)</p>
    </div>
</div>