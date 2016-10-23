<?php

namespace App\Http\Requests\Admin\MasterData;

use App\Http\Requests\Request;

class Pegawai extends Request
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
            'position_id'=>'required',
            'nip'=>'required|max:10|unique:master_employees,nip,'.$this->segment(4),
            'name'=>'required|max:40',
            'place_of_birth'=>'required|max:30',
            'date_of_birth'=>'required|date',
            'address'=>'required',
            'postal_code'=>'required|max:8',
            'phone'=>'required|max:15',
            'foto'=>'image',
            'join_date'=>'required|date',
            'basic_salary'=>'required|numeric|max:9999999999',
            'meal_allowance'=>'required|numeric|max:9999999999',
            'transport'=>'required|numeric|max:9999999999',
        ];
    }
}
