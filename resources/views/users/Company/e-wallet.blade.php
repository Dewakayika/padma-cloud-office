@extends('layouts.app')
@section('title', 'E-Wallet')
@section('content')

<div class="sm:ml-64">
    <div class="p-4 sm:p-6 space-y-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Company E-Wallet</h2>

        <!-- Score Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-sm text-gray-500 mb-2">Pending Requests</div>
                <div class="text-2xl font-bold text-yellow-500">{{ count($pendingRequests) }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-sm text-gray-500 mb-2">Success Billing</div>
                <div class="text-2xl font-bold text-green-500">{{ count($paidRequests) }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-sm text-gray-500 mb-2">Total Spend</div>
                <div class="text-2xl font-bold text-blue-600">{{ number_format($totalSpend, 2) }} {{ $currency }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-sm text-gray-500 mb-2">Total Requests</div>
                <div class="text-2xl font-bold text-gray-700 dark:text-gray-200">{{ count($billingRequests) }}</div>
            </div>
        </div>

        <!-- Pending Requests Table -->
        <div class="mb-10">
            <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-white">Pending Requests</h3>
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Talent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Requested At</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($pendingRequests as $req)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $req['talent_name'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($req['amount'], 2) }} {{ $req['currency'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $req['created_at']->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-4 text-center text-gray-400">No pending requests.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Success Billing Table -->
        <div class="mb-10">
            <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-white">Success Billing (Paid)</h3>
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Talent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Paid At</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($paidRequests as $req)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $req['talent_name'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($req['amount'], 2) }} {{ $req['currency'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $req['created_at']->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-4 text-center text-gray-400">No paid billings.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- All Billing Requests Table -->
        <div class="mb-10">
            <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-white">All Billing Requests</h3>
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Talent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Requested At</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($billingRequests as $req)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $req['talent_name'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($req['amount'], 2) }} {{ $req['currency'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($req['status'] === 'paid')
                                        <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded">Paid</span>
                                    @else
                                        <span class="inline-block px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $req['created_at']->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-4 text-center text-gray-400">No billing requests.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
