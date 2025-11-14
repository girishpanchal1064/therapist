<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author_id',
        'category_id',
        'status',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'twitter_card',
        'canonical_url',
        'focus_keyword',
        'seo_score',
        'published_at',
        'reading_time',
        'views_count',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'reading_time' => 'integer',
        'views_count' => 'integer',
    ];

    /**
     * Get the author of the blog post.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the category of the blog post.
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    /**
     * Scope for published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope for featured posts.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for posts by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Get the featured image URL.
     */
    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return asset('assets/img/blog-default.jpg');
    }

    /**
     * Get the reading time in minutes.
     */
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, ceil($wordCount / 200)); // Assuming 200 words per minute
    }

    /**
     * Get the SEO meta title (fallback to title if not set).
     */
    public function getSeoMetaTitleAttribute()
    {
        return $this->meta_title ?: $this->title;
    }

    /**
     * Get the SEO meta description (fallback to excerpt if not set).
     */
    public function getSeoMetaDescriptionAttribute()
    {
        return $this->meta_description ?: $this->excerpt;
    }

    /**
     * Get the OG title (fallback to meta title or title).
     */
    public function getOgTitleFormattedAttribute()
    {
        if (!empty($this->attributes['og_title'])) {
            return $this->attributes['og_title'];
        }
        return $this->meta_title ?: $this->title;
    }

    /**
     * Get the OG description (fallback to meta description or excerpt).
     */
    public function getOgDescriptionFormattedAttribute()
    {
        if (!empty($this->attributes['og_description'])) {
            return $this->attributes['og_description'];
        }
        return $this->meta_description ?: $this->excerpt;
    }

    /**
     * Get the OG image URL (fallback to featured image).
     */
    public function getOgImageUrlAttribute()
    {
        if ($this->og_image) {
            return asset('storage/' . $this->og_image);
        }
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return asset('assets/img/blog-default.jpg');
    }

    /**
     * Get the canonical URL (formatted version to avoid conflict with database column).
     */
    public function getCanonicalUrlFormattedAttribute()
    {
        if (!empty($this->attributes['canonical_url'])) {
            return $this->attributes['canonical_url'];
        }
        return route('blog.show', $this->slug);
    }

    /**
     * Calculate SEO score based on various factors.
     */
    public function calculateSeoScore()
    {
        $score = 0;
        $maxScore = 100;

        // Title (10 points)
        if ($this->title && strlen($this->title) >= 30 && strlen($this->title) <= 60) {
            $score += 10;
        } elseif ($this->title) {
            $score += 5;
        }

        // Meta Title (10 points)
        if ($this->meta_title && strlen($this->meta_title) >= 50 && strlen($this->meta_title) <= 60) {
            $score += 10;
        } elseif ($this->meta_title) {
            $score += 5;
        }

        // Meta Description (10 points)
        if ($this->meta_description && strlen($this->meta_description) >= 150 && strlen($this->meta_description) <= 160) {
            $score += 10;
        } elseif ($this->meta_description) {
            $score += 5;
        }

        // Excerpt (10 points)
        if ($this->excerpt && strlen($this->excerpt) >= 150 && strlen($this->excerpt) <= 160) {
            $score += 10;
        } elseif ($this->excerpt) {
            $score += 5;
        }

        // Focus Keyword (10 points)
        if ($this->focus_keyword) {
            $score += 10;
        }

        // Featured Image (10 points)
        if ($this->featured_image) {
            $score += 10;
        }

        // Content Length (20 points)
        $contentLength = str_word_count(strip_tags($this->content));
        if ($contentLength >= 300) {
            $score += 20;
        } elseif ($contentLength >= 200) {
            $score += 15;
        } elseif ($contentLength >= 100) {
            $score += 10;
        }

        // Slug (10 points)
        if ($this->slug && strlen($this->slug) <= 60) {
            $score += 10;
        }

        // OG Image (10 points)
        if ($this->og_image || $this->featured_image) {
            $score += 10;
        }

        return min($score, $maxScore);
    }
}
