<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::table('pay_status')->insert([
            ['pay_descr' => 'Ожидает оплаты'],
            ['pay_descr' => 'Оплачен'],
            ['pay_descr' => 'Отказ покупателя']
        ]);

        DB::table('block_reasons')->insert([
            ['block_descr' => 'Администратор'],
            ['block_descr' => 'Неприемлемое содержание'],
            ['block_descr' => 'Определен победитель'],
            ['block_descr' => 'Завершено время'],
            ['block_descr' => 'Ошибка в данных лота'],
        ]);

        DB::table('roles')->insert([
            ['title' => 'Администратор', 'slug' => 'admin'],
            ['title' => 'Пользователь', 'slug' => 'user']
        ]);        

        DB::table('categories')->insert([
            ['name_cat' => 'Все лоты']
        ]);    

        DB::table('users')->insert([
            ['username' => 'admin',
            'email' => 'a432974@yandex.ru',
            'password' => bcrypt('admin'),
            'firstname' => 'Админко',
            'surname' => 'Админов',
            'role_id' => 1,
            'valid' => true,
            'confirmed' => true],

            ['username' => 'user',
            'email' => 'fake@yandex.ru',
            'password' => bcrypt('user'),
            'firstname' => 'Юзер',
            'surname' => 'Пользователев',
            'role_id' => 2,
            'valid' => true,
            'confirmed' => true]
        ]);

        DB::table('lots')->insert([
            ['lot_name' => 'Блокнот админа с секретными паролями',
            'description' => 'Честно спионеренный блокнот админа с секретными паролями lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum. Первый фейковый лот.',
            'images' => '002.jpg;003.jpg',
            'category_id' => 1,
            'start_price' => 1000,
            'owner_id' => 2,
            'begin_auction' => Carbon\Carbon::now(),
            'end_auction' => Carbon\Carbon::now()
            ],

            ['lot_name' => 'Кепка админа для секретных дум',
            'description' => 'Волны катятся одна за другою С плеском и шумом глухим; Люди проходят ничтожной толпою Также один за другим.',
            'images' => '005.jpg',
            'category_id' => 1,
            'start_price' => 2000,
            'owner_id' => 1,
            'begin_auction' => Carbon\Carbon::now(),
            'end_auction' => Carbon\Carbon::now()
            ],

            ['lot_name' => 'Штаны админа для администрирования',
            'description' => 'Мужчин не красят дорогие куртки, Бирюльки и машины класса Е. Мужчину красят лишь его поступки, А уваженье к женщине — вдвойне!',
            'images' => '008.jpg;009.jpg',
            'category_id' => 1,
            'start_price' => 5433,
            'owner_id' => 1,
            'begin_auction' => Carbon\Carbon::now(),
            'end_auction' => Carbon\Carbon::now()
            ],

            ['lot_name' => 'Ручка админа',
            'description' => 'В грозы, в бури, в житейскую стынь, при тяжелых утратах и когда тебе грустно, казаться улыбчивым и простым самое высшее в мире искусство.',
            'images' => '015.jpg;016.jpg;019.jpg',
            'category_id' => 1,
            'start_price' => 230,
            'owner_id' => 2,
            'begin_auction' => Carbon\Carbon::now(),
            'end_auction' => Carbon\Carbon::now()
            ],
            
            ['lot_name' => 'Флэшка Пресли Э.',
            'description' => 'В пустом, сквозном чертоге сада Иду, шумя сухой листвой: Какая странная отрада Былое попирать ногой! Какая сладость все, что прежде Ценил так мало, вспоминать! Какая боль и грусть — в надежде Еще одну весну узнать!',
            'images' => '023.jpg;028.jpg',
            'category_id' => 1,
            'start_price' => 231,
            'owner_id' => 1,
            'begin_auction' => Carbon\Carbon::now(),
            'end_auction' => Carbon\Carbon::now()
            ]
        ]);       
    }
}
