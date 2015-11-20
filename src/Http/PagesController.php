<?php
namespace Tok3\Publisher\Http;

use Illuminate\Routing\Controller as BaseController;
use \Tok3\Publisher\Models\Page as Page;
use \Tok3\Publisher\Models\Image as Image;
use \Tok3\Publisher\Models\Domain as Domain;
use Illuminate\Http\Request;
use \Tok3\Publisher\Requests\PagesEditCreateRequest;

class PagesController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $pages = Page::published()->paginate(25);

        return view('tok3-publisher::admin.pages_index', compact('pages'));
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


        return view('tok3-publisher::admin.cr_edit', compact('page', 'domains'))
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

        $domains = ['0' => 'No Domain'] + Domain::lists('name', 'id')->sort()->toArray();

        return view('tok3-publisher::admin.cr_edit', compact('page', 'domains'))
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
        //$request->page['slug'] = str_slug($request->page['title']);
        $new_page = $page->create($request->page);

        return redirect()->action('\Tok3\Publisher\Http\PagesController@edit', [$new_page->id]);
    }

    public function destroy(Page $page, $page_id)
    {

        $page->destroy($page_id);

        return redirect()->action('\Tok3\Publisher\Http\PagesController@index');

    }


}