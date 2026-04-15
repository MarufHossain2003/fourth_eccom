<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Generate and display XML sitemap
     */
    public function sitemap()
    {
        $sitemap = Sitemap::create();

        // Add homepage
        $sitemap->add(Url::create(route('home'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(1.0));

        // Add shop page
        $sitemap->add(Url::create(route('shop'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.9));

        // Add static pages
        $staticPages = [
            route('return-process') => 0.7,
            route('checkout') => 0.5,
        ];

        foreach ($staticPages as $url => $priority) {
            $sitemap->add(Url::create($url)
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority($priority));
        }

        // Add products
        Product::whereNotNull('slug')->each(function (Product $product) use ($sitemap) {
            $sitemap->add(Url::create(route('product.details', $product->slug))
                ->setLastModificationDate($product->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8));
        });

        // Add categories
        Category::whereNotNull('slug')->each(function (Category $category) use ($sitemap) {
            $sitemap->add(Url::create(route('category.products', $category->slug))
                ->setLastModificationDate($category->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.7));
        });

        // Add sub-categories
        SubCategory::whereNotNull('slug')->each(function (SubCategory $subCategory) use ($sitemap) {
            $sitemap->add(Url::create(route('subcategory.products', $subCategory->slug))
                ->setLastModificationDate($subCategory->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.6));
        });

        return response($sitemap->render(), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    /**
     * Generate and display robots.txt
     */
    public function robots()
    {
        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n\n";
        $robots .= "Disallow: /admin\n";
        $robots .= "Disallow: /api/\n";
        $robots .= "Disallow: */admin/*\n";
        $robots .= "Disallow: */api/*\n\n";
        $robots .= "# Delay for aggressive crawlers\n";
        $robots .= "User-agent: AhrefsBot\n";
        $robots .= "Disallow: /\n\n";
        $robots .= "User-agent: SemrushBot\n";
        $robots .= "Disallow: /\n\n";
        $robots .= "# Sitemap\n";
        $robots .= "Sitemap: " . route('sitemap.xml') . "\n";

        return response($robots, 200, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
