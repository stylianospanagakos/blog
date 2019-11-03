<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'title' => 'required|max:50',
            'body' => 'required|min:100',
            'tags' => 'required'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {

        $validator->after(function($validator)
        {
            // get tags
            $tags = $this->input('tags');

            // explode tags
            $tags = explode(',', $tags);

            // make sure elements are unique
            $tags = array_unique(array_map('trim', $tags));

            if (count($tags) > 3) {
                $validator->errors()->add('tags', 'You cannot have more than 3 tags.');
                return;
            }

            // run checks to verify tag is valid
            foreach ($tags as $tag) {

                /**
                 * Validation fails if one of the following checks is true:
                 * 1. tag is not one word
                 * 2. tag is numeric
                 **/
                if (strpos($tag, ' ') !== false) {
                    $validator->errors()->add('tags', 'Tags should all be one-word');
                    break;
                } else if (is_numeric($tag)) {
                    $validator->errors()->add('tags', 'Tags cannot be numeric.');
                    break;
                }

            }

        });
    }

}
