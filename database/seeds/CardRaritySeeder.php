<?php

use Illuminate\Database\Seeder;
use App\CardRarity;

class CardRaritySeeder extends Seeder
{
    protected $rarity;
    public function __construct(CardRarity $rarity)
    {
        $this->rarity = $rarity;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->rarity->create([
            'name' => 'Common',
            'max_level' => 13,
        ]);

        $this->rarity->create([
            'name' => 'Rare',
            'max_level' => 11,
        ]);

        $this->rarity->create([
            'name' => 'Epic',
            'max_level' => 8,
        ]);

        $this->rarity->create([
            'name' => 'Legendary',
            'max_level' => 5,
        ]);
    }
}
