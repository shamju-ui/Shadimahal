<?php

namespace App\Http\Requests;

use App\Models\BooingDateTime;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBooingDateTimeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('booing_date_time_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:booing_date_times,id',
        ];
    }
}
