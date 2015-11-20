<?php
namespace Tok3\Publisher;
use \Tok3\Publisher\Models\Page as Page;
use \Tok3\Publisher\Models\Domain as Domain;
class Publisher
{

    /**
     * generate archive links by month and year
     *
     * @return array
     */
    public function archive()
    {
        //https://laracasts.com/discuss/channels/general-discussion/group-post-by-day


        $posts = Page::published()->get()->groupBy(function ($item)
        {
            return $item->published_at->formatLocalized('%B %Y');
        });

        $retVal = [];
        $key = 0;
        foreach ($posts as $archmonth => $item)
        {

            $retVal[$key] = $archmonth . ' (' . count($item) . ')';

            ++$key;
        }

        return $retVal;
    }

}
