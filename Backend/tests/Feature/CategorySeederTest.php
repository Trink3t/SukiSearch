<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorySeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_seeds_real_product_categories_idempotently(): void
    {
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);

        $categoryNames = Category::query()->pluck('name');

        $this->assertCount(14, $categoryNames);
        $this->assertContains('Rice and Grains', $categoryNames);
        $this->assertContains('Personal Care', $categoryNames);
        $this->assertContains('School and Office Supplies', $categoryNames);
    }

    public function test_product_factory_uses_a_real_category_without_a_category_factory(): void
    {
        $product = Product::factory()->create();

        $this->assertSame('Others', $product->category->name);
    }
}
