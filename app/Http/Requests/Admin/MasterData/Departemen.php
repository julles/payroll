<?php

namespace App\Http\Requests\Admin\MasterData;

use App\Http\Requests\Request;

class Departemen extends Request
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
            'department'=>'required|max:100|min:2|unique:master_departments,department,'.\Admin::getId(),
        ];
    }
}
