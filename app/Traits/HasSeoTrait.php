<?php

namespace App\Traits;

trait HasSeoTrait
{
    /**
     * Get the SEO title
     */
    public function getSeoTitle(): string
    {
        return $this->seo_title ?? $this->name ?? $this->title ?? '';
    }

    /**
     * Get the SEO description
     */
    public function getSeoDescription(): string
    {
        return $this->seo_description ?? substr(strip_tags($this->description ?? ''), 0, 160) ?? '';
    }

    /**
     * Get the SEO keywords
     */
    public function getSeoKeywords(): string
    {
        return $this->seo_keywords ?? '';
    }

    /**
     * Get the canonical URL
     */
    public function getCanonicalUrl(): string
    {
        return $this->canonical_url ?? route($this->getRouteName(), $this->getRouteParams());
    }

    /**
     * Get the route name for canonical URL
     */
    protected function getRouteName(): string
    {
        $class = class_basename($this);
        
        return match ($class) {
            'Product' => 'product.details',
            'Category' => 'category.products',
            'SubCategory' => 'subcategory.products',
            default => 'home',
        };
    }

    /**
     * Get the route parameters
     */
    protected function getRouteParams(): array
    {
        return ['slug' => $this->slug ?? $this->id];
    }

    /**
     * Get Open Graph data
     */
    public function getOgData(): array
    {
        return [
            'og:title' => $this->getSeoTitle(),
            'og:description' => $this->getSeoDescription(),
            'og:url' => $this->getCanonicalUrl(),
            'og:type' => 'website',
            'og:image' => $this->getOgImage(),
        ];
    }

    /**
     * Get OG image
     */
    public function getOgImage(): string
    {
        if (property_exists($this, 'image') && $this->image) {
            return asset('storage/' . $this->image);
        }
        
        if (property_exists($this, 'featured_image') && $this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }

        return asset('images/og-default.png');
    }

    /**
     * Get structured data (JSON-LD)
     */
    public function getStructuredData(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => $this->getSchemaType(),
            'name' => $this->getSeoTitle(),
            'description' => $this->getSeoDescription(),
            'url' => $this->getCanonicalUrl(),
            'image' => $this->getOgImage(),
        ];
    }

    /**
     * Get schema type
     */
    protected function getSchemaType(): string
    {
        $class = class_basename($this);
        
        return match ($class) {
            'Product' => 'Product',
            'Category' => 'CollectionPage',
            'SubCategory' => 'CollectionPage',
            default => 'WebPage',
        };
    }
}
