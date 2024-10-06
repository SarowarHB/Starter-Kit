<?php

namespace App\Http\Requests\Admin\Config;

use Illuminate\Foundation\Http\FormRequest;

class SocialLinkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'facebook_link'      => ['nullable', 'url',function ($attribute, $value, $fail) {
                if (str_contains($this->facebook_link, 'facebook') == false) {
                    return $fail(__('Facebook URL Incorrect.'));
                }
            }],
            'instagram'     => ['nullable', 'url',function ($attribute, $value, $fail) {
                if (str_contains($this->instagram, 'https://www.instagram.com/') == false) {
                    return $fail(__('Instagram URL Incorrect.'));
                }
            }],
            'twitter'       => ['nullable', 'url',function ($attribute, $value, $fail) {
                if (str_contains($this->twitter, 'https://www.twitter.com/') == false) {
                    return $fail(__('Twitter URL Incorrect.'));
                }
            }],
            'linkedin'      => ['nullable', 'url', function ($attribute, $value, $fail) {
                if (str_contains($this->linkedin, 'https://www.linkedin.com/') == false) {
                    return $fail(__('Linkedin URL Incorrect.'));
                }
            }],
            'youtube'       => ['nullable', 'url', function ($attribute, $value, $fail) {
                if (str_contains($this->youtube, 'https://www.youtube.com/') == false) {
                    return $fail(__('Youtube URL Incorrect.'));
                }
            }],
        ];
    }
}
