<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiGetLogByIdResource;
use App\Http\Resources\ApiLogListResource;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{

    public function index()
    {
        try {
            $logs = Log::with('admin')->orderByDesc('id')->paginate(10);
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'data' => ApiLogListResource::collection($logs)->response()->getData(true)
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'statusCode' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        if (!Log::whereId($id)->count() > 0) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Log not found!'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => ApiGetLogByIdResource::make(Log::find($id)),
            'statusCode' => 200
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $log_id = $request->id;
        $admin = $request->admin;
        $info = $request->info;
        $ip = $request->ip;
        $date = $request->date;

        $result = Log::where(function ($q) use ($log_id, $admin, $info, $ip, $date) {
            if ($log_id) {
                $q = $q->id($log_id);
            }
            if ($admin) {
                $q = $q->admin($admin);
            }
            if ($info) {
                $q = $q->info($info);
            }
            if ($ip) {
                $q = $q->ip($ip);
            }
            if ($date) {
//                $q = $q->where('created_at', 'LIKE', '%' . $date . '%');
                $q = $q->date($date);
            }
            return $q;
        })->paginate(10);

        return response()->json([
            'success' => true,
            'data' => ApiLogListResource::collection($result)->response()->getData(true),
            'statusCode' => 200
        ]);

    }
}
