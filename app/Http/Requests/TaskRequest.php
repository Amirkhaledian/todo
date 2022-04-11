<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        if($this->isMethod('post')){
            return [
                'title' =>'required|min:5|max:50',
                'description' =>'required|min:5|max:1000',
                'status' =>'required|in:open,close',
            ];
        }else{
            if($this->status){
                return [
                    'status' =>'required|in:open,close',
                ];
            }else{
                return [
                    'title' =>'required|min:5|max:50',
                    'description' =>'required|min:5|max:1000',
                ];
            }

        }
    }
}
