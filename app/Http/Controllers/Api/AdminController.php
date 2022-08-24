<?php

namespace App\Http\Controllers\Api;

use App\Enum\StatusEnum;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\ApiAdminListResource;
use App\Http\Resources\ApiAdminShowResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::paginate(7);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'data' => ApiAdminListResource::collection($users)->response()->getData(true)
        ]);
    }

    public function getAdminsWithoutPaginate(): \Illuminate\Http\JsonResponse
    {
        $users = User::all();

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'data' => ApiAdminListResource::collection($users)
        ]);
    }

    public function store(AdminStoreRequest $request)
    {
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
        $token = $admin->createToken('token_name')->plainTextToken;

        $admin->assignRole($request->input('roles'));

        SmsController::SendSms(('994' . substr($admin->phone, 1)), "Hörmətli idarəçi,aşağıdaki məlumatlarla idarə panelinə daxil ola bilərsiniz \r\nSayt: Vesti.az \r\nİstifadəçi adı: " . $admin->username . "\r\nŞifrə: " . $request->get('password') . "\r\nAdmin panelə giriş :" . URL::to('/vesti/admin'));
        LogController::postLog($admin->id, 'Elave edildi', 'Admin', $request->ip());

        return response()->json([
            'status' => true,
            'message' => 'Admin was created.',
            'statusCode' => 201,
            'token' => $token
        ]);
    }

    public function show($id)
    {
        if (User::whereId($id)->count() == 0) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'User not found!'
            ]);
        }

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'data' => ApiAdminShowResource::make(User::find($id))
        ]);
    }

    public function update(AdminUpdateRequest $request, $id)
    {
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
            'password' => $request->has('password') && $request->password !== '' && $request->password !== null ? Hash::make($request->get('password')) : $admin->password
        ]);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $admin->assignRole($request->input('roles'));

        LogController::postLog($admin->id, 'Redakte etdi', 'Admin', $request->ip());

        return response()->json([
            'status' => true,
            'message' => 'User updated.',
            'statusCode' => 201
        ]);
    }

    public function destroy($id)
    {
        if (!User::whereId($id)->count() > 0) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'User not found!'
            ]);
        }

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user = User::find($id);
        LogController::postLog($user->id, 'Silmek', 'Admin', \request()->ip());
        $user->delete();

        return response()->json(['status' => true, 'message' => 'Admin was deleted.', 'statusCode' => 200]);

    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $credentials = $request->only('username', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('username', $data['username'])->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'status'=> 200
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Cixis edildi','statusCode'=> 200]);
    }
}
