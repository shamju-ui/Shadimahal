<?php

namespace App\Http\Requests;

use App\Models\BookingPayment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBookingPaymentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('booking_payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:booking_payments,id',
        ];
    }
}
