<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BannersResource;
use App\Models\BannerAds;
use App\Models\Site;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public function index($id)
    {
        try {
            $sites = Site::findOrFail($id);
            $banners = BannerAds::banners($sites->id)
                            ->with(['sites', 'siteCategory'])
                            ->orderBy('created_at', 'DESC')
                            ->paginate(10);

            return BannersResource::collection($banners);
        } catch (Exception $error) {
            
            return response()->json([
                'message' => $error->getMessage(),
                'status' => Response::HTTP_NOT_FOUND
                ]);
        }
    }
}
