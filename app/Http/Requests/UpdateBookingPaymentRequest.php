<?php

namespace App\Http\Requests;

use App\Models\BookingPayment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBookingPaymentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('booking_payment_edit');
    }

    public function rules()
    {
        return [
            'amount' => [
                'numeric',
                'required',
            ],
        ];
    }
}
