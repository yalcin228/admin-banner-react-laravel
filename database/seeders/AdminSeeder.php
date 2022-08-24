<?php

namespace Database\Seeders;

use App\Enum\OutsideEnum;
use App\Enum\StatusEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            [
                'name' => 'Aga',
                'username' => 'agha',
                'email' => 'aga@apa.az',
                'password' => bcrypt('admin'),
                'phone' => '0777777777',
                'status' => StatusEnum::ACTIVE,
                'is_outside' => OutsideEnum::DEACTIVE,
            ],
            [
                'name' => 'Yalcin',
                'username' => 'yalcin',
                'email' => 'yalcin@apa.az',
                'password' => bcrypt('admin'),
                'phone' => '0555555555',
                'status' => StatusEnum::ACTIVE,
                'is_outside' => OutsideEnum::DEACTIVE,
            ],
            [
                'name' => 'Ferhad',
                'username' => 'ferhad',
                'email' => 'ferhad@apa.az',
                'password' => bcrypt('admin'),
                'phone' => '0500505050',
                'status' => StatusEnum::ACTIVE,
                'is_outside' => OutsideEnum::DEACTIVE,
            ]
        ];

        if (! User::count()){
            foreach ($array as $item){
                User::create($item);
            }
        }
    }
}
