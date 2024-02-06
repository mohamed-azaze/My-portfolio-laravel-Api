<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLangToolRequest;
use App\Http\Requests\UpdateLangToolRequest;
use App\Models\LangTool;

class LanguageToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = LangTool::all();
        return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLangToolRequest $request)
    {

        $data = $request->validated();

        $lang = LangTool::create($data);

        return response($lang, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(LangTool $langTool)
    {
        return response($langTool, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLangToolRequest $request, LangTool $langTool)
    {
        $data = $request->validated();
        $langTool->update($data);
        return response($langTool, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LangTool $langTool)
    {
        $langTool->delete();

        return response("", 204);
    }
}
