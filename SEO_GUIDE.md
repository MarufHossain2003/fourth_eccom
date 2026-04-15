# SEO Implementation Guide

## Overview

This project now has a complete SEO implementation with the following features:

1. **Meta Tags Management** - Automatic management of title, description, keywords, and canonical URLs
2. **Open Graph Tags** - Social media optimization
3. **Structured Data (JSON-LD)** - Rich snippets for search engines
4. **XML Sitemap** - Automatic sitemap generation
5. **Robots.txt** - SEO-friendly robots configuration
6. **SEO Fields** - Database fields for custom SEO metadata on products, categories, and sub-categories

## Features

### 1. SEO Trait (HasSeoTrait)

This trait should be added to your models (Product, Category, SubCategory) to enable SEO functionality.

**Models that have the trait:**
- App\Models\Product
- App\Models\Category
- App\Models\SubCategory

**Available Methods:**
- `getSeoTitle()` - Returns SEO title
- `getSeoDescription()` - Returns meta description
- `getSeoKeywords()` - Returns keywords
- `getCanonicalUrl()` - Returns canonical URL
- `getOgData()` - Returns Open Graph data
- `getStructuredData()` - Returns JSON-LD structured data
- `getOgImage()` - Returns OG image URL
- `getSchemaType()` - Returns schema.org type

### 2. SEO Service

The `SeoService` class manages all SEO functionality.

**Usage in Controllers:**

```php
<?php

namespace App\Http\Controllers;

use App\Services\SeoService;

class ProductController extends Controller
{
    public function show($slug, SeoService $seo)
    {
        $product = Product::whereSlug($slug)->firstOrFail();

        // Method 1: Set manually
        $seo->setTitle($product->name)
            ->setDescription($product->description)
            ->setKeywords($product->seo_keywords);

        // Method 2: Using model data (recommended)
        $seo->fromModel($product);

        return view('product.show', ['product' => $product]);
    }
}
```

### 3. Helper Functions

Several helper functions are available globally:

```php
// Get SEO service instance
seo()->setTitle('My Title');

// Set multiple SEO data at once
seoMeta('Title', 'Description', 'Keywords');

// Render all meta tags in blade
{!! renderMetaTags() !!}

// Render structured data
{!! renderStructuredData() !!}
```

### 4. Database Fields

The following fields have been added to products, categories, and sub_categories tables:

- `seo_title` - Custom SEO title
- `seo_description` - Custom meta description
- `seo_keywords` - Keywords for SEO
- `canonical_url` - Custom canonical URL

**Running Migrations:**

```bash
php artisan migrate
```

### 5. XML Sitemap

Automatically generated at `/sitemap.xml`

**Features:**
- Includes all products, categories, sub-categories
- Shows last modification dates
- Proper priority levels
- Change frequency settings

### 6. Robots.txt

Generated at `/robots.txt`

**Features:**
- Denies access to /admin and /api routes
- Provides sitemap location
- Blocks aggressive crawlers (AhrefsBot, SemrushBot)

## Usage Examples

### Example 1: Product Page Controller

```php
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\SeoService;

class ProductController extends Controller
{
    public function productDetails($slug, SeoService $seo)
    {
        $product = Product::whereSlug($slug)
            ->with(['category', 'subCategory'])
            ->firstOrFail();

        // Set SEO from model
        $seo->fromModel($product);

        // Or customize further
        $seo->setTitle($product->seo_title ?? $product->name)
            ->setDescription($product->seo_description ?? $product->description)
            ->setKeywords($product->seo_keywords)
            ->setCanonicalUrl(route('product.details', $product->slug))
            ->setStructuredData([
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $product->name,
                'description' => $product->description,
                'image' => $product->getOgImage(),
                'priceCurrency' => 'BDT',
                'price' => $product->price,
            ]);

        return view('frontend.product.show', ['product' => $product]);
    }
}
```

### Example 2: Category Page Controller

