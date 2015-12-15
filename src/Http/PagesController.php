<?php
namespace Tok3\Publisher\Http;

use Illuminate\Routing\Controller as BaseController;
use \Tok3\Publisher\Models\Page as Page;
use \Tok3\Publisher\Models\Image as Image;
use \Tok3\Publisher\Models\Domain as Domain;
use \Tok3\Publisher\Models\Tag as Tag;
use Illuminate\Http\Request;
use \Tok3\Publisher\Requests\PagesEditCreateRequest;
use Illuminate\Contracts\Auth\Guard as Auth;
class PagesController extends BaseController
{

    public function __construct()
    {
        if (\Config::get('tok3-publisher.no_auth_redir') != false &&  !\Auth::check())
        {
            Redirect()->to(\Config::get('tok3-publisher.no_auth_redir'))->send();
         }

        $this->view = (object)\Config::get('tok3-publisher.admin_views');

    }

    function home()
    {
        return redirect('auth/login');

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        //$pages = Page::published()->paginate(25); // no pagiger due to use of datatables
        $pages = Page::published()->get();

        return view($this->view->index_pages, compact('pages'));

    }


    /**
     * @param Page $page
     * @param $page_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Page $page, $page_id)
    {
        $page = $page->findOrFail($page_id);



        $domains = ['0' => 'No Domain'] + Domain::lists('name', 'id')->sort()->toArray();

        $tags = Tag::lists('name', 'id');

        return view($this->view->crud_pages, compact('page', 'domains', 'tags'))
            ->with('method', 'patch');
    }

    /**
     * @param PagesEditCreateRequest $request
     * @param Page $pages
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PagesEditCreateRequest $request, Page $pages, Image $_image, $id)
    {
        $page = $pages->find($id);

        if (is_array($request->tag_list))
        {
            $this->syncTags($page, $request->tag_list);
        }

        $images = $request->file('images');


        if ($request->hasFile('images') && is_array($images))
        {
            foreach ($images as $usage => $img)
            {
                if (is_object($img) && $img->isValid())
                {

                    // check if images are already stored
                    $image = $_image->where('usage', $usage)->where('page_id', $id)->first();

                    if (isset($image->name))
                    {
                        unlink(\Config::get('tok3-publisher.images_dir', 'images/tok3-publisher/') . $image->name);

                    }
                    else
                    {
                        $image = new Image;
                        $image->page_id = $id;
                    }


                    //$img_filename = md5(time() . $id . $usage) . '.' . $img->guessExtension();
                    $img_filename = time() . '_' . $id . '_' . $usage . '.' . $img->guessExtension();

                    $img->move(\Config::get('tok3-publisher.images_dir', 'images/tok3-publisher/'), $img_filename);


                    $image->origin_name = $img->getClientOriginalName();
                    $image->usage = $usage;
                    $image->name = $img_filename;
                    $image->mime = $img->getClientMimeType();

                    $image->save();


                }
            }

        }

        $page->update($request->page);

        return back();
    }

    /**
     * @param Page $page
     * @param $page_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Page $page)
    {
        $page = new $page;

        $tags = Tag::lists('name', 'id');

        $domains = ['0' => 'No Domain'] + Domain::lists('name', 'id')->sort()->toArray();

        return view($this->view->crud_pages, compact('page', 'domains', 'tags'))
            ->with('method', 'post');
    }

    /**
     * @param PagesEditCreateRequest $request
     * @param Page $pages
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PagesEditCreateRequest $request, Page $pages)
    {

        $page = new $pages;
        $crData = $request->page;

        $crData['meta_description'] = strip_tags($request->page['teaser']);
        $crData['og_descr'] = strip_tags($request->page['teaser']);

        $new_page = $page->create($crData);

        return redirect()->action('\Tok3\Publisher\Http\PagesController@edit', [$new_page->id]);
    }

    /**
     * @param Page $page
     * @param $page_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Page $page, $page_id)
    {

        $page->destroy($page_id);

        return redirect()->action('\Tok3\Publisher\Http\PagesController@index');

    }


    /**
     * /*
     * Syncronize  tags
     *
     * @param Page $page
     * @param array $tags
     */
    private function syncTags(Page $page, array $tags)
    {


        foreach ($tags as $tag_id)
        {

            if (!is_numeric($tag_id))
            {
                //$newTag = $tag_id;
                $newTag = substr($tag_id, 3);
                if (strlen($newTag) >= 3)
                {
                    $new_tag = Tag::create(['slug' => str_slug(str_replace('_', ' ', $newTag)), 'name' => str_replace('_', ' ', $newTag), 3]);
                    $tag_id = $new_tag->id;

                    $allTagIds[] = $tag_id;

                }
            }
            else
            {
                $allTagIds[] = $tag_id;
            }
        }

        $page->tags()->sync($allTagIds);

    }

}