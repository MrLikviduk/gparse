<?php

use Illuminate\Database\Seeder;
use App\{Type, Group, User};
use \Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::insert([
            [
                'title' => 'Memes'
            ],
            [
                'title' => 'Music'
            ],
            [
                'title' => 'Music pictures'
            ],
            [
                'title' => 'Saves'
            ]
        ]);

        $types = collect();
        foreach (Type::all() as $type)
            $types[$type->title] = $type->id;

        Group::insert([
            [
                'id_vk' => 66678575, // Овсянка, сэр!
                'type_id' => $types['Memes']
            ],
            [
                'id_vk' => 45745333, // 4ch
                'type_id' => $types['Memes']
            ],
            [
                'id_vk' => 73598440, // ЩЕБЕСТАН
                'type_id' => $types['Memes']
            ],
            [
                'id_vk' => 36018360, // Русская Музыка
                'type_id' => $types['Music']
            ],
            [
                'id_vk' => 34384434, // Музыка
                'type_id' => $types['Music']
            ],
            [
                'id_vk' => 35983383, // Популярная музыка
                'type_id' => $types['Music']
            ],
            [
                'id_vk' => 48713061, // Музыка 2019,
                'type_id' => $types['Music']
            ],
            [
                'id_vk' => 43335937, // Новая музыка 2019 & Лучшая музыка
                'type_id' => $types['Music pictures']
            ],
            [
                'id_vk' => 127176539, // Never been | Сохры
                'type_id' => $types['Saves']
            ],
            [
                'id_vk' => 137161186, // сохры
                'type_id' => $types['Saves']
            ]
        ]);

        for ($i = 0; $i < 20; $i++) {
            try {
                $data = json_decode(file_get_contents('https://uinames.com/api/?region=united+states&ext'));
            } catch (Throwable $e) {
                $data = json_encode([
                    'name' => 'John',
                    'email' => Str::random(10) . '@gmail.com'
                ]);
            }
            $user = User::create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make('password123')
            ]);
            $user->assignRole('user');
        }
    }
}
