<?php

namespace Tok3\Publisher\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Image extends Model
{
    protected $table = 'tok3_publisher_images';

    protected $guarded = ['id', 'created_at', 'updated_at'];



    /**
     *  Get the Page that owns the image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domain()
    {
        return $this->belongsTo('Tok3\Publisher\Models\Page');
    }


}
