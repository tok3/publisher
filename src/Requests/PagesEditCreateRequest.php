<?php

namespace Tok3\Publisher\Requests;

use \App\Http\Requests\Request;
use \Tok3\Publisher\Models\Page as Page;

class PagesEditCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //$this->uqSlug();
        $rules = [
           'page.slug' => "required|unique:tok3_publisher_pages,slug",
            'page.title' => "required"
        ];



        foreach ($this->images as $key => $uplFile)
        {
            if (count($uplFile) == 1)
            {
                $rules['images.' . $key] = 'mimes:jpeg,png,gif';
            }
        }


        if ((Request::isMethod('patch') || Request::isMethod('put')))
        {
         unset($rules['page.slug']);
        }

        return $rules;

    }


    protected function uqSlug()
    {
        $input = $this->request->all();

        if ($input['page']['slug'] == '')
        {
            $input['page']['slug'] = str_slug($input['page']['title']);
        }
        $slug_count = Page::where('slug', $input['page']['slug'])->count();

        if (Request::isMethod('post') && $slug_count != 0)
        {

            $input['page']['slug'] .= '-' . $slug_count;
        }
        if ((Request::isMethod('patch') || Request::isMethod('put')) && $slug_count > 1)
        {
            $last = strrpos($input['page']['slug'], '-');

            $occ = substr($input['page']['slug'], $last + 1);
            $input['page']['slug'] = substr($input['page']['slug'], 0, $last + 1) . ($occ + 1);
        }

        $this->replace($input);
    }

}
