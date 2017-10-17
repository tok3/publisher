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

 /**
     * generate latest
     *
     * @return array
     */
    public function latest($_limit = 5)
    {


        $posts = Page::published()
            ->orderBy('published_at','DESC')
            ->limit($_limit)
            ->get();


        return $posts;
    }


    /**
     * senitize unbalanced html tags
     *
     * @param $html
     * @return mixed
     */
    public static function sanitizeTags($html)
    {
        $html_new = str_replace('<br>','%%br%%',$html);

        preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU", $html, $result1);
        preg_match_all("#</([a-z]+)>#iU", $html, $result2);
        $results_start = $result1[1];
        $results_end = $result2[1];

        foreach ($results_start AS $startag)
        {
            if (!in_array($startag, $results_end))
            {
                $html_new = str_replace('<' . $startag . '>', '', $html_new);
            }
        }

        foreach ($results_end AS $endtag)
        {
            if (!in_array($endtag, $results_start))
            {
                $html_new = str_replace('</' . $endtag . '>', '', $html_new);
            }
        }

        $html = str_replace('%%br%%','<br>',$html_new);

        return $html;
    }

    /**
     * remove html tags that we won't see in output
     *
     * @param $_input
     * @return mixed
     */
    public static function filterTags($_input)
    {

        $filter = [ '<div>', '</div>'];

        $replace = array_fill ( 0 ,count($filter) , '' );


        return str_replace($filter,$replace,$_input);

    }


}
