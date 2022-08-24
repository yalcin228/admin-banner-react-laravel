<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SiteCategoryStoreRequest;
use App\Http\Requests\Admin\SiteCategoryUpdateRequest;
use App\Models\Site;
use App\Models\SiteCategory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SiteCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = SiteCategory::orderBy('id', 'DESC')
                            ->with('sites')
                            ->paginate(10);
        return view('admin.pages.site-category.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sites = Site::get()->pluck('name', 'id');

        return view('admin.pages.site-category.create', ['sites' => $sites]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\SiteCategoryStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteCategoryStoreRequest $request)
    {
        $data = $request->validated();

        if ($request->has('image')) {
            $image = Storage::disk('public')->put('/site-category', $request->image);
            $img = basename($image);
            Image::make($request->file('image')->getRealPath())->resize(1250, 800)->save(storage_path() . '/app/public/site-category/' . $img);
        }

        $data['image'] = $img;
        $site = SiteCategory::create($data);
        LogController::postLog($site->id, 'Elave edildi', 'Site Kateqoriya', $request->ip());
        return redirect()->route('site-category.index')->with('success', 'Site Kateqori elave edildi!');
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
    public function edit(SiteCategory $siteCategory)
    {
        $sites = Site::get()->pluck('name', 'id');

        return view('admin.pages.site-category.edit',[
            'siteCategory' => $siteCategory, 
            'sites' => $sites
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SiteCategoryUpdateRequest $request, SiteCategory $siteCategory)
    {
        $data = $request->validated();

        if ($request->has('image')) {
            $image = Storage::disk('public')->put('/site-category', $request->image);
            $img = basename($image);
            Image::make($request->file('image')->getRealPath())->resize(1250, 800)->save(storage_path() . '/app/public/site-category/' . $img);
        }

        $siteCategory->update([
            'site_id' => $data['site_id'],
            'place'   => $data['place'],
            'type'    => $data['type'],
            'status'  => $data['status'],
            'image'   => $img ?? $siteCategory->image
        ]);

        LogController::postLog($siteCategory->id, 'Redakte etdi', 'Site Kateqoriya', $request->ip());

        return redirect()->route('site-category.index')->with('success', 'Dəyişiklik edildi!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteCategory $siteCategory)
    {
        $siteCategory->delete();

        LogController::postLog($siteCategory->id, 'Silme işləmi', 'Site Kateqoriya', request()->ip());
        return response()->json(['status' => 200, 'situation' => 'success', 'title' => 'Silmə əməliyyatı', 'message' => 'Məlumat silindi']);
    }
}
