<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerCreateRequest;
use App\Http\Requests\Banner\BannerUpdateRequest;
use App\Models\BannerAds;
use App\Models\Site;
use App\Models\SiteCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $banners = BannerAds::with(['sites', 'sites.place'])->orderByDesc('id')->paginate(10);

        return view('admin.pages.banner.index', ['banners' => $banners]);
    }

    /**
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
        $sites = Site::orderByDesc('id')->get();
        $categories = SiteCategory::orderByDesc('id')->get();

        return \view('admin.pages.banner.create', ['sites' => $sites, 'categories' => $categories]);
    }


    /**
     * @param BannerCreateRequest $request
     * @return RedirectResponse
     */
    public function store(BannerCreateRequest $request): RedirectResponse
    {
        $vd = $request->validated();

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
                return redirect()->route('banner.index')->with('success', 'Bura reklam yerləşdirmə limiti dolmuşdur.');
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



        return redirect()->route('banner.index')->with('success', 'Banner əlavə edildi.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }


    /**
     * @param BannerAds $banner
     * @return Factory|View|Application
     */
    public function edit(BannerAds $banner): Factory|View|Application
    {
        $sites = Site::orderByDesc('id')->get();
        $categories = SiteCategory::where('site_id', $banner->site_id)->get();

        return \view('admin.pages.banner.edit',
            [
                'sites' => $sites,
                'categories' => $categories,
                'banner' => $banner
            ]);
    }


    /**
     * @param BannerUpdateRequest $request
     * @param BannerAds $banner
     * @return RedirectResponse
     */
    public function update(BannerUpdateRequest $request, BannerAds $banner): RedirectResponse
    {
        $vd = $request->validated();

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
                return redirect()->route('banner.index')->with('success', 'Bura reklam yerləşdirmə limiti dolmuşdur.');
        }

        $banner->update([
            'ads' => $vd['ads'] ?? $banner->ads,
            'site_id' => $vd['site_id'] ?? $banner->site_id,
            'category_id' => $vd['category_id'] ?? $banner->category_id,
            'sort' => $sort,
            'datetime' => Carbon::parse(now())->format('Y-m-d H:i:s') ?? $banner->datetime,
            'status' => $request->status
        ]);

        LogController::postLog($banner->id,'Banner Redaqtəsi','Banner Parametrləri',$request->ip());

        return redirect()->route('banner.index')->with('success', 'Banner radaktə edildi.');
    }


    /**
     * @param BannerAds $banner
     * @return JsonResponse
     */
    public function destroy(BannerAds $banner): JsonResponse
    {
        $banner->delete();

        LogController::postLog($banner->id,'Banner Silinmesi','Banner Parametrləri',\request()->ip());

        return response()->json(['status' => true]);
    }

    public function getCategories(Request $request): JsonResponse
    {
        $categories = DB::table('site_categories')
            ->where('site_id', $request->site_id)
            ->get();

        return \response()->json([
            'data' => $categories
        ]);
    }

    public function getCategoryImage(Request $request): JsonResponse
    {
        $image = SiteCategory::find($request->category_id);

        return \response()->json([
            'image' => $image
        ]);
    }
}
