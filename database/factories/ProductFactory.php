<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected static array $productsByCategory = [
        'Электроника' => [
            ['name' => 'Смартфон Xiaomi Note 12', 'description' => '6.5" экран, 128GB, камера 50MP'],
            ['name' => 'Ноутбук Lenovo IdeaPad 3', 'description' => '15.6", Ryzen 5, 8GB RAM, 256GB SSD'],
            ['name' => 'Наушники Sony WH-1000XM5', 'description' => 'Беспроводные, шумоподавление'],
            ['name' => 'Телевизор Samsung 55"', 'description' => '4K UHD, Smart TV, HDR'],
            ['name' => 'Планшет Huawei MatePad', 'description' => '10.4", 64GB, поддержка стилуса'],
            ['name' => 'Смарт-часы Apple Watch SE', 'description' => 'GPS, фитнес-трекер, уведомления'],
            ['name' => 'Клавиатура Logitech MX Keys', 'description' => 'Беспроводная, подсветка'],
            ['name' => 'Мышь Razer DeathAdder', 'description' => 'Игровая, 20000 DPI'],
        ],
        'Одежда и обувь' => [
            ['name' => 'Футболка хлопковая', 'description' => '100% хлопок, разные размеры и цвета'],
            ['name' => 'Джинсы мужские классические', 'description' => 'Синий, 100% хлопок, 5 карманов'],
            ['name' => 'Куртка зимняя пуховик', 'description' => 'Водоотталкивающая, с капюшоном'],
            ['name' => 'Платье женское летнее', 'description' => 'Легкое, дышащее, яркие принты'],
            ['name' => 'Кроссовки Nike Air', 'description' => 'Спортивные, амортизация'],
            ['name' => 'Свитер шерстяной', 'description' => 'Теплый, мягкий, разных цветов'],
            ['name' => 'Шапка зимняя вязаная', 'description' => 'С помпоном, теплая подкладка'],
            ['name' => 'Ремень кожаный', 'description' => 'Натуральная кожа, стальная пряжка'],
        ],
        'Дом и сад' => [
            ['name' => 'Диван угловой', 'description' => 'Велор, механизм еврокнижка'],
            ['name' => 'Стол обеденный', 'description' => 'Деревянный, 120 см, 6 персон'],
            ['name' => 'Набор кастрюль Tefal', 'description' => '6 предметов, антипригарное покрытие'],
            ['name' => 'Пылесос робот Xiaomi', 'description' => 'Картографирование, влажная уборка'],
            ['name' => 'Лопата садовая', 'description' => 'Нержавейка, черенок деревянный'],
            ['name' => 'Горшок для цветов', 'description' => 'Керамический, диаметр 20 см'],
            ['name' => 'Постельное белье сатин', 'description' => '2-спальное, гипоаллергенно'],
            ['name' => 'Стул офисный', 'description' => 'Регулируемый, сетчатая спинка'],
        ],
        'Спорт и отдых' => [
            ['name' => 'Беговая дорожка', 'description' => 'Электрическая, 12 программ'],
            ['name' => 'Гантели разборные', 'description' => '20 кг, с блинами'],
            ['name' => 'Велосипед горный', 'description' => '26", 21 скорость, амортизация'],
            ['name' => 'Мяч футбольный', 'description' => '5 размер, камера латекс'],
            ['name' => 'Коврик для йоги', 'description' => 'Толщина 6 мм, нескользящий'],
            ['name' => 'Фитнес-браслет Honor', 'description' => 'Пульсометр, шагомер, сон'],
            ['name' => 'Лыжи горные', 'description' => '170 см, с креплениями'],
            ['name' => 'Турник настенный', 'description' => 'Три хвата, нагрузка 150 кг'],
        ],
        'Книги' => [
            ['name' => 'Преступление и наказание', 'description' => 'Ф.М. Достоевский, классика'],
            ['name' => 'Мастер и Маргарита', 'description' => 'М.А. Булгаков, бестселлер'],
            ['name' => '1984', 'description' => 'Джордж Оруэлл, антиутопия'],
            ['name' => 'Война и мир (2 тома)', 'description' => 'Л.Н. Толстой, эпопея'],
            ['name' => 'Гарри Поттер и философский камень', 'description' => 'Дж.К. Роулинг, фэнтези'],
            ['name' => 'Атлант расправил плечи', 'description' => 'Айн Рэнд, философский роман'],
            ['name' => 'Три товарища', 'description' => 'Эрих Мария Ремарк'],
            ['name' => 'Код Да Винчи', 'description' => 'Дэн Браун, детектив'],
        ],
        'Автотовары' => [
            ['name' => 'Моторное масло Shell 5W-40', 'description' => '4 литра, синтетика'],
            ['name' => 'Зимние шины Michelin', 'description' => '4 шт, R16, с шипами'],
            ['name' => 'Видеорегистратор 2 канала', 'description' => 'Full HD, ночная съемка'],
            ['name' => 'Аккумулятор Varta 60Ah', 'description' => 'Standby, пусковой ток 540A'],
            ['name' => 'Коврики в салон', 'description' => 'Резина, 3D, под конкретную модель'],
            ['name' => 'Набор инструментов авто', 'description' => '18 предметов, ключи, отвертки'],
            ['name' => 'Автомобильное зарядное', 'description' => 'USB-C, 2 порта, быстрая зарядка'],
            ['name' => 'Щетки стеклоочистителя', 'description' => 'Каркасные, 60 см комплект'],
        ],
        'Детские товары' => [
            ['name' => 'Коляска прогулочная', 'description' => 'Легкая, алюминий, капюшон'],
            ['name' => 'Детское автокресло', 'description' => 'Группа 0+/1, изофикс'],
            ['name' => 'Конструктор LEGO City', 'description' => 'Количество деталей 200-500'],
            ['name' => 'Развивающий коврик', 'description' => 'Музыкальный, световой эффекты'],
            ['name' => 'Детские санки', 'description' => 'Металлические, со спинкой'],
            ['name' => 'Набор для творчества', 'description' => 'Краски, кисти, бумага, пластилин'],
            ['name' => 'Пеленки для новорожденных', 'description' => 'Фланелевые, 5 штук в упаковке'],
            ['name' => 'Детская кроватка', 'description' => 'С маятником, бортиками'],
        ],
        'Косметика и парфюмерия' => [
            ['name' => 'Парфюм Chanel No.5', 'description' => '50 мл, женский, цветочный аромат'],
            ['name' => 'Крем для лица увлажняющий', 'description' => 'Гиалуроновая кислота'],
            ['name' => 'Тушь для ресниц Maybelline', 'description' => 'Объем, черная, водостойкая'],
            ['name' => 'Шампунь против перхоти', 'description' => 'Цинк, мягкое очищение'],
            ['name' => 'Гель для душа мужской', 'description' => 'Аква, морской аромат'],
            ['name' => 'Помада губная матовая', 'description' => 'Насыщенный цвет, стойкая'],
            ['name' => 'Маска для лица тканевая', 'description' => 'Увлажнение, коллаген'],
            ['name' => 'Маникюрный набор', 'description' => 'Ножницы, пилочка, щипчики'],
        ],
        'Зоотовары' => [
            ['name' => 'Корм сухой Purina для кошек', 'description' => '3 кг, для стерилизованных'],
            ['name' => 'Клетка для хомяка', 'description' => 'Двухуровневая, с колесом'],
            ['name' => 'Игрушка для собак мяч', 'description' => 'Резиновый, прыгающий'],
            ['name' => 'Когтеточка для кошек', 'description' => 'Сизалевая, настенная'],
            ['name' => 'Наполнитель древесный', 'description' => '15 литров, прессованный'],
            ['name' => 'Переноска для животных', 'description' => 'Пластиковая, вентиляция'],
            ['name' => 'Шлейка для собак', 'description' => 'Нейлон, регулируемая'],
            ['name' => 'Витамины для кошек', 'description' => 'Таблетки, шерсть и когти'],
        ],
    ];
    
    public function definition(): array
    {
        $category = Category::all()->random();
        
        $product = $this->faker->randomElement(self::$productsByCategory[$category->name]);
        
        return [
            'category_id' => $category->id,
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $this->faker->numberBetween(100, 10000),
          ];
    }
    
    protected function generateRandomProduct(?Category $category = null): array
    {
        return [
            'category_id' => $category?->id ?? Category::factory(),
            'name' => $this->faker->realText(50),
            'description' => $this->faker->realText(200),
            'price' => $this->faker->numberBetween(500, 100000),
        ];
    }
}