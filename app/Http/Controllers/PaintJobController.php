<?php

namespace App\Http\Controllers;

use App\PaintJob;
use Illuminate\Http\Request;


class PaintJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of all cars.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCars()
    {
        $online = PaintJob::where('queued', 0)
                ->orderBy('created_at', 'DESC')->get();

        $queued = PaintJob::where('queued', 1)
                ->orderBy('created_at', 'DESC')->get();

        $total = PaintJob::where('queued', 2)->count();

        $totalBlue = PaintJob::where([
                        ['queued', 2],
                        ['target_color', 'blue']
                    ])->count();

        $totalGreen = PaintJob::where([
                        ['queued', 2],
                        ['target_color', 'green']
                    ])->count();

        $totalRed = PaintJob::where([
                        ['queued', 2],
                        ['target_color', 'red']
                    ])->count();                

        return view('queue', compact('queued', 'online', 'total', 'totalBlue', 'totalGreen' , 'totalRed'));
    }

    /**
     * Display a listing of queued paint jobs which will update first.
     *
     * @return \Illuminate\Http\Response
     */
    public function countOnProgress()
    {
        $cars = PaintJob::where('queued', 0)->count();

        switch ($cars) {
            case 5:
                return $cars;
                break;
            default:
                $old = PaintJob::oldest()->where('queued', 1)->first();
                PaintJob::where('id', $old['id'])->update(['queued' => 0]);
                break;
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'plate_no' => 'required|regex:/^[A-Z]{1,3} [0-9]{1,3}$/',
            'curr' => 'required',
            'target' => 'required|different:curr'
        ]);

        $count = PaintJob::where('queued', 0)->count();
        $queue = ($count >= 5 ? 1 : 0);

        $jobs = PaintJob::create(array(
            'plate_number' => $request->input('plate_no'),
            'curr_color' => $request->input('curr'),
            'target_color' => $request->input('target'),
            'queued' => $queue,
        ));

        return response()->json([
            'message' => 'success',
            'status' => 200,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaintJob  $paintJob
     * @return \Illuminate\Http\Response
     */
    public function show(PaintJob $paintJob)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaintJob  $paintJob
     * @return \Illuminate\Http\Response
     */
    public function edit(PaintJob $paintJob)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaintJob  $paintJob
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaintJob $paintJob, $id)
    {
        $finishJob = $paintJob->where('id', $id)->update(['queued' => 2]);

        if ($finishJob) {
            return response()->json([
                'message' => 'Paint job done!',
            ]);
        }      

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaintJob  $paintJob
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaintJob $paintJob)
    {
        //
    }
}
