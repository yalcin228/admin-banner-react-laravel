<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $results = Log::with(['admin'])->where(['status' => 1, 'deleted_at' => null])->orderBy('id', 'DESC')->paginate(10);
        $result = User::where(['deleted_at' => null, 'status' => 'active'])->get();

        return view('admin.pages.logs.index',[
            'results' => $results,
            'admins'  => $result
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    //Admin search All
    public static function getModuleSearch(Request $request, $module, $path, $viewFile, $mainPath = 'admin')
    {
        $data = $request->all();

        $column_name = $request->get('column_name');
        $order_type = $request->get('order_type');
        //delete first element in data array
        array_shift($data);

        //get table name
        $appPrefix = $module == 'user' ? 'App' : 'App\Models';

        $modelName = $appPrefix . '\\' . ucfirst($module);

        $result = $modelName::where('deleted_at', null);

        foreach ($data as $key => $value) {
            if ($key != 'page' && $key != 'column_name' && $key != 'order_type') {
                $result->$key($value);
            }
        }

        if ($column_name) {
            $result->column_name($column_name, $order_type);
        }

        $results = $result->orderBy('id', 'DESC')->paginate(10);
        // $count = BaseController::count();
        $data = [
            'results' => $results,
            'module' => $module,
            // 'count' => $count,
        ];

        if ($modelName == 'App\Models\Log') {
            $admins = User::where(['deleted_at' => null])->get();
            $data['admins'] = $admins;
        }

        return view($mainPath . '.' . $path . '.' . $viewFile, $data);
    }

    public static function postLog($info, $action, $module, $ip)
    {

        $module = isset($module) ? $module : 'Xəbərlər';

        $log = Log::create([
            'admin_id' => auth()->user()->id,
            'info' => $info,
            'action' => $action,
            'module' => $module,
            'ip' => $ip,
            'status' => 1,
        ]);

        return $log;
    }

}
