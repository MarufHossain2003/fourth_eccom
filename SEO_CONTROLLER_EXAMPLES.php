<?php

/**
 * SEO Implementation Examples for Controllers
 * 
 * This file shows examples of how to implement SEO in your controller methods.
 * Copy and adapt these patterns to your existing controllers.
 */

namespace App\Http\Controllers\Examples;

use App\Services\SeoService;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;

/**
 * Example 1: Product Details Page
 * 
 * Add this to your ProductController or HomeController
 */
class ProductExampleController
{
    public function productDetails($slug, SeoService $seo)
    {
        $product = Product::whereSlug($slug)
            ->with(['category', 'subCategory', 'color', 'size', 'galleryImage'])
            ->firstOrFail();

        // Method 1: Use model SEO data directly
        $seo->fromModel($product);

        // Method 2: Customize SEO data
        // $seo->setTitle($product->seo_title ?? $product->name)
        //     ->setDescription($product->seo_description ?? substr(strip_tags($product->description), 0, 160))
        //     ->setKeywords($product->seo_keywords)
        //     ->setCanonicalUrl(route('product.details', $product->slug));

        // Method 3: Add product schema
        $seo->setStructuredData([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $product->description,
            'image' => $product->getOgImage(),
            'sku' => $product->sku ?? '',
            'priceCurrency' => 'BDT',
            'price' => $product->price,
            'availability' => 'https://schema.org/InStock',
            'brand' => [
                '@type' => 'Brand',
                'name' => config('app.name'),
            ],
        ]);

        return view('frontend.product.show', ['product' => $product]);
    }
}

/**
 * Example 2: Category Products Page
 */
class CategoryExampleController
{
    public function categoryProducts($slug, SeoService $seo)
    {
        $category = Category::whereSlug($slug)->firstOrFail();
        $products = $category->product()->paginate(12);

        // Use model SEO data
        $seo->fromModel($category);

        // Or customize
        // $seo->setTitle("Shop " . $category->name . " | " . config('app.name'))
        //     ->setDescription($category->seo_description ?? "Browse our " . $category->name . " collection")
        //     ->setKeywords($category->seo_keywords)
        //     ->setCanonicalUrl(route('category.products', $category->slug));

        // Add collection schema
        $seo->setStructuredData([
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $category->name,
            'description' => $category->seo_description ?? $category->description,
            'url' => route('category.products', $category->slug),
        ]);

        return view('frontend.category.products', [
            'category' => $category,
            'products' => $products
        ]);
    }
}

/**
 * Example 3: Sub-Category Products Page
 */
class SubCategoryExampleController
{
    public function subCategoryProducts($slug, SeoService $seo)
    {
        $subCategory = SubCategory::whereSlug($slug)->firstOrFail();
        $products = $subCategory->product()->paginate(12);

        $seo->fromModel($subCategory);

        return view('frontend.subcategory.products', [
            'subCategory' => $subCategory,
            'products' => $products
        ]);
    }
}

/**
 * Example 4: Homepage
 */
class HomeExampleController
{
    public function index(SeoService $seo)
    {
        $hotProduct = Product::where('product_type', 'hot')->orderBy('id', 'desc')->get();
        $newProduct = Product::where('product_type', 'new')->orderBy('id', 'desc')->get();
        $regularProduct = Product::where('product_type', 'regular')->orderBy('id', 'desc')->get();
        $discountProduct = Product::where('product_type', 'discount')->orderBy('id', 'desc')->get();

        // Set homepage SEO
        $seo->setTitle(config('app.name'))
            ->setDescription(config('seo.site_description'))
            ->setCanonicalUrl(route('home'))
            ->setOgData([
                'og:image' => asset('images/og-default.png'),
                'og:type' => 'website',
            ]);

        // Add Organization schema
        $seo->setStructuredData([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => config('app.url'),
            'logo' => asset('images/logo.png'),
            'sameAs' => [
                'https://www.facebook.com/' . env('FACEBOOK_PAGE', ''),
                'https://twitter.com/' . env('TWITTER_HANDLE', ''),
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'Customer Service',
                'email' => 'support@example.com',
            ],
        ]);

        return view('frontend.index', compact(
            'hotProduct',
            'newProduct',
            'regularProduct',
            'discountProduct'
        ));
    }
}

/**
 * Example 5: Search Results Page
 */
class SearchExampleController
{
    public function searchProducts(Request $request, SeoService $seo)
    {
        $query = $request->input('q');
        $products = Product::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->paginate(12);

        $seo->setTitle("Search Results for '" . htmlspecialchars($query) . "' | " . config('app.name'))
            ->setDescription("Find products matching '" . htmlspecialchars($query) . "' on " . config('app.name'))
            ->setCanonicalUrl(route('search', ['q' => $query]))
            ->setStructuredData([
                '@context' => 'https://schema.org',
                '@type' => 'SearchResultsPage',
                'name' => "Search Results for " . $query,
                'url' => url()->current(),
            ]);

        return view('frontend.search', ['products' => $products, 'query' => $query]);
    }
}

/**
 * Example 6: Static Pages (Privacy Policy, Terms, etc.)
 */
class StaticPagesExampleController
{
    public function privacyPolicy(SeoService $seo)
    {
        $policy = \App\Models\PrivacyPolicy::first();

        $seo->setTitle("Privacy Policy | " . config('app.name'))
            ->setDescription("Read our privacy policy to understand how we protect your data")
            ->setCanonicalUrl(route('privacy-policy'))
            ->setStructuredData([
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Privacy Policy',
                'url' => route('privacy-policy'),
            ]);

        return view('frontend.pages.privacy-policy', ['policy' => $policy]);
    }

    public function termsConditions(SeoService $seo)
    {
        $terms = \App\Models\TermsConditions::first();

        $seo->setTitle("Terms & Conditions | " . config('app.name'))
            ->setDescription("Read our terms and conditions for using our service")
            ->setCanonicalUrl(route('terms-conditions'));

        return view('frontend.pages.terms-conditions', ['terms' => $terms]);
    }

    public function refundPolicy(SeoService $seo)
    {
        $policy = \App\Models\RefundPolicy::first();

        $seo->setTitle("Refund Policy | " . config('app.name'))
            ->setDescription("Learn about our refund policy and how to request a refund")
            ->setCanonicalUrl(route('refund-policy'));

        return view('frontend.pages.refund-policy', ['policy' => $policy]);
    }
}

/**
 * Implementation Steps:
 * 
 * 1. Import SeoService in your controller:
 *    use App\Services\SeoService;
 * 
 * 2. Inject SeoService in your controller method:
 *    public function yourMethod($param, SeoService $seo) { }
 * 
 * 3. Set SEO data using one of these patterns:
 * 
 *    // Pattern A: From model
 *    $seo->fromModel($model);
 * 
 *    // Pattern B: Manual
 *    $seo->setTitle('Title')
 *        ->setDescription('Description')
 *        ->setKeywords('Keywords')
 *        ->setCanonicalUrl(url()->current());
 * 
 *    // Pattern C: With structured data
 *    $seo->fromModel($model)
 *        ->setStructuredData([...]);
 * 
 * 4. The meta tags will automatically be rendered in your layout
 *    because {!! renderMetaTags() !!} is in the <head> section
 */
