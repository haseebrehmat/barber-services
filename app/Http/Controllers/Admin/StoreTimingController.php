<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\GeneralSetting;
use App\Models\Admin\StoreTiming;
use Illuminate\Http\Request;

class StoreTimingController extends Controller
{
    public function edit()
    {
        $existingTimings = StoreTiming::currentUser()->get();

        $timings = [];

        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($daysOfWeek as $day)
        {
            $storeTiming = $existingTimings
                ->where('day', $day)
                ->first();
            $timings[$day] = $storeTiming ? $storeTiming->toArray() : [
                'open_time'  => null,
                'close_time' => null,
                'off_day'    => false,
            ];
        }

        return view('admin.timings.edit', compact('timings'));
    }

    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'timings.*.open_time'  => [
                'sometimes',
                function ($attribute, $value, $fail) use ($request) {
                    $day = str_replace(['timings.', '.open_time'], '', $attribute);
                    $offDay = $request->input("timings.$day.off_day");

                    if (!$offDay && !$value)
                    {
                        $fail('The open time is required when the day is not marked as off.');
                    }
                },
            ],
            'timings.*.close_time' => [
                'sometimes',
                function ($attribute, $value, $fail) use ($request) {
                    $day = str_replace(['timings.', '.close_time'], '', $attribute);
                    $offDay = $request->input("timings.$day.off_day");
                    $openTime = $request->input("timings.$day.open_time");

                    if (!$offDay && $openTime && $value && $value <= $openTime)
                    {
                        $fail('The close time must be greater than the open time for the day ' . $day . '');
                    }
                },
            ],
            'timings.*.off_day'    => 'sometimes',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($request->input('timings') as $day => $timing)
        {
            $timing['off_day'] = isset($timing['off_day']) && $timing['off_day'] == "on" ? true : false;
            StoreTiming::updateOrCreate(
                ['user_id' => session('id'), 'day' => $day],
                $timing
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Shop timings updated successfully!');
    }

    public function update_shop_status_color(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'shop_open_status_color'  => 'required|max:100',
            'shop_close_status_color' => 'required|max:100',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        GeneralSetting::where('id', 1)->update($data);

        return redirect()
            ->back()
            ->with('success', 'Store Open/Closed status colors updated successfully!');
    }
}
