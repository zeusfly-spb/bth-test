<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected static array $categories = [
        'Электроника' => 'Смартфоны, ноутбуки, планшеты и другая техника',
        'Одежда и обувь' => 'Мужская, женская и детская одежда, обувь, аксессуары',
        'Дом и сад' => 'Мебель, инструменты, растения, товары для дома',
        'Спорт и отдых' => 'Спортивный инвентарь, туризм, фитнес',
        'Книги' => 'Художественная литература, учебники, комиксы',
        'Детские товары' => 'Игрушки, коляски, питание, одежда для детей',
        'Автотовары' => 'Запчасти, аксессуары, автохимия',
        'Продукты питания' => 'Бакалея, напитки, сладости, полуфабрикаты',
        'Косметика и парфюмерия' => 'Уход за лицом и телом, духи, декоративная косметика',
        'Зоотовары' => 'Корм, аксессуары, игрушки для животных',
        'Строительство и ремонт' => 'Инструменты, отделочные материалы, сантехника',
        'Медицина и здоровье' => 'Лекарства, медтехника, товары для здоровья',
    ];
    
    public function definition(): array
    {
        $name = $this->faker->randomKey(self::$categories);
        $description = self::$categories[$name];
        
        return [
            'name' => $name,
            'description' => $description,
        ];
    }
}
