<?php
namespace Tok3\Publisher;

use \Tok3\Publisher\Models\Page as Page;
use \Tok3\Publisher\Models\Domain as Domain;
use Carbon\Carbon as Carbon;


class Publisher
{

    /**
     * generate archive links by month and year
     *
     * @return array
     */
    public function archive()
    {


        $posts = Page::published()
            ->where('type',1)
            ->where('published_at', '<', Carbon::now()->startOfMonth())
            ->get()->groupBy(function ($item)
        {
            return $item->published_at->formatLocalized('%B %Y');
        });


        $retVal = [];
        $key = 0;
        foreach ($posts as $archmonth => $item)
        {

            $retVal[$key]['link'] = url(\Config::get('tok3-publisher.default_route', 'publisher') . '/archive/' . $item[0]->published_at->formatLocalized('%Y-%m'));

            $retVal[$key]['txt'] = $archmonth . ' (' . count($item) . ')';

            ++$key;
        }

        return $retVal;
    }

}
