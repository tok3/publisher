<?php
namespace Tok3\Publisher\Helpers;

class FormatHelper
{

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
    /**
     * Convert youtube duration in seconds and other
     *
     * @param $youtube_time
     * @param string $_format
     * @return string
     */
    public static function convTime($youtube_time, $_format = 'H:i:s')
    {
        $start = new \DateTime('@0'); // Unix epoch
        $start->add(new \DateInterval($youtube_time));

        if ($_format == 'seconds' || $_format == 'sec')
        {
            $split = explode(':', $start->format('H:i:s'));
            $seconds = ($split[0] * 60 * 60) + ($split[1] * 60) + $split[2];

            return $seconds;
        }

        return $start->format($_format);
    }


}