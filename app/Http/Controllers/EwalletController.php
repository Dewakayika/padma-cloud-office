<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EwalletController extends Controller
{
    public function eWallet()
    {
        $user = auth()->user();
        $company = \App\Models\Company::where('user_id', $user->id)->first();
        $currency = $company ? $company->currency : 'USD';

        // Dummy billing requests
        $billingRequests = [
            [
                'id' => 1,
                'talent_name' => 'Alice',
                'amount' => 100,
                'currency' => 'USD',
                'status' => 'pending',
                'created_at' => now()->subDays(2),
            ],
            [
                'id' => 2,
                'talent_name' => 'Bob',
                'amount' => 200,
                'currency' => 'USD',
                'status' => 'paid',
                'created_at' => now()->subDays(5),
            ],
            [
                'id' => 3,
                'talent_name' => 'Charlie',
                'amount' => 150,
                'currency' => 'USD',
                'status' => 'pending',
                'created_at' => now()->subDays(1),
            ],
            [
                'id' => 4,
                'talent_name' => 'Diana',
                'amount' => 300,
                'currency' => 'USD',
                'status' => 'paid',
                'created_at' => now()->subDays(10),
            ],
        ];

        // Convert all billing amounts to company currency
        foreach ($billingRequests as &$req) {
            $req['converted_amount'] = \App\Services\CurrencyConverter::convert($req['amount'], $req['currency'], $currency);
            $req['converted_currency'] = $currency;
        }
        unset($req);

        $pendingRequests = array_filter($billingRequests, fn($r) => $r['status'] === 'pending');
        $paidRequests = array_filter($billingRequests, fn($r) => $r['status'] === 'paid');
        $totalSpend = array_sum(array_map(fn($r) => $r['status'] === 'paid' ? $r['converted_amount'] : 0, $billingRequests));

        return view('users.Company.e-wallet', [
            'company' => $company,
            'currency' => $currency,
            'pendingRequests' => $pendingRequests,
            'paidRequests' => $paidRequests,
            'totalSpend' => $totalSpend,
            'billingRequests' => $billingRequests,
        ]);
    }
}
