@extends('layouts.page')

@section('content')
    <div class="container py-6 px-3 mx-auto">
        <div class="flex justify-end mb-6">
            <button class="flex items-center px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Download Statement
            </button>
        </div>
        
        <!-- Balance Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Available Balance Card -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-sm text-gray-500 mb-1">Available Balance</h3>
                <div class="text-3xl font-bold text-gray-900 mb-2">$4,285.00</div>
                <div class="flex items-center text-sm text-green-600 mb-4">
                    <span class="font-medium">+$1,200</span>
                    <span class="ml-1 text-gray-500">this month</span>
                </div>
                <div class="flex gap-2">
                    <button class="flex items-center px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        Withdraw
                    </button>
                    <button class="flex items-center px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Payment Method
                    </button>
                </div>
            </div>

            <!-- Pending Payments Card -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-sm text-gray-500 mb-1">Pending Payments</h3>
                <div class="text-3xl font-bold text-gray-900 mb-2">$1,850.00</div>
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    3 payments pending
                </div>
                <button class="w-full px-4 py-2 text-sm text-white bg-purple-600 rounded-lg hover:bg-purple-700 transition-colors">
                    View Details
                </button>
            </div>

            <!-- Total Earned Card -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-sm text-gray-500 mb-1">Total Earned</h3>
                <div class="text-3xl font-bold text-gray-900 mb-2">$32,640.00</div>
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    Since January 2025
                </div>
                <button class="w-full px-4 py-2 text-sm text-white bg-purple-600 rounded-lg hover:bg-purple-700 transition-colors">
                    View Analytics
                </button>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-6" x-data="{ activeTab: 'transactions' }">
            <div class="flex space-x-1 border-b">
                <button @click="activeTab = 'transactions'" 
                    :class="{'text-gray-900 border-b-2 border-purple-500': activeTab === 'transactions',
                            'text-gray-500 hover:text-gray-700': activeTab !== 'transactions'}"
                    class="px-4 py-2 text-sm font-medium">
                    Transactions
                </button>
                <button @click="activeTab = 'payment-methods'"
                    :class="{'text-gray-900 border-b-2 border-purple-500': activeTab === 'payment-methods',
                            'text-gray-500 hover:text-gray-700': activeTab !== 'payment-methods'}"
                    class="px-4 py-2 text-sm font-medium">
                    Payment Methods
                </button>
                <button @click="activeTab = 'invoices'"
                    :class="{'text-gray-900 border-b-2 border-purple-500': activeTab === 'invoices',
                            'text-gray-500 hover:text-gray-700': activeTab !== 'invoices'}"
                    class="px-4 py-2 text-sm font-medium">
                    Invoices
                </button>
            </div>

            <!-- Tab Contents -->
            <div class="mt-6">
                <!-- Payment Methods Tab -->
                <div x-show="activeTab === 'payment-methods'" class="space-y-4">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-medium text-gray-900">Payment Methods</h2>
                        <p class="text-sm text-gray-500">Manage your payment methods and withdrawal options</p>
                    </div>

                    <!-- Bank Account -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Bank Account <span class="text-xs text-purple-600 font-medium bg-purple-100 px-2.5 py-0.5 rounded-full">Default</span></p>
                                <p class="text-sm text-gray-500">Tokyo Bank •••• 2783</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            
                            <button class="text-sm text-gray-500 hover:text-gray-700">Edit</button>
                            <button class="text-sm text-gray-500 hover:text-gray-700">Remove</button>
                        </div>
                    </div>

                    <!-- PayPal -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.5 9.5c0 2.485-2.015 4.5-4.5 4.5S8.5 11.985 8.5 9.5 10.515 5 13 5s4.5 2.015 4.5 4.5zM13 15c3.59 0 6.5-2.91 6.5-6.5S16.59 2 13 2 6.5 4.91 6.5 8.5 9.41 15 13 15z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">PayPal</p>
                                <p class="text-sm text-gray-500">yuki.tanaka@example.com</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button class="text-sm text-gray-500 hover:text-gray-700">Edit</button>
                            <button class="text-sm text-gray-500 hover:text-gray-700">Remove</button>
                        </div>
                    </div>

                    <!-- Add New Payment Method Button -->
                    <button class="w-full flex items-center justify-center px-4 py-4 border-2 border-dashed border-gray-300 rounded-lg text-sm font-medium text-purple-600 hover:border-purple-500 hover:bg-purple-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New Payment Method
                    </button>
                </div>

                <!-- Transactions Tab -->
                <div x-show="activeTab === 'transactions'" class="space-y-4">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Recent Transactions</h2>
                            <p class="text-sm text-gray-500">Your transaction history for the past 30 days</p>
                        </div>
                        <div class="relative">
                            <button class="flex items-center px-4 py-2 text-sm text-gray-600 bg-white rounded-lg border border-gray-200 hover:bg-gray-50">
                                All Transactions
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Transaction List -->
                    <div class="space-y-4">
                        <!-- Payment Received -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-100">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-500 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Payment for Character Design</h3>
                                    <p class="text-sm text-gray-500">May 15, 2025</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-green-600">+$850.00</p>
                                <p class="text-sm text-gray-500">Manga Masters</p>
                            </div>
                        </div>

                        <!-- Payment Received -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-100">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-500 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Payment for Background Art</h3>
                                    <p class="text-sm text-gray-500">May 10, 2025</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-green-600">+$720.00</p>
                                <p class="text-sm text-gray-500">Anime Artisans</p>
                            </div>
                        </div>

                        <!-- Withdrawal -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-100">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Withdrawal to Bank Account</h3>
                                    <p class="text-sm text-gray-500">May 5, 2025</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">-$1,500.00</p>
                            </div>
                        </div>

                        <!-- Payment Received -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-100">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-500 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Payment for Storyboard</h3>
                                    <p class="text-sm text-gray-500">May 1, 2025</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-green-600">+$950.00</p>
                                <p class="text-sm text-gray-500">Creative Comics</p>
                            </div>
                        </div>

                        <!-- Bonus Payment -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-100">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-500 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7l4-4m0 0l4 4m-4-4v18" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Bonus Payment</h3>
                                    <p class="text-sm text-gray-500">April 28, 2025</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-green-600">+$300.00</p>
                                <p class="text-sm text-gray-500">Digital Dreams</p>
                            </div>
                        </div>

                        <!-- View All Button -->
                        <button class="w-full py-3 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 transition-colors">
                            View All Transactions
                        </button>
                    </div>
                </div>

                <!-- Invoices Tab -->
                <div x-show="activeTab === 'invoices'" class="space-y-4">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Invoices</h2>
                            <p class="text-sm text-gray-500">View and download your invoices</p>
                        </div>
                    </div>

                    <!-- Invoice List -->
                    <div class="space-y-4">
                        <!-- Invoice Item -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Character Design for Mystic Warriors</h3>
                                    <p class="text-sm text-gray-500">Invoice #INV-2025-042</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-6">
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">$850.00</p>
                                    <p class="text-sm text-gray-500">May 15, 2025</p>
                                </div>
                                <button class="p-2 text-gray-500 hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Invoice Item -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Background Art for Episode 5</h3>
                                    <p class="text-sm text-gray-500">Invoice #INV-2025-039</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-6">
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">$720.00</p>
                                    <p class="text-sm text-gray-500">May 10, 2025</p>
                                </div>
                                <button class="p-2 text-gray-500 hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Invoice Item -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Storyboard for Chapter 8</h3>
                                    <p class="text-sm text-gray-500">Invoice #INV-2025-036</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-6">
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">$950.00</p>
                                    <p class="text-sm text-gray-500">May 1, 2025</p>
                                </div>
                                <button class="p-2 text-gray-500 hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Invoice Item -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Character Expressions Sheet</h3>
                                    <p class="text-sm text-gray-500">Invoice #INV-2025-033</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-6">
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">$450.00</p>
                                    <p class="text-sm text-gray-500">April 28, 2025</p>
                                </div>
                                <button class="p-2 text-gray-500 hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- View All Button -->
                        <button class="w-full py-3 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 transition-colors">
                            View All Invoices
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('tabs', () => ({
            activeTab: 'transactions'
        }))
    })
</script>
@endpush
