<?php

use Illuminate\Database\Seeder;
use App\Platform;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $platforms = [
            'TopSport', 'OlyBet'
        ];

        foreach ($platforms as $platform) {
            $p = Platform::firstOrNew(['title' => $platform]);
            $p->save();
        }
    }
}
