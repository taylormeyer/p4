<?php

use Illuminate\Database\Seeder;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$seedInsertArray = [
    		[
    			"name" => "Country Chicken Salad",
    			"description" => "Tender morsels of bell & evans chicken combined with celery, walnuts, dried cherries and a light flavorful dressing",
    			"price" => 3.99,
    			"unit" => "per quart",
    		],
    		[
    			"name" => "Kale Salad",
    			"description" => "Curly kale with finely shaved vidalia onion and toasted walunt, dressed in a light citrus vinagrette",
    			"price" => 3.99,
    			"unit" => "per quart",
    		],
    		[
    			"name" => "Potato Knish",
    			"description" => "Garlucky mashed-potatoes in tender, golden crust",
    			"price" => 1.25,
    			"unit" => "each",
    		],
    		[
    			"name" => "Assorted Cookies",
    			"description" => "A tempting assortment of homemade chocolate chunk, peanut butter, sugar, and ginger snaps. One pound serves about 12 people",
    			"price" => 6.99,
    			"unit" => "per pound",
    		],
    		[
    			"name" => "Sandwich Platter",
    			"description" => "An assortment of sandwiches on lggy baguettes or fresh foccacia. Selection includes mozzarella panini, roast beef, brie & pear, turkey with havrarti, chicken salad and tuna salad. Minimum order: 10",
    			"price" => 5.99,
    			"unit" => "per person",
    		],
    	];
    	
    	DB::table('menu_items')->insert($seedInsertArray);
    }
}
