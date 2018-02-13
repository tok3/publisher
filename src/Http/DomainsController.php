<?php

namespace Tok3\Publisher\Http;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Tok3\Publisher\Models\Domain as Domain;

class DomainsController extends Controller
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

        $domains = Domain::get();

        return view($this->view->index_domains, compact('domains'));
    }


    /**
     * @param Domain $domain
     * @param $domain_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($domain_id)
    {
        $domain = Domain::findOrFail($domain_id);


        return view($this->view->crud_domains, compact('domain'))
            ->with('method', 'patch');
    }


    /**
     * @param Request $request
     * @param Domain $domains
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Domain $domains, $id)
    {
        $domains->find($id)->update($request->domain);

        return back();
    }

    /**
     * @param Domain $domain
     * @return $this
     */
    public function create(Domain $domain)
    {

        return view($this->view->crud_domains, compact('domain'))
            ->with('method', 'post');
    }

    /**
     * @param Request $request
     * @param Domain $domain
     */
    public function store(Request $request, Domain $domain)
    {

        $domain = new $domain;

        $new_domain = $domain->create($request->domain);

        return redirect()->action('\Tok3\Publisher\Http\DomainsController@edit', [$new_domain->id]);
    }

    public function destroy(Domain $domain, $domain_id)
    {

        $domain->destroy($domain_id);

        return redirect()->action('\Tok3\Publisher\Http\DomainsController@index');

    }

}
