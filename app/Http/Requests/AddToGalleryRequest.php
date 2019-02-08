<?php

namespace App\Http\Requests;

use App\Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class AddToGalleryRequest extends FormRequest
{
    
    public function __construct(ValidationFactory $validationFactory)
    {
        parent::__construct();
        
        $validationFactory->extend(
            'checkIfImageExistsInGallery',
            function ($attribute, $value, $parameters) {
                return Image::whereIn('file_id', $value)
                    ->where('gallery_id', request()->get('galleryId'))
                    ->get()
                    ->isEmpty();
            },
            'Sorry, image is already in gallery!'
        );
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
        return [
            'images' => 'required|max:20|checkIfImageExistsInGallery',
            'galleryId' => 'required'
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
            'galleryId.required' => 'Please select gallery!',
            'images.required'  => 'Pleace select image/images!',
        ];
    }
}
