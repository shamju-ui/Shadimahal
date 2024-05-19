<?php

namespace App\Http\Requests;

use App\Models\BooingDateTime;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBooingDateTimeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('booing_date_time_create');
    }

    public function rules()
    {
        return [
            'booked_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'time_slot' => [
                'string',
                'nullable',
            ],
        ];
    }
}
