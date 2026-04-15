<?php

if (!function_exists('seo')) {
    /**
     * Get the SEO service instance
     */
    function seo(): \App\Services\SeoService
    {
        return app(\App\Services\SeoService::class);
    }
}

if (!function_exists('seoTitle')) {
    /**
     * Set SEO title
     */
    function seoTitle(string $title = ''): \App\Services\SeoService
    {
        return seo()->setTitle($title);
    }
}

if (!function_exists('seoMeta')) {
    /**
     * Set multiple SEO meta tags
     */
    function seoMeta(string $title = '', string $description = '', string $keywords = ''): \App\Services\SeoService
    {
        return seo()
            ->setTitle($title)
            ->setDescription($description)
            ->setKeywords($keywords);
    }
}

if (!function_exists('renderMetaTags')) {
    /**
     * Render all meta tags
     */
    function renderMetaTags(): string
    {
        return seo()->renderMetaTags();
    }
}

if (!function_exists('renderStructuredData')) {
    /**
     * Render structured data as JSON-LD
     */
    function renderStructuredData(): string
    {
        return seo()->renderStructuredData();
    }
}
