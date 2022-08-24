<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSiteRequest;
use App\Http\Requests\UpdateSiteApiRequest;
use App\Http\Resources\ApiSiteByIdResource;
use App\Http\Resources\ApiSiteResource;
use App\Models\Site;

/**
 * @method static where(string $string, string $string1, int $int)
 */
class SiteController extends Controller
{

    public function index()
    {
        $sites = Site::orderByDesc('id')->paginate(7);

        return response()->json([
            'data' => ApiSiteResource::collection($sites)->response()->getData(true),
            'statusCode' => 200
        ]);
    }

    public function getSitesWithoutPaginate()
    {
        $sites = Site::orderByDesc('id')->get();

        return response()->json([
            'data' => ApiSiteResource::collection($sites),
            'statusCode' => 200
        ]);
    }


    public function store(CreateSiteRequest $request)
    {
        try {
            $request->validated();

            $site = Site::create([
                'name' => $request->name,
                'status' => $request->status
            ]);

            LogController::postLog($site->id, 'Site Yaratma', 'Sayt Parametrləri', $request->ip());

            return response()->json([
                'status' => true,
                'message' => 'Site was created.',
                'statusCode' => 201
            ]);
        } catch (\Exception $exception) {
            return response([
                'statusCode' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'success' => false
            ]);
        }
    }

    public function show($id)
    {
        try {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Site not found.',
                    'statusCode' => 404
                ]);
            }

            $site = Site::find($id);

            return response()->json([
                'site' => ApiSiteByIdResource::make($site),
                'statusCode' => 200
            ]);
        } catch (\Exception $exception) {
            return response([
                'statusCode' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'success' => false
            ]);
        }
    }

    public function update(UpdateSiteApiRequest $request, $id)
    {
        try {
            $request->validated();

            $site = Site::whereId($id)->first();

            if (!$site) {
                return response()->json([
                    'status' => false,
                    'message' => 'Site not found.',
                    'statusCode' => 404
                ]);
            }

            $site->update([
                'name' => $request->name ?? $site->name,
                'status' => $request->status ?? $site->status
            ]);

            LogController::postLog($site->id, 'Site Redaktə', 'Sayt Parametrləri', $request->ip());

            return response()->json([
                'status' => true,
                'message' => 'Site was updated.',
                'data' => ApiSiteByIdResource::make($site)
            ]);
        } catch (\Exception $exception) {
            return response([
                'statusCode' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'success' => false
            ]);
        }
    }


    public function destroy($id)
    {
        if (Site::whereId($id)->count() == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Site not found!',
                'statusCode' => 404
            ]);
        }

        $site = Site::find($id);
        LogController::postLog($site->id, 'Sayt Silinmesi', 'Sayt Parametrləri', \request()->ip());
        $site->delete();
        $site->places()->delete();

        return response()->json(['status' => true, 'message' => 'Site was deleted.', 'statusCode' => 200]);
    }
}
