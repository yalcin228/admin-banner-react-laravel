<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BannerCreateRequest;
use App\Http\Requests\Api\BannerUpdateRequest;
use App\Http\Resources\ApiBannerListResource;
use App\Http\Resources\ApiGetPlaceBySiteIdResource;
use App\Models\BannerAds;
use App\Models\SiteCategory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $banners = BannerAds::with(['sites', 'siteCategory'])->paginate(8);
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'data' => ApiBannerListResource::collection($banners)->response()->getData(true)
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'statusCode' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param BannerCreateRequest $request
     * @return JsonResponse
     */
    public function store(BannerCreateRequest $request): JsonResponse
    {
        try {
            $vd = $request->validated();

            $count = BannerAds::query()->where('category_id', $vd['category_id'])->count();
            $ids = BannerAds::query()->where('category_id', $vd['category_id'])->pluck('id');

            $bool = DB::table('site_categories')->where('site_id', $vd['site_id'])
                    ->where('id', $vd['category_id'])->count() > 0;

            if (!$bool) {
                return \response()->json([
                    'success' => false,
                    'message' => 'The site and category entered are not compatible with each other.',
                    'statusCode' => 400
                ]);
            }

            switch ($count) {
                case 0:
                    $sort = 100;
                    break;
                case 1:
                    $sort = 50;
                    BannerAds::whereIn('id', $ids)->update([
                        'sort' => $sort
                    ]);
                    break;
                case 2;
                    $sort = 33;
                    BannerAds::whereIn('id', $ids)->update([
                        'sort' => $sort
                    ]);
                    break;
                case 3:
                    $sort = 25;
                    BannerAds::whereIn('id', $ids)->update([
                        'sort' => $sort
                    ]);
                    break;
                default:
                    return \response()->json([
                        'success' => false,
                        'message' => 'Banner limit is full.',
                        'statusCode' => 422,
                        'icon' => 'error'
                    ]);
            }

            $banner = BannerAds::create([
                'ads' => $vd['ads'],
                'site_id' => $vd['site_id'],
                'category_id' => $vd['category_id'],
                'sort' => $sort,
                'datetime' => Carbon::parse(now())->format('Y-m-d H:i:s'),
                'status' => $request->status
            ]);

        LogController::postLog($banner->id,'Banner Yaratma','Banner Parametrləri',$request->ip());

            return \response()->json([
                'success' => true,
                'message' => 'Banner created.',
                'statusCode' => 200,
                'icon' => 'success'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'statusCode' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }

    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            if (!BannerAds::whereId($id)->count() > 0) {
                return \response()->json([
                    'success' => false,
                    'message' => 'Banner Not found.',
                    'statusCode' => 404
                ]);
            }

            return \response()->json([
                'success' => true,
                'data' => ApiBannerListResource::make(BannerAds::find($id)),
                'statusCode' => 200
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'statusCode' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }


    }

    /**
     * @param BannerUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(BannerUpdateRequest $request, $id)
    {
        try {
            $vd = $request->validated();

            if (!BannerAds::whereId($id)->count() > 0) {
                return \response()->json([
                    'success' => false,
                    'message' => 'Banner Not found.',
                    'statusCode' => 404
                ]);
            }

            $bool = DB::table('site_categories')->where('site_id', $vd['site_id'])
                    ->where('id', $vd['category_id'])->count() > 0;

            if (!$bool) {
                return \response()->json([
                    'success' => false,
                    'message' => 'The site and category entered are not compatible with each other.',
                    'statusCode' => 400
                ]);
            }

            $count = BannerAds::query()->where('category_id', $vd['category_id'])->count();
            $ids = BannerAds::query()->where('category_id', $vd['category_id'])->pluck('id');

            switch ($count) {
                case 0:
                    $sort = 100;
                    break;
                case 1:
                    $sort = 50;
                    BannerAds::whereIn('id', $ids)->update([
                        'sort' => $sort
                    ]);
                    break;
                case 2;
                    $sort = 33;
                    BannerAds::whereIn('id', $ids)->update([
                        'sort' => $sort
                    ]);
                    break;
                case 3:
                    $sort = 25;
                    BannerAds::whereIn('id', $ids)->update([
                        'sort' => $sort
                    ]);
                    break;
                default:
                    return \response()->json([
                        'success' => false,
                        'message' => 'Banner limit is full.',
                        'statusCode' => 422
                    ]);
            }

            $banner = BannerAds::find($id);

            $banner->update([
                'ads' => $vd['ads'] ?? $banner->ads,
                'site_id' => $vd['site_id'] ?? $banner->site_id,
                'category_id' => $vd['category_id'] ?? $banner->category_id,
                'sort' => $sort,
                'datetime' => Carbon::parse(now())->format('Y-m-d H:i:s') ?? $banner->datetime,
                'status' => $request->status
            ]);

            LogController::postLog($banner->id,'Banner Redaktə','Banner Parametrləri',$request->ip());

            return response()->json([
                'status' => true,
                'message' => ' Banner updated.',
                'statusCode' => 200
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'statusCode' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            if (!BannerAds::whereId($id)->count() > 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Banner not found!',
                    'statusCode' => 404
                ]);
            }

            $banner = BannerAds::find($id);
            LogController::postLog($banner->id, 'Banner Silinmesi', 'Banner Parametrləri', \request()->ip());
            $banner->delete();

            return response()->json(['status' => true, 'message' => 'Banner was deleted.', 'statusCode' => 200]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'statusCode' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function getCategories($id)
    {
        try {
            $sites = SiteCategory::where('site_id', $id)->get();

            return response()->json([
                'success' => true,
                'data' => ApiGetPlaceBySiteIdResource::collection($sites),
                'statusCode' => 200
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'statusCode' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getImageByCategoryId($id): JsonResponse
    {
        try {
            $sites = SiteCategory::find($id);

            if (!$sites){
                return response()->json([
                    'status' => false,
                    'statusCode' => 404,
                    'message' => 'Place not found.'
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $sites?->image,
                'statusCode' => 200
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'statusCode' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }
    }
}
