<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = User::orderBy('id', 'desc')->paginate(10);

        return view('admin.pages.admins.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles['roles'] = Role::all()->toArray();

        return view('admin.pages.admins.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\AdminStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreRequest $request)
    {
        try {
            $data = $request->validated();

            $admin = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'ip' => $request->ip(),
                'is_outside' => $data['is_outside'],
                'status' => $data['status'],
                'password' => Hash::make($data['password']),
            ]);

            $admin->assignRole($request->input('roles'));
            // SmsController::SendSms(('994' . substr($admin->phone, 1)), "Hörmətli idarəçi,aşağıdaki məlumatlarla idarə panelinə daxil ola bilərsiniz \r\nSayt: admin-banner.az \r\nİstifadəçi adı: " . $admin->username . "\r\nŞifrə: " . $request->get('password') . "\r\nAdmin panelə giriş :" . URL::to('/admins'));
            SmsController::SendSms(('994' . substr($admin->phone, 1)), "Hörmətli idarəçi,aşağıdaki məlumatlarla idarə panelinə daxil ola bilərsiniz \r\nSayt: Vesti.az \r\nİstifadəçi adı: " . $admin->username . "\r\nŞifrə: " . $request->get('password') . "\r\nAdmin panelə giriş :" . URL::to('/vesti/admin'));

            LogController::postLog($admin->id,'Elave edildi','Admin',$request->ip());

            return to_route('admins.index')->with('success', 'İstifadəçi elave edildi!');

        } catch (\Exception $e) {
            return to_route('admins.index')->with('error', 'İstifadəçi əlavə olunma zamanı xəta baş verdi' . $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result['admin'] = User::with('roles')->find($id);
        $result['roles'] = Role::all();
        $result['adminRole'] = json_decode(json_encode($result['admin']->roles->pluck('id')), true);

        return view('admin.pages.admins.edit', ['result' => $result]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\AdminUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $admin = User::find($id);

            $admin->update([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'ip' => $request->ip(),
                'is_outside' => $data['is_outside'],
                'status' => $data['status'],
            ]);

            if (!empty($request->get('password'))) {
                SmsController::SendSms(('994' . substr($admin->phone, 1)), "Hörmətli idarəçi,aşağıdaki məlumatlarla idarə panelinə daxil ola bilərsiniz \r\nSayt: Admin-banner.az \r\nİstifadəçi adı: " . $admin->username . "\r\nŞifrə: " . $request->get('password') . "\r\nAdmin panelə giriş :" . URL::to('/admins'));
                $admin->update([
                    'password' => Hash::make($request->get('password'))
                ]);
            }

            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $admin->assignRole($request->input('roles'));

            LogController::postLog($admin->id, 'Redakte etdi', 'Admin', $request->ip());

            return to_route('admins.index')->with('success', 'İstifadəçi redaktə olundu');
        } catch (\Exception $e) {
            return to_route('admin.index')->with('success', 'İstifadəçi redakte xəta baş verdi' . $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['status' => 200, 'situation' => 'success', 'title' => 'Silmə əməliyyatı', 'message' => 'İstifadəçi silindi']);
    }
}
