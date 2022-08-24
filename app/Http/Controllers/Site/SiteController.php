<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Models\Site;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SiteController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $sites = Site::orderByDesc('id')->paginate(10);
        return view('admin.pages.site.index', ['sites' => $sites]);
    }

    /**
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
        return \view('admin.pages.site.create');
    }

    /**
     * @param CreateSiteRequest $request
     * @return RedirectResponse
     */
    public function store(CreateSiteRequest $request): RedirectResponse
    {
        $validatedData = $request->validationData();

        $site =Site::create([
            'name' => $validatedData['name'],
            'status' => $validatedData['status']
        ]);

        LogController::postLog($site->id,'Site Yaratma','Sayt Parametrləri',$request->ip());

        return redirect()->route('sites.index')->with('success', 'Sayt uğurla yaradıldı.');
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
     * @param Site $site
     * @return Application|Factory|View
     */
    public function edit(Site $site): View|Factory|Application
    {
        return \view('admin.pages.site.edit', ['site' => $site]);
    }

    /**
     * @param UpdateSiteRequest $request
     * @param Site $site
     * @return RedirectResponse
     */
    public function update(UpdateSiteRequest $request, Site $site): RedirectResponse
    {
        $validatedData = $request->validationData();

        $site->update([
            'name' => $validatedData['name'] ?? $site->name,
            'status' => $validatedData['status'] ?? $site->status
        ]);

        LogController::postLog($site->id,'Site Redaktə','Sayt Parametrləri',$request->ip());

        return redirect()->route('sites.index')->with('success', 'Sayt uğurla redaktə edildi.');
    }

    /**
     * @param Site $site
     * @return JsonResponse
     */
    public function destroy(Site $site): JsonResponse
    {
        $site->delete();
        LogController::postLog($site->id, 'Sayt Silinmesi', 'Sayt Parametrləri', \request()->ip());
        $site->places()->delete();

        return response()->json(['status' => true]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changeStatus(Request $request): JsonResponse
    {
        Site::find($request->id)->update([
            'status' => $request->status
        ]);

        $request->status == 1 ? $type = 'active' : $type = 'deactivate';

        return response()->json([
            'status' => 200,
            'situation' => 'success',
            'title' => '',
            'message' => 'Status ' . $type . ' edildi'
        ]);
    }
}
