<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Slug_Translations;
use Modules\Icommerce\Http\Requests\CreateSlug_TranslationsRequest;
use Modules\Icommerce\Http\Requests\UpdateSlug_TranslationsRequest;
use Modules\Icommerce\Repositories\Slug_TranslationsRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class Slug_TranslationsController extends AdminBaseController
{
    /**
     * @var Slug_TranslationsRepository
     */
    private $slug_translations;

    public function __construct(Slug_TranslationsRepository $slug_translations)
    {
        parent::__construct();

        $this->slug_translations = $slug_translations;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$slug_translations = $this->slug_translations->all();

        return view('icommerce::admin.slug_translations.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.slug_translations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSlug_TranslationsRequest $request
     * @return Response
     */
    public function store(CreateSlug_TranslationsRequest $request)
    {
        $this->slug_translations->create($request->all());

        return redirect()->route('admin.icommerce.slug_translations.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::slug_translations.title.slug_translations')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Slug_Translations $slug_translations
     * @return Response
     */
    public function edit(Slug_Translations $slug_translations)
    {
        return view('icommerce::admin.slug_translations.edit', compact('slug_translations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Slug_Translations $slug_translations
     * @param  UpdateSlug_TranslationsRequest $request
     * @return Response
     */
    public function update(Slug_Translations $slug_translations, UpdateSlug_TranslationsRequest $request)
    {
        $this->slug_translations->update($slug_translations, $request->all());

        return redirect()->route('admin.icommerce.slug_translations.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::slug_translations.title.slug_translations')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Slug_Translations $slug_translations
     * @return Response
     */
    public function destroy(Slug_Translations $slug_translations)
    {
        $this->slug_translations->destroy($slug_translations);

        return redirect()->route('admin.icommerce.slug_translations.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::slug_translations.title.slug_translations')]));
    }
}
