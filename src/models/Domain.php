<?php

namespace Tok3\Publisher\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Domain extends Model
{
    protected $table = 'tok3_publisher_domains';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages()
    {
        return $this->hasMany('Tok3\Publisher\Models\Page');
    }




}
