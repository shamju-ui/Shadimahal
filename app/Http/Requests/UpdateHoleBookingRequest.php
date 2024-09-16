<?php

namespace App\Http\Requests;

use App\Models\HoleBooking;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHoleBookingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('hole_booking_edit');
    }

    public function rules()
    {
        return [
            // 'date' => [
            //     'required',
            //     'date_format:' . config('panel.date_format'),
            // ],
            // 'time_slot' => [
            //     'required',
            // ],
            'name' => [
                'string',
                'required',
            ],
            'mobile_1' => [
                'string',
                'required',
            ],
            'mobile_2' => [
                'string',
                'nullable',
            ],
            'total_amount' => [
                'numeric',
            ],
            // 'elactric_charges' => [
            //     'string',
            //     'nullable',
            // ],
            'comment' => [
                'string',
                'nullable',
            ],
        ];
    }
}
