<?php
namespace Tok3\Publisher\Http;

use Illuminate\Routing\Controller as BaseController;
use \Tok3\Publisher\Models\Page as Page;
use \Tok3\Publisher\Models\Domain as Domain;
use \Tok3\Publisher\Models\Tag as Tag;
use \Tok3\Publisher\Requests\PagesEditCreateRequest;
use Carbon\Carbon as Carbon;

class FrontController extends BaseController
{
    var $paginate = 5;

    public function __construct()
    {

        $this->paginate = \Config::get('tok3-publisher.index_pager_items', 5);
        $this->view = (object)\Config::get('tok3-publisher.views');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $pages = Page::published()->paginate($this->paginate);

        return view($this->view->index, compact('pages'));
    }


    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {

        $page = Page::published()->where('slug', $slug)
            ->where('domain_id', 0)
            ->first();

        $view = $this->view->page;

        if ($page->type == 1)
        {
            $view = $this->view->article_page;
        }

        return view($view, compact('page'));
    }

    /**
     * show entries prefixed by a domain/cat
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexDomain()
    {

        $domain_slug = \Request::segment(1);
        $domain = Domain::where('slug', $domain_slug)
            ->first();

        $pages = Page::published()
            ->where('domain_id', $domain->id)->paginate($this->paginate);

        return view($this->view->index_domain, compact('pages', 'domain_slug'));

    }

    private function replaceContent($ctn)
    {
        return $ctn . 'jep';

    }
    /**
     * show entries prefixed by a domain/cat
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDomain($slug)
    {
        $domain_slug = \Request::segment(1);
        $domain = Domain::where('slug', $domain_slug)
            ->first();

        $page = Page::published()
            ->where('slug', $slug)
            ->where('domain_id', $domain->id)
            ->first();



        $view = $this->view->page;

        if ($page->type == 1)
        {
            $view = $this->view->article_page;
        }

        return view($view, compact('page', 'domain_slug'));
    }

    /**
     * preview page when not published or publish date in future
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preview($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('ip', \Request::getClientIp())
            ->first();


        $formView = view('site._cta_form_top');


        return view('tok3-publisher::page', compact('page'));
    }



    /**
     * list archive
     *
     * @param $req
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archive($req)
    {

        $pages = Page::archive($req)->paginate($this->paginate);

        return view($this->view->index_archive, compact('pages'));

    }

    /**
     * list all articles belongs to certain tag
     * @param $req
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag($req)
    {

        $p = TAG::where('slug', $req)->first();

        $pages = $p->pages()->paginate($this->paginate);

        return view($this->view->index_tag, compact('pages'));

    }


    /**
     * @param $input
     * @return mixed
     */
    function minify_html($input)
    {
        if (trim($input) === "")
        {
            return $input;
        }
        // Remove extra white-space(s) between HTML attribute(s)
        $input = preg_replace_callback('#<([^\/\s<>!]+)(?:\s+([^<>]*?)\s*|\s*)(\/?)>#s', function ($matches)
        {
            return '<' . $matches[1] . preg_replace('#([^\s=]+)(\=([\'"]?)(.*?)\3)?(\s+|$)#s', ' $1$2', $matches[2]) . $matches[3] . '>';
        }, str_replace("\r", "", $input));
        // Minify inline CSS declaration(s)
        if (strpos($input, ' style=') !== false)
        {
            $input = preg_replace_callback('#<([^<]+?)\s+style=([\'"])(.*?)\2(?=[\/\s>])#s', function ($matches)
            {
                return '<' . $matches[1] . ' style=' . $matches[2] . $this->minify_css($matches[3]) . $matches[2];
            }, $input);
        }

        return preg_replace(
            array(
                // t = text
                // o = tag open
                // c = tag close
                // Keep important white-space(s) after self-closing HTML tag(s)
                '#<(img|input)(>| .*?>)#s',
                // Remove a line break and two or more white-space(s) between tag(s)
                '#(<!--.*?-->)|(>)(?:\n*|\s{2,})(<)|^\s*|\s*$#s',
                '#(<!--.*?-->)|(?<!\>)\s+(<\/.*?>)|(<[^\/]*?>)\s+(?!\<)#s', // t+c || o+t
                '#(<!--.*?-->)|(<[^\/]*?>)\s+(<[^\/]*?>)|(<\/.*?>)\s+(<\/.*?>)#s', // o+o || c+c
                '#(<!--.*?-->)|(<\/.*?>)\s+(\s)(?!\<)|(?<!\>)\s+(\s)(<[^\/]*?\/?>)|(<[^\/]*?\/?>)\s+(\s)(?!\<)#s', // c+t || t+o || o+t -- separated by long white-space(s)
                '#(<!--.*?-->)|(<[^\/]*?>)\s+(<\/.*?>)#s', // empty tag
                '#<(img|input)(>| .*?>)<\/\1>#s', // reset previous fix
                '#(&nbsp;)&nbsp;(?![<\s])#', // clean up ...
                '#(?<=\>)(&nbsp;)(?=\<)#', // --ibid
                // Remove HTML comment(s) except IE comment(s)
                '#\s*<!--(?!\[if\s).*?-->\s*|(?<!\>)\n+(?=\<[^!])#s'
            ),
            array(
                '<$1$2</$1>',
                '$1$2$3',
                '$1$2$3',
                '$1$2$3$4$5',
                '$1$2$3$4$5$6$7',
                '$1$2$3',
                '<$1$2',
                '$1 ',
                '$1',
                ""
            ),
            $input);
    }


    // CSS Minifier => http://ideone.com/Q5USEF + improvement(s)
    /**
     * @param $input
     * @return mixed
     */
    function minify_css($input)
    {
        if (trim($input) === "")
        {
            return $input;
        }

        return preg_replace(
            array(
                // Remove comment(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
                // Remove unused white-space(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
                // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
                '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
                // Replace `:0 0 0 0` with `:0`
                '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
                // Replace `background-position:0` with `background-position:0 0`
                '#(background-position):0(?=[;\}])#si',
                // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
                '#(?<=[\s:,\-])0+\.(\d+)#s',
                // Minify string value
                '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
                '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
                // Minify HEX color code
                '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
                // Replace `(border|outline):none` with `(border|outline):0`
                '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
                // Remove empty selector(s)
                '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
            ),
            array(
                '$1',
                '$1$2$3$4$5$6$7',
                '$1',
                ':0',
                '$1:0 0',
                '.$1',
                '$1$3',
                '$1$2$4$5',
                '$1$2$3',
                '$1:0',
                '$1$2'
            ),
            $input);
    }

    /**
     * sitemap mh :-)
     */
    public function sitemap()
    {

        $pages = Page::published()->get();


        header('Content-type: text/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";

        return view('tok3-publisher::sitemap', compact('pages'));

    }


}