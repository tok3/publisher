<?php
namespace Tok3\Publisher\Http;

use Illuminate\Routing\Controller as BaseController;
use \Tok3\Publisher\Models\Page as Page;
use \Tok3\Publisher\Models\Domain as Domain;
use \Tok3\Publisher\Requests\PagesEditCreateRequest;

class FrontController extends BaseController
{
    var $paginate;

    public function __construct()
    {

        $this->paginate = \Config::get('tok3-publisher.index_pager_items',5);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $pages = Page::published()->paginate($this->paginate);

        return view('tok3-publisher::index', compact('pages'));
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

        return view('tok3-publisher::page', compact('page'));
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

        return view('tok3-publisher::index', compact('pages', 'domain_slug'));

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

        return view('tok3-publisher::page', compact('page','domain_slug'));
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

        return view('tok3-publisher::page', compact('page'));
    }


}