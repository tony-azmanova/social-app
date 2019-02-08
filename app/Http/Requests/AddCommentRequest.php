<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCommentRequest extends FormRequest
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
           'commentTitle' => 'required|max:255',
           'commentContent' => 'required|max:255',
       ];
   }

   /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages()
   {
       return [
           'postTitle.required' => 'A title is required',
           'postContent.required'  => 'Please write somethindg as comment content...',
       ];
   }
}
