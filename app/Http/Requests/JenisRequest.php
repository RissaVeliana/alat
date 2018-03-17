<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JenisRequest extends FormRequest
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
        'jenis'=>'required|unique:jenis_barangs'
        ];
    }
     public function messages()
     {
        return [
        'jenis.required'=>'nama tidak boleh sama'
        ];
    } 
}
