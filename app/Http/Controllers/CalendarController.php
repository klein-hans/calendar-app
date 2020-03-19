<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Calendar;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Validator;

class CalendarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $_table;

    public function __construct(Calendar $table)
    {
        // $this->middleware('auth');
        $this->_table = $table;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calendar = $this->_table::all();

        return response($calendar, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make
        (
            $request->all(),
            [
                'event_name' => 'required|max:50',
                'start_date' => 'required',
            ],
            [
                'event_name.required' => 'Event is required!',
                'event_name.max' => 'Limit of 50 characters exceeded!',
                'start_date.required' => 'Date is required!',
            ]
        );
        
        if ($validator->fails()) 
        {
            return response(['error' => $validator->errors()], 200);
        }
        else
        {
            if($request->input('end_date') != null)
            {
                if(Carbon::parse($request->input('start_date'))->format('Y-m-d') > Carbon::parse($request->input('end_date'))->format('Y-m-d'))
                {
                    return response(['error' => ['end_date' => 'End Date should be greater than the Start Date!']], 200);
                }
                else
                {
                    $ranges = CarbonPeriod::create
                    (
                        Carbon::parse($request->input('start_date'))->format('Y-m-d'), 
                        Carbon::parse($request->input('end_date'))->format('Y-m-d')
                    );

                    if($request->input('days') == null)
                    {
                        foreach ($ranges as $date) 
                        {
                            $calendar = Calendar::create([
                                'event_name' => $request->input('event_name'),
                                'event_date' => $date->format('Y-m-d'),
                                'created_by' => 'admin@admin.com',
                                'updated_by' => 'admin@admin.com'
                            ]);
                            
                            $calendar->save();
                        }
                    }
                    else if($request->input('days') != null)
                    {
                        foreach ($ranges as $date) 
                        {
                            foreach ($request->input('days') as $day)
                            {
                                if($date->format('D') == $day)
                                {
                                    $calendar = Calendar::create([
                                        'event_name' => $request->input('event_name'),
                                        'event_date' => $date->format('Y-m-d'),
                                        'created_by' => 'admin@admin.com',
                                        'updated_by' => 'admin@admin.com'
                                    ]);
                                    
                                    $calendar->save();
                                }
                            }
                        }
                    }
                }
            }
            else if($request->input('end_date') == null)
            {
                $calendar = Calendar::create([
                    'event_name' => $request->input('event_name'),
                    'event_date' => Carbon::parse($request->input('start_date')),
                    'created_by' => 'admin@admin.com',
                    'updated_by' => 'admin@admin.com'
                ]);
                
                $calendar->save();
            }
        }   

        return response(['message' => "Event successfully saved!"], 200);
    }
}
