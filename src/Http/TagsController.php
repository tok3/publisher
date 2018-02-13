<?php

namespace Tok3\Publisher\Http;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Tok3\Publisher\Models\Tag as Tag;

class TagsController extends Controller
{

    public function __construct()
    {
        $this->view = (object)\Config::get('tok3-publisher.admin_views');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $tags = Tag::get();

        return view($this->view->index_tags, compact('tags'));
    }


    /**
     * @param Tag $tag
     * @param $tag_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($tag_id)
    {
        $tag = Tag::findOrFail($tag_id);


        return view($this->view->crud_tags, compact('tag'))
            ->with('method', 'patch');
    }


    /**
     * @param Request $request
     * @param Tag $tags
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tag $tags, $id)
    {
         $tags->find($id)->update($request->tag);

        return back();
    }

    /**
     * @param Tag $tag
     * @return $this
     */
    public function create(Tag $tag)
    {

        return view($this->view->crud_tags, compact('tag'))
            ->with('method', 'post');
    }

    /**
     * @param Request $request
     * @param Tag $tag
     */
    public function store(Request $request, Tag $tag)
    {

        $tag = new $tag;

        $new_tag = $tag->create($request->tag);

       return redirect()->action('\Tok3\Publisher\Http\TagsController@edit', [$new_tag->id]);
    }

    public function destroy(Tag $tag, $tag_id)
    {

        $tag->destroy($tag_id);

        return redirect()->action('\Tok3\Publisher\Http\TagsController@index');

    }


}
