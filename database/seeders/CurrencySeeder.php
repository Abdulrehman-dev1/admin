<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code'=>'AED','symbol'=>'د.إ','name'=>'UAE Dirham','decimals'=>2,'position'=>'right','enabled'=>true,'manual_rate_to_aed'=>1],
            ['code'=>'PKR','symbol'=>'₨','name'=>'Pakistani Rupee','decimals'=>0,'position'=>'left','enabled'=>true,'manual_rate_to_aed'=>75.00],
            ['code'=>'USD','symbol'=>'$','name'=>'US Dollar','decimals'=>2,'position'=>'left','enabled'=>true,'manual_rate_to_aed'=>0.272294],
            ['code'=>'EUR','symbol'=>'€','name'=>'Euro','decimals'=>2,'position'=>'left','enabled'=>false,'manual_rate_to_aed'=>0.25],
        ];
        foreach ($rows as $r) {
            Currency::updateOrCreate(['code'=>$r['code']], $r);
        }
    }
}
