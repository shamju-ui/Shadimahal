<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBooingDateTimeRequest;
use App\Http\Requests\StoreBooingDateTimeRequest;
use App\Http\Requests\UpdateBooingDateTimeRequest;
use App\Models\BooingDateTime;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BooingDateTimeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('booing_date_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booingDateTimes = BooingDateTime::all();

        return view('admin.booingDateTimes.index', compact('booingDateTimes'));
    }

    public function create()
    {
        abort_if(Gate::denies('booing_date_time_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.booingDateTimes.create');
    }

    public function store(StoreBooingDateTimeRequest $request)
    {
        $booingDateTime = BooingDateTime::create($request->all());

        return redirect()->route('admin.booing-date-times.index');
    }

    public function edit(BooingDateTime $booingDateTime)
    {
        abort_if(Gate::denies('booing_date_time_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.booingDateTimes.edit', compact('booingDateTime'));
    }

    public function update(UpdateBooingDateTimeRequest $request, BooingDateTime $booingDateTime)
    {
        $booingDateTime->update($request->all());

        return redirect()->route('admin.booing-date-times.index');
    }

    public function show(BooingDateTime $booingDateTime)
    {
        abort_if(Gate::denies('booing_date_time_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.booingDateTimes.show', compact('booingDateTime'));
    }

    public function destroy(BooingDateTime $booingDateTime)
    {
        abort_if(Gate::denies('booing_date_time_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booingDateTime->delete();

        return back();
    }

    public function massDestroy(MassDestroyBooingDateTimeRequest $request)
    {
        $booingDateTimes = BooingDateTime::find(request('ids'));

        foreach ($booingDateTimes as $booingDateTime) {
            $booingDateTime->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
