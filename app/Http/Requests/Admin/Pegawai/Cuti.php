<?php

namespace App\Http\Requests\Admin\Pegawai;

use App\Http\Requests\Request;

class Cuti extends Request
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
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_dates',
            'reason'=>'required',
        ];
    }
}
