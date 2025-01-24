<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:Original work,Based on',
            'authorship' => 'required|in:The work of your authorship,Translation',
            'author' => 'nullable|string|max:150',
            'work_link' => 'nullable|url|max:255',
            'source_id' => 'nullable',
            'new_source' => 'nullable|string|max:255|required_if:source_id,new',
            'genres' => 'required|array|exists:genres,id',
            'rating_id' => 'required|exists:ratings,id',
            'status' => 'required|in:In progress,Completed,Frozen',
            'size' => 'required|in:min,mid,max',
            'description' => 'nullable|string',
        ];
    }

    /**
     * @return void
     */
    public function prepareForValidation()
    {
        if (is_string($this->genres)) {
            $this->merge([
                'genres' => json_decode($this->genres, true),
            ]);
        }
    }
}
