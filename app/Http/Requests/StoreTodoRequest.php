<?php

namespace App\Http\Requests;

use App\Models\Todo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTodoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'item' => [
                'string',
                'required',
            ],
        ];
    }
}
