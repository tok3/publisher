<?php

namespace Tok3\Publisher\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use \Tok3\Publisher\Models\Domain as Domain;
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

    public function scopeArchive($query, $date)
    {

        $query->whereMonth('published_at', '=', Carbon::parse($date)->format('m'))
            ->whereYear('published_at', '=', Carbon::parse($date)->format('Y'))
        ->where('type',1);
    }
    /**
     * @param $value
     * @return string
     */
    public function getPageUrlAttribute($value)
    {

        if (isset($this->domain->slug))
        {
            return $this->domain->slug . '/' . $this->attributes['slug'];

        }

        return $this->attributes['slug'];
    }

    /**
     * get page image by usage
     *
     * @param string $_usage
     * @return mixed
     */
    public function image($_usage = '')
    {

        return $this->images->where('usage',$_usage)->first();

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

    /**
     * Get the tags associated with this page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->belongsToMany('Tok3\Publisher\Models\Tag','tok3_publisher_page_tag')->withTimestamps();
    }

    /**
     * get the permissions associated with the given role.
     *
     * @return mixed
     */
    public function getTagListAttribute()
    {

        $role_permissions = DB::table('tok3_publisher_page_tag')
            ->where('page_id', $this->id)
            ->lists('tag_id');

        return $role_permissions;

    }

    /**
     * json output for yajra\Datatables, domain have to be in result otherwise its not searchable
     *
     * @return mixed
     */
    public function getDtOverview()
    {
        $users = DB::table($this->table)
            ->select(DB::raw($this->table . '.*, IF(char_length(tok3_publisher_domains.name) > 0, tok3_publisher_domains.name, "n/a") AS domain_name'))
            ->leftjoin('tok3_publisher_domains', $this->table . '.domain_id', '=', 'tok3_publisher_domains.id');

        return $users;
    }

}



