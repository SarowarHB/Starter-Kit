<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'blog_type'             => ['required', 'string', 'max:255'],
            'title'                 => ['required', 'string', 'max:255'],
            'short_description'     => ['nullable', 'string', 'max:255'],
            'description'           => ['required', 'string'],
            'tags'                  => ['nullable', 'array'],

            'featured_image'        => ['required', 'file', 'max:500','mimes:jpeg,jpg,png,gif'],
        ];
    }
}
