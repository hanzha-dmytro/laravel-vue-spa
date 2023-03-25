<?php

namespace App\Http\Controllers;

use App\Http\Filters\PageFilter;
use App\Http\Requests\PageIndexRequest;
use App\Http\Requests\PageSaveRequest;
use App\Http\Resources\PageResource;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(PageIndexRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return PageResource::collection(
            Page::filter(new PageFilter($request))->paginate(Page::PAGINATION_LIMIT)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PageSaveRequest $request
     * @return PageResource
     */
    public function store(PageSaveRequest $request): PageResource
    {
        $page = Page::create($request->validated());
        return new PageResource($page);
    }

    /**
     * Display the specified resource.
     *
     * @param Page $page
     * @return PageResource
     */
    public function show(Page $page): PageResource
    {
        return new PageResource($page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PageSaveRequest $request
     * @param Page $page
     * @return PageResource
     */
    public function update(PageSaveRequest $request, Page $page): PageResource
    {
        $page->update($request->validated());
        return new PageResource($page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Page $page
     * @return bool|null
     */
    public function destroy(Page $page): ?bool
    {
        return $page->delete();
    }

    /**
     * Display all items of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return PageResource::collection(Page::all());
    }
}
