<?php

namespace App\Http\Requests;

use App\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePost extends FormRequest
{   
    public function __construct(\Illuminate\Http\Request $request) 
    {
        if ( !$request->has('has_notified') ) {
            $request->merge([ 'has_notified' => false ]);
        } else {
            $request->merge([ 'has_notified' => true ]);
        }
    }

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
        $post_types = Post::getTypes();
        $post_statuses = Post::getStatuses();
        return [
            'title' => 'required|string',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'status' => [
                'required',
                Rule::in($post_statuses),
            ],
            'type' => [
                'required',
                Rule::in($post_types),
            ],
            'published_at' => 'required|date',
            'publish_time' => 'nullable|date_format:H:i:s',
            'category' => "required",
            'category.*' => 'exists:categories,id',
            'thumbnail_image_url' => 'nullable|image|dimensions:ratio=1',
            'featured_image_url' => 'nullable|image'
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
        $validator->after(function ($validator) {
            try {   
                $data = $validator->getData();
                $date = $data['published_at'];
                $time = $data['publish_time'];
                $published_date = $date.' '.$time;
                $published_at = \Carbon\Carbon::createFromFormat(config('app.php_date_format').' H:i:s', $published_date);
            } catch (\Exception $e) {   
                Log::error($e->getMessage());
                $validator->errors()->add('published_at', __('Invalid DateTime format'));
            }
        });
    }
}
