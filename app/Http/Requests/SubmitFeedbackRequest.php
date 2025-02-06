<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitFeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'author_name' => 'required|max:255',
            'content' => 'required|max:1500',
            'author_avatar' => 'required|max:1500',
            'star_rating' => 'integer|max:5|min:1',
        ];
    }
}