```php
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\SeoService;

class CategoryController extends Controller
{
    public function categoryProducts($slug, SeoService $seo)
    {
        $category = Category::whereSlug($slug)->firstOrFail();
        $products = $category->product()->paginate(12);

        $seo->fromModel($category);

        return view('frontend.category.products', compact('category', 'products'));
    }
}
```

### Example 3: Custom Meta Tags in Blade

```blade
@push('seo')
    @php
        seo()
            ->setTitle('Custom Title')
            ->setDescription('Custom description for this page')
            ->setCanonicalUrl(url()->current());
    @endphp
@endpush
```

## Meta Tags Generated

The following meta tags are automatically generated:

1. **Title Tag**
   ```html
   <title>Product Name | App Name</title>
   ```

2. **Meta Description**
   ```html
   <meta name="description" content="Your page description">
   ```

3. **Meta Keywords**
   ```html
   <meta name="keywords" content="keyword1, keyword2">
   ```

4. **Canonical URL**
   ```html
   <link rel="canonical" href="https://example.com/page">
   ```

5. **Open Graph Tags**
   ```html
   <meta property="og:title" content="Title">
   <meta property="og:description" content="Description">
   <meta property="og:url" content="URL">
   <meta property="og:image" content="IMAGE_URL">
   <meta property="og:type" content="website">
   ```

6. **Twitter Card**
   ```html
   <meta name="twitter:card" content="summary_large_image">
   <meta name="twitter:title" content="Title">
   <meta name="twitter:description" content="Description">
   ```

## Configuration

SEO configuration can be found in `config/seo.php`. You can customize:

- Site name and description
- Open Graph settings
- Twitter Card settings
- Schema.org organization details
- Robots.txt settings
- Sitemap pagination

## Best Practices

1. **Always set SEO data from models** - Use `$seo->fromModel($product)` for consistency

2. **Keep descriptions under 160 characters** - Ensures they display fully in search results

3. **Use meaningful titles** - Include target keyword and brand name

4. **Update Product SEO Fields** - Fill in seo_title, seo_description, seo_keywords in the product admin panel

5. **Maintain consistent URL structure** - Use slugs for clean, SEO-friendly URLs

6. **Add structured data** - Especially for products with price, availability, etc.

7. **Monitor sitemap** - Ensure all important pages are included

## Routes

```
GET  /sitemap.xml          - XML Sitemap
GET  /robots.txt           - Robots configuration
GET  /                     - Homepage
GET  /shop                 - Shop page
GET  /product-details/{slug}  - Product details
GET  /category-products/{slug} - Category products
GET  /sub-category-products/{slug} - Sub-category products
```

## Admin Panel Integration

To add SEO fields to your admin panel:

1. Add fields to product/category edit forms:
   ```blade
   <div class="form-group">
       <label>SEO Title</label>
       <input type="text" name="seo_title" value="{{ $product->seo_title }}">
   </div>
   
   <div class="form-group">
       <label>SEO Description</label>
       <textarea name="seo_description">{{ $product->seo_description }}</textarea>
   </div>
   
   <div class="form-group">
       <label>SEO Keywords</label>
       <input type="text" name="seo_keywords" value="{{ $product->seo_keywords }}">
   </div>
   ```

2. Update your controllers to save these fields:
   ```php
   $product->update([
       'seo_title' => $request->seo_title,
       'seo_description' => $request->seo_description,
       'seo_keywords' => $request->seo_keywords,
   ]);
   ```

## Troubleshooting

**Meta tags not showing?**
- Ensure `{!! renderMetaTags() !!}` is in the `<head>` section of your layout
- Check that controller is setting SEO data correctly

**Sitemap not working?**
- Verify routes have proper names
- Check that models have slug fields
- Ensure models are returning properly

**Structured data not showing?**
- Verify `{!! renderStructuredData() !!}` is in layout
- Check JSON format is valid using Google's Structured Data Testing Tool

## Next Steps

1. Run migrations: `php artisan migrate`
2. Update product/category admin forms to include SEO fields
3. Set SEO metadata for key products and categories
4. Test in Google Search Console
5. Monitor rankings and adjust keywords as needed
