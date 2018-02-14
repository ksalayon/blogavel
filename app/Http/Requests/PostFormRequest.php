<?php namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\User;
use App\Post;
use Auth;
class PostFormRequest extends FormRequest {
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        if($this->user()->can_post())
        {
            return true;
        }
        return false;
    }
    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Please enter a title yo!',
            'body.required'  => 'The silence is deafening!',
        ];
    }
}
