<?php

namespace Tok3\Publisher\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tag extends Model
{
    //
    protected $table = 'tok3_publisher_tags';

    protected $dates = ['created_at', 'updated_at'];
    protected $guarded = ['id'];

    /**
     * Get pages associated with this Tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    function pages()
    {
        return $this->belongsToMany('Tok3\Publisher\Models\Page','tok3_publisher_page_tag')->withTimestamps();
    }

    /**
     * @param $query
     * @param $name
     */
    public function scopeCheck($query, $name)
    {
        $query->where('name', '=', trim($name));

    }
}
