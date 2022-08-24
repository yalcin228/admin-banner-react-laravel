<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Api\SiteCategoryResource;
use App\Models\SiteCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SiteCategoryController extends Controller
{

    public function index(): JsonResponse|AnonymousResourceCollection
    {
        try {
            $site_category = SiteCategory::orderBy('id', 'DESC')
                ->with('sites')
                ->paginate(10);

            return SiteCategoryResource::collection($site_category);
        } catch (Exception $error) {

            return response()->json([
                'message' => $error->getMessage(),
                'status' => Response::HTTP_NOT_FOUND
            ]);
        }
    }


    /**
     * @param CreateCategoryRequest $request
     * @return JsonResponse
     */
    public function store(CreateCategoryRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->has('image')) {
                $image = Storage::disk('public')->put('/site-category', $request->image);
                $img = basename($image);
                Image::make($request->file('image')->getRealPath())->resize(1250, 800)->save(storage_path() . '/app/public/site-category/' . $img);
            }

            $data['image'] = $img;
            $site = SiteCategory::create($data);

            LogController::postLog($site->id,'Site Yaratmaq','Sayt Parametrləri',$request->ip());

            return \response()->json([
                'success' => true,
                'message' => 'Kateqoriya əlavə edildi',
                'statusCode' => Response::HTTP_CREATED
            ]);
        }catch (Exception $exception){
            return \response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'statusCode' => $exception->getCode()
            ]);
        }
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            if (!SiteCategory::find($id)){
                return \response()->json([
                    'success' => false,
                    'message' => 'Category not found!',
                    'statusCode' => 404
                ]);
            }

            return \response()->json([
                'success' => true,
                'message' => SiteCategoryResource::make(SiteCategory::find($id)),
                'statusCode' => Response::HTTP_FOUND
            ]);

        }catch (Exception $exception){
            return \response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'statusCode' => $exception->getCode()
            ]);
        }
    }


    /**
     * @param UpdateCategoryRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, $id): JsonResponse
    {
        try{
            $data = $request->validated();

            if (!SiteCategory::find($id)){
                return \response()->json([
                    'success' => false,
                    'message' => 'Category not found!',
                    'statusCode' => 404
                ]);
            }

            if ($request->has('image')) {
                $image = Storage::disk('public')->put('/site-category', $request->image);
                $img = basename($image);
                Image::make($request->file('image')->getRealPath())->resize(1250, 800)->save(storage_path() . '/app/public/site-category/' . $img);
            }

            $siteCategory = SiteCategory::find($id);

            $siteCategory->update([
                'site_id' => $data['site_id'],
                'place'   => $data['place'],
                'type'    => $data['type'],
                'status'  => $data['status'],
                'image'   => $img ?? $siteCategory->image
            ]);

            LogController::postLog($siteCategory->id,'Site Redaktə','Sayt Parametrləri',$request->ip());

            return \response()->json([
                'success' => true,
                'message' => 'Category updated!',
                'statusCode' => Response::HTTP_NO_CONTENT
            ]);

        }catch (Exception $exception){
            return \response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'statusCode' => $exception->getCode()
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
            if (!SiteCategory::find($id)){
                return \response()->json([
                    'success' => false,
                    'message' => 'Category not found!',
                    'statusCode' => 404
                ]);
            }

            SiteCategory::find($id)->delete();

            return \response()->json([
               'success' => true,
               'message' => 'Category deleted!',
               'statusCode' => Response::HTTP_NO_CONTENT
            ]);
        }catch (Exception $exception){
            return \response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'statusCode' => $exception->getCode()
            ]);
        }
    }
}
