@extends('layouts.app')
@section('title', 'E-Wallet')
@section('content')

<div class="sm:ml-64">
    <div class="p-4 sm:p-6 space-y-6">
        {{-- Blur overlay and "Under Development" banner --}}
        <div class="fixed inset-0 bg-black/20 backdrop-blur-sm z-40" style="left: 16rem;"></div>
        <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50" style="left: calc(50% + 8rem);">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8 max-w-md mx-4">
                <div class="text-center">
                    <div class="mb-6">
                        <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Coming Soon</h1>
                        <p class="text-gray-600 dark:text-gray-400 text-lg mb-4">This feature is currently being built</p>
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                <strong>What's coming:</strong> Complete e-wallet system with payment processing, billing management, transaction history, and automated payment workflows.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Development in progress...</span>
                    </div>
                </div>
            </div>
        </div>
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
