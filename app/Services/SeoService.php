<?php

namespace App\Services;

class SeoService
{
    private string $title = '';
    private string $description = '';
    private string $keywords = '';
    private string $canonicalUrl = '';
    private array $ogData = [];
    private array $structuredData = [];

    /**
     * Set the page title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title . ' | ' . config('app.name');
        return $this;
    }

    /**
     * Get the page title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the meta description
     */
    public function setDescription(string $description): self
    {
        $this->description = substr($description, 0, 160);
        return $this;
    }

    /**
     * Get the meta description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the meta keywords
     */
    public function setKeywords(string $keywords): self
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * Get the meta keywords
     */
    public function getKeywords(): string
    {
        return $this->keywords;
    }

    /**
     * Set canonical URL
     */
    public function setCanonicalUrl(string $url): self
    {
        $this->canonicalUrl = $url;
        return $this;
    }

    /**
     * Get canonical URL
     */
    public function getCanonicalUrl(): string
    {
        return $this->canonicalUrl;
    }

    /**
     * Set Open Graph data
     */
    public function setOgData(array $data): self
    {
        $this->ogData = array_merge($this->ogData, $data);
        return $this;
    }

    /**
     * Get Open Graph data
     */
    public function getOgData(): array
    {
        return array_merge([
            'og:title' => $this->getTitle(),
            'og:description' => $this->getDescription(),
            'og:url' => $this->getCanonicalUrl(),
            'og:type' => 'website',
            'og:image' => asset('images/og-default.png'),
        ], $this->ogData);
    }

    /**
     * Set structured data (JSON-LD)
     */
    public function setStructuredData(array $data): self
    {
        $this->structuredData = array_merge($this->structuredData, $data);
        return $this;
    }

    /**
     * Get structured data
     */
    public function getStructuredData(): array
    {
        return $this->structuredData;
    }

    /**
     * Set from model
     */
    public function fromModel($model): self
    {
        if (method_exists($model, 'getSeoTitle')) {
            $this->setTitle($model->getSeoTitle());
        }

        if (method_exists($model, 'getSeoDescription')) {
            $this->setDescription($model->getSeoDescription());
        }

        if (method_exists($model, 'getSeoKeywords')) {
            $this->setKeywords($model->getSeoKeywords());
        }

        if (method_exists($model, 'getCanonicalUrl')) {
            $this->setCanonicalUrl($model->getCanonicalUrl());
        }

        if (method_exists($model, 'getOgData')) {
            $this->setOgData($model->getOgData());
        }

        if (method_exists($model, 'getStructuredData')) {
            $this->setStructuredData($model->getStructuredData());
        }

        return $this;
    }

    /**
     * Render meta tags HTML
     */
    public function renderMetaTags(): string
    {
        $html = '';

        // Title
        if ($this->getTitle()) {
            $html .= "<title>{$this->getTitle()}</title>\n";
        }

        // Description
        if ($this->getDescription()) {
            $html .= "<meta name=\"description\" content=\"{$this->getDescription()}\">\n";
        }

        // Keywords
        if ($this->getKeywords()) {
            $html .= "<meta name=\"keywords\" content=\"{$this->getKeywords()}\">\n";
        }

        // Canonical
        if ($this->getCanonicalUrl()) {
            $html .= "<link rel=\"canonical\" href=\"{$this->getCanonicalUrl()}\">\n";
        }

        // Open Graph
        foreach ($this->getOgData() as $property => $content) {
            $html .= "<meta property=\"{$property}\" content=\"{$content}\">\n";
        }

        // Twitter Card
        $html .= "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
        $html .= "<meta name=\"twitter:title\" content=\"{$this->getTitle()}\">\n";
        $html .= "<meta name=\"twitter:description\" content=\"{$this->getDescription()}\">\n";

        return $html;
    }

    /**
     * Render structured data
     */
    public function renderStructuredData(): string
    {
        if (empty($this->structuredData)) {
            return '';
        }

        return '<script type="application/ld+json">' . json_encode($this->structuredData, JSON_UNESCAPED_SLASHES) . '</script>';
    }
}
