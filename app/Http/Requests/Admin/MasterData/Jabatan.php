<?php

namespace App\Http\Requests\Admin\MasterData;

use App\Http\Requests\Request;

class Jabatan extends Request
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
            'department_id'=>'required',
            'position'=>'required|max:100',
        ];
    }
}
