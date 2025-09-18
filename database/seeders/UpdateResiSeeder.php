<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use App\Services\ResiService;
use Illuminate\Database\Seeder;

class UpdateResiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update semua transaksi yang sudah dibayar (status = 'paid') dengan resi dummy
        $transactions = Transaksi::where('status', 'paid')->get();

        foreach ($transactions as $transaction) {
            if (!$transaction->resi) {
                $resi = ResiService::generateResiByCourier($transaction->kurir ?? 'JNE');
                $transaction->update(['resi' => $resi]);
            }
        }

        $this->command->info('Updated ' . $transactions->count() . ' transactions with dummy resi numbers.');
    }
}
