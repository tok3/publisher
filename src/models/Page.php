<?php

namespace Tok3\Publisher\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Page extends Model
{
    protected $table = 'tok3_publisher_pages';

    /**
     * @var array
     */

    protected $dates = ['published_at', 'published_till', 'created_at', 'updated_at'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @param $query
     */
    public function scopeUnpublished($query)
    {
        $query->where('published_at', '>', Carbon::now());

    }

    /**
     * @param $query
     */
    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now())
            ->where('published', 1)
            ->orderby('published_at', 'DESC');
    }


    public function getPageUrlAttribute($value)
    {

        if (isset($this->domain->slug))
        {
            return $this->domain->slug . '/' . $this->attributes['slug'];

        }

        return $this->attributes['slug'];
    }

    /**
     *  Get the domain that owns the page.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domain()
    {
        return $this->belongsTo('Tok3\Publisher\Models\Domain');
    }

    /**
     *  Get the images that belongs to the page.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function images()
    {
        return $this->hasMany('Tok3\Publisher\Models\Image');

    }

}



