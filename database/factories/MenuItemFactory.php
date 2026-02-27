<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */

use App\Models\MenuItem;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Menu items organized by category type with realistic prices
        $menuItemsByCategory = [
            'appetizers' => [
                ['name' => 'Crispy Calamari', 'description' => 'Lightly battered calamari rings served golden and crispy with marinara dipping sauce and lemon wedges.', 'price' => [8, 13]],
                ['name' => 'Bruschetta Trio', 'description' => 'Toasted ciabatta topped with fresh tomato basil, roasted pepper, and olive tapenade.', 'price' => [9, 12]],
                ['name' => 'Chicken Satay Skewers', 'description' => 'Tender marinated chicken skewers grilled to perfection, served with creamy peanut sauce.', 'price' => [10, 14]],
                ['name' => 'Spinach Artichoke Dip', 'description' => 'Creamy blend of spinach, artichoke hearts, and three cheeses served bubbling hot with tortilla chips.', 'price' => [9, 12]],
                ['name' => 'Mozzarella Sticks', 'description' => 'Hand-breaded mozzarella fried until golden and stretchy, paired with our zesty marinara.', 'price' => [7, 10]],
                ['name' => 'Edamame', 'description' => 'Steamed young soybeans tossed with sea salt and a hint of chili flakes.', 'price' => [6, 8]],
                ['name' => 'Shrimp Cocktail', 'description' => 'Chilled jumbo shrimp served with tangy cocktail sauce and fresh lemon.', 'price' => [12, 14]],
                ['name' => 'Loaded Nachos', 'description' => 'Crispy tortilla chips piled high with melted cheese, jalapeños, sour cream, guacamole, and pico de gallo.', 'price' => [10, 14]],
            ],
            'mains' => [
                ['name' => 'Grilled Ribeye Steak', 'description' => 'USDA Choice 12oz ribeye char-grilled to your preference, served with garlic mashed potatoes and seasonal vegetables.', 'price' => [24, 30]],
                ['name' => 'Pan-Seared Salmon', 'description' => 'Atlantic salmon fillet with a crispy skin, drizzled with lemon-dill butter sauce on a bed of wild rice.', 'price' => [20, 26]],
                ['name' => 'Chicken Parmesan', 'description' => 'Breaded chicken breast topped with marinara and melted mozzarella, served over spaghetti.', 'price' => [16, 20]],
                ['name' => 'Spaghetti Carbonara', 'description' => 'Al dente spaghetti tossed with crispy pancetta, egg yolk, Pecorino Romano, and cracked black pepper.', 'price' => [14, 18]],
                ['name' => 'Beef Bulgogi Bowl', 'description' => 'Thinly sliced marinated beef served over steamed rice with kimchi, pickled vegetables, and a fried egg.', 'price' => [16, 22]],
                ['name' => 'Pad Thai', 'description' => 'Stir-fried rice noodles with shrimp, tofu, bean sprouts, and crushed peanuts in a sweet tamarind sauce.', 'price' => [14, 18]],
                ['name' => 'Lamb Shank Tagine', 'description' => 'Slow-braised lamb shank with apricots, almonds, and warm spices served over fluffy couscous.', 'price' => [22, 28]],
                ['name' => 'Fish and Chips', 'description' => 'Beer-battered Atlantic cod fried to a golden crunch, served with thick-cut fries, mushy peas, and tartar sauce.', 'price' => [15, 19]],
                ['name' => 'Butter Chicken', 'description' => 'Tender chicken pieces simmered in a rich, creamy tomato sauce with aromatic spices, served with basmati rice.', 'price' => [15, 20]],
                ['name' => 'BBQ Baby Back Ribs', 'description' => 'Fall-off-the-bone pork ribs slow-smoked for 6 hours and glazed with our house-made bourbon BBQ sauce.', 'price' => [20, 28]],
                ['name' => 'Mushroom Risotto', 'description' => 'Creamy Arborio rice stirred with wild mushrooms, white wine, and finished with truffle oil and Parmesan.', 'price' => [16, 22]],
                ['name' => 'Kung Pao Chicken', 'description' => 'Wok-fired chicken with roasted peanuts, dried chili peppers, and Szechuan peppercorns in a savory-sweet glaze.', 'price' => [14, 18]],
                ['name' => 'Chicken Tikka Masala', 'description' => 'Chargrilled chicken tikka in a velvety spiced tomato and cream sauce, served with garlic naan.', 'price' => [15, 20]],
                ['name' => 'Fettuccine Alfredo', 'description' => 'Silky fettuccine pasta coated in a luxurious Parmesan cream sauce with a touch of nutmeg.', 'price' => [13, 17]],
                ['name' => 'Teriyaki Salmon Bowl', 'description' => 'Glazed salmon fillet over seasoned sushi rice with avocado, edamame, and pickled ginger.', 'price' => [18, 24]],
                ['name' => 'Eggplant Parmesan', 'description' => 'Layers of breaded eggplant, marinara sauce, and melted mozzarella baked until bubbly and golden.', 'price' => [14, 18]],
            ],
            'burgers' => [
                ['name' => 'Classic Cheeseburger', 'description' => 'Juicy half-pound beef patty with aged cheddar, lettuce, tomato, and our secret sauce on a brioche bun.', 'price' => [13, 16]],
                ['name' => 'Smokehouse Bacon Burger', 'description' => 'Char-grilled patty stacked with hickory-smoked bacon, BBQ sauce, crispy onion rings, and pepper jack cheese.', 'price' => [15, 18]],
                ['name' => 'Mushroom Swiss Burger', 'description' => 'Beef patty topped with sautéed mushrooms, melted Swiss cheese, and garlic aioli.', 'price' => [14, 17]],
                ['name' => 'Spicy Jalapeño Burger', 'description' => 'Fire-grilled patty with pepper jack, pickled jalapeños, chipotle mayo, and crispy tortilla strips.', 'price' => [14, 17]],
                ['name' => 'Beyond Plant Burger', 'description' => 'Plant-based patty with avocado, sprouts, vegan cheese, and roasted garlic aioli on a whole wheat bun.', 'price' => [15, 18]],
            ],
            'pizza' => [
                ['name' => 'Margherita Pizza', 'description' => 'San Marzano tomato sauce, fresh mozzarella di bufala, basil leaves, and extra virgin olive oil on our hand-stretched dough.', 'price' => [14, 18]],
                ['name' => 'Pepperoni Pizza', 'description' => 'Loaded with cup-and-char pepperoni, mozzarella, and our signature pizza sauce on a perfectly crispy crust.', 'price' => [15, 19]],
                ['name' => 'BBQ Chicken Pizza', 'description' => 'Smoky BBQ sauce base with grilled chicken, red onion, cilantro, and a blend of gouda and mozzarella.', 'price' => [16, 20]],
                ['name' => 'Quattro Formaggi', 'description' => 'A decadent four-cheese pizza with mozzarella, gorgonzola, fontina, and Parmesan on a garlic butter crust.', 'price' => [16, 20]],
            ],
            'sushi' => [
                ['name' => 'California Roll', 'description' => 'Crab, avocado, and cucumber rolled in seasoned sushi rice and nori, topped with sesame seeds.', 'price' => [10, 14]],
                ['name' => 'Spicy Tuna Roll', 'description' => 'Fresh ahi tuna mixed with spicy mayo and sriracha, rolled with cucumber and topped with tobiko.', 'price' => [12, 16]],
                ['name' => 'Dragon Roll', 'description' => 'Shrimp tempura inside, draped with sliced avocado and eel, finished with unagi sauce and sesame.', 'price' => [15, 19]],
                ['name' => 'Salmon Sashimi', 'description' => 'Eight pieces of premium Norwegian salmon, sliced paper-thin and served with wasabi and pickled ginger.', 'price' => [14, 18]],
                ['name' => 'Rainbow Roll', 'description' => 'California roll topped with an assortment of fresh fish including tuna, salmon, and yellowtail.', 'price' => [16, 20]],
            ],
            'soups' => [
                ['name' => 'Tom Yum Soup', 'description' => 'Aromatic Thai hot and sour soup with shrimp, mushrooms, lemongrass, and kaffir lime leaves.', 'price' => [8, 12]],
                ['name' => 'French Onion Soup', 'description' => 'Slow-caramelized onions in a rich beef broth, topped with a crusty crouton and melted Gruyère cheese.', 'price' => [9, 12]],
                ['name' => 'Pho Bo', 'description' => 'Vietnamese beef noodle soup with 24-hour bone broth, rice noodles, rare beef, and fresh herbs.', 'price' => [12, 16]],
                ['name' => 'Lobster Bisque', 'description' => 'Velvety cream soup with chunks of Maine lobster, a splash of sherry, and a drizzle of truffle oil.', 'price' => [12, 15]],
            ],
            'salads' => [
                ['name' => 'Caesar Salad', 'description' => 'Crisp romaine hearts, shaved Parmesan, house-made croutons, and our creamy anchovy Caesar dressing.', 'price' => [10, 14]],
                ['name' => 'Greek Salad', 'description' => 'Ripe tomatoes, cucumbers, Kalamata olives, red onion, and crumbled feta with oregano vinaigrette.', 'price' => [10, 13]],
                ['name' => 'Cobb Salad', 'description' => 'Rows of grilled chicken, bacon, hard-boiled egg, avocado, blue cheese, and tomato over mixed greens.', 'price' => [13, 16]],
                ['name' => 'Asian Sesame Salad', 'description' => 'Shredded cabbage, edamame, mandarin oranges, crispy wontons, and sesame ginger dressing.', 'price' => [11, 14]],
            ],
            'sides' => [
                ['name' => 'Truffle Parmesan Fries', 'description' => 'Hand-cut fries tossed in truffle oil with grated Parmesan and fresh parsley.', 'price' => [7, 10]],
                ['name' => 'Garlic Bread', 'description' => 'Toasted sourdough slathered with roasted garlic butter and herbs, baked until golden.', 'price' => [5, 7]],
                ['name' => 'Mac and Cheese', 'description' => 'Elbow pasta in a four-cheese sauce with a golden breadcrumb crust, baked to bubbly perfection.', 'price' => [8, 11]],
                ['name' => 'Sweet Potato Fries', 'description' => 'Crispy sweet potato fries lightly seasoned with cinnamon and sea salt, served with chipotle mayo.', 'price' => [6, 9]],
                ['name' => 'Steamed Jasmine Rice', 'description' => 'Fluffy aromatic jasmine rice, perfectly steamed.', 'price' => [3, 5]],
                ['name' => 'Grilled Vegetables', 'description' => 'Seasonal vegetables charred on the grill and drizzled with balsamic reduction and olive oil.', 'price' => [7, 10]],
            ],
            'desserts' => [
                ['name' => 'New York Cheesecake', 'description' => 'Rich and creamy classic cheesecake on a graham cracker crust, topped with fresh strawberry compote.', 'price' => [8, 12]],
                ['name' => 'Molten Chocolate Lava Cake', 'description' => 'Warm dark chocolate cake with a gooey molten center, served with vanilla bean ice cream.', 'price' => [9, 13]],
                ['name' => 'Tiramisu', 'description' => 'Layers of espresso-soaked ladyfingers and mascarpone cream, dusted with cocoa powder.', 'price' => [8, 12]],
                ['name' => 'Mango Sticky Rice', 'description' => 'Sweet glutinous rice with ripe mango slices, drizzled with warm coconut cream.', 'price' => [8, 11]],
                ['name' => 'Crème Brûlée', 'description' => 'Silky vanilla custard with a perfectly torched caramelized sugar crust.', 'price' => [9, 13]],
                ['name' => 'Apple Pie à la Mode', 'description' => 'Warm cinnamon-spiced apple pie with a flaky butter crust, topped with a scoop of vanilla ice cream.', 'price' => [8, 12]],
                ['name' => 'Churros con Chocolate', 'description' => 'Crispy cinnamon-sugar churros served with a rich dark chocolate dipping sauce.', 'price' => [7, 10]],
            ],
            'beverages' => [
                ['name' => 'Fresh Squeezed Lemonade', 'description' => 'House-made lemonade with real lemons and a touch of mint.', 'price' => [4, 6]],
                ['name' => 'Mango Lassi', 'description' => 'Creamy Indian yogurt smoothie blended with Alphonso mango and a hint of cardamom.', 'price' => [5, 7]],
                ['name' => 'Iced Matcha Latte', 'description' => 'Ceremonial-grade matcha whisked with oat milk over ice.', 'price' => [5, 7]],
                ['name' => 'Thai Iced Tea', 'description' => 'Strong brewed Ceylon tea with star anise, sweetened condensed milk, and crushed ice.', 'price' => [4, 6]],
                ['name' => 'Espresso', 'description' => 'Double shot of rich, aromatic espresso pulled from premium single-origin beans.', 'price' => [3, 5]],
                ['name' => 'Sparkling Water', 'description' => 'Chilled sparkling mineral water with a choice of lemon or lime.', 'price' => [3, 4]],
                ['name' => 'Craft Root Beer', 'description' => 'Small-batch root beer brewed with real vanilla and sassafras.', 'price' => [4, 6]],
                ['name' => 'Berry Smoothie', 'description' => 'A refreshing blend of strawberries, blueberries, banana, and Greek yogurt.', 'price' => [6, 8]],
            ],
        ];

        $images = [
            'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400&q=80',
            'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400&q=80',
            'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&q=80',
            'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&q=80',
            'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&q=80',
            'https://images.unsplash.com/photo-1482049016688-2d3e1b311543?w=400&q=80',
            'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?w=400&q=80',
            'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=400&q=80',
            'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=400&q=80',
            'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=400&q=80',
            'https://images.unsplash.com/photo-1484723091739-30a097e8f929?w=400&q=80',
            'https://images.unsplash.com/photo-1432139509613-5c4255a1d197?w=400&q=80',
            'https://images.unsplash.com/photo-1529692236671-f1f6cf9683ba?w=400&q=80',
            'https://images.unsplash.com/photo-1551782450-a2132b4ba21d?w=400&q=80',
            'https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=400&q=80',
            'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&q=80',
        ];

        $allItems = collect($menuItemsByCategory)->flatten(1)->all();
        $item = fake()->randomElement($allItems);

        return [
            'name' => $item['name'],
            'slug' => Str::slug($item['name']) . '-' . fake()->unique()->numberBetween(1, 100000),
            'description' => $item['description'],
            'price' => fake()->randomFloat(2, $item['price'][0], $item['price'][1]),
            'image' => fake()->randomElement($images),
            'is_available' => fake()->boolean(90),
        ];
    }
}
