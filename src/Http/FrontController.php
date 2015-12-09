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
    var $paginate;

    public function __construct()
    {

        $this->paginate = \Config::get('tok3-publisher.index_pager_items', 5);
        $this->view = (object) \Config::get('tok3-publisher.views');
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

        if($page->type == 1)
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

        if($page->type == 1)
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
     * sitemap mh :-)
     */
    public function sitemap()
    {

        $pages = Page::published()->get();


        echo '<?xml version="1.0" encoding="UTF-8"?>'. "\n";

        return view('tok3-publisher::sitemap', compact('pages'));

    }
}