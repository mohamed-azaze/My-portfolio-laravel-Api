<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreprojectRequest;
use App\Http\Requests\UpdateprojectRequest;
use App\Models\project;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class projectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Projects = project::all();

        return response($Projects, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreprojectRequest $request)
    {

        try {
            $request->validated();
            $fullImageName = $request->full_image->getClientOriginalName();
            $bannerImageName = $request->banner_image->getClientOriginalName();

            project::create([
                'name' => $request->name,
                'url' => $request->url,
                'full_image' => $fullImageName,
                'banner_image' => $bannerImageName,
                'languages' => $request->languages,
            ]);
            $request->file('full_image')->storeAs('projects/' . $request->name, $request->file('full_image')->getClientOriginalName(), 'public');
            $request->file('banner_image')->storeAs('projects/' . $request->name, $request->file('banner_image')->getClientOriginalName(), 'public');

            return response()->json([
                'message' => 'project saved successfull',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'samething went wrong',
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(project $project)
    {
        return response($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprojectRequest $request, project $project)
    {
        if ($request->hasFile('full_image')) {
            $request->validate([
                'full_image' => 'image|max:11048|mimes:jpeg,png,jpg,gif',
            ], [
                'full_image.mimes' => 'Websit Image Accepted jpeg, png, jpg, gif',
                'full_image.max' => 'Max Image Size 10 MB',
            ]);
        }
        if ($request->hasFile('banner_image')) {
            $request->validate([
                'banner_image' => 'image|max:11048|mimes:jpeg,png,jpg,gif',
            ], [
                'banner_image.mimes' => 'Banner Image Accepted jpeg, png, jpg, gif',
                'banner_image.max' => 'Max Image Size 10 MB',
            ]);
        }
        $fullImage = public_path("storage/projects/" . $project->name . '/' . $project->full_image);
        $bannerImage = public_path("storage/projects/" . $project->name . '/' . $project->banner_image);
        $fullImageName = '';
        $bannerImageName = '';
        if ($request->name !== $project->name) {
            $fullImgOldPath = "/public/projects/{$project->name}/{$project->full_image}";
            $fullImgNewPath = "/public/projects/{$request->name}/{$project->full_image}";
            $bannerImgOldPath = "/public/projects/{$project->name}/{$project->banner_image}";
            $bannerImgNewPath = "/public/projects/{$request->name}/{$project->banner_image}";
            if ($request->hasFile('full_image')) {
                if (File::exists($fullImage)) {
                    File::delete($fullImage);
                }
                $fullImageName = $request->file('full_image')->getClientOriginalName();
                $request->file('full_image')
                    ->storeAs('projects/' . $request->name, $fullImageName, 'public');
            } else {
                Storage::move($fullImgOldPath, $fullImgNewPath);
                $fullImageName = $project->full_image;
            }
            if ($request->hasFile('banner_image')) {
                if (File::exists($bannerImage)) {
                    File::delete($bannerImage);
                }
                $bannerImageName = $request->file('banner_image')->getClientOriginalName();
                $request->file('banner_image')
                    ->storeAs('projects/' . $request->name, $bannerImageName, 'public');
            } else {
                Storage::move($bannerImgOldPath, $bannerImgNewPath);
                $bannerImageName = $project->banner_image;
            }
        } else {
            if ($request->hasFile('full_image')) {
                if (File::exists($fullImage)) {
                    File::delete($fullImage);
                }
                $fullImageName = $request->file('full_image')->getClientOriginalName();
                $request->file('full_image')
                    ->storeAs('projects/' . $request->name, $fullImageName, 'public');
            } else {
                $fullImageName = $project->full_image;
            };
            if ($request->hasFile('banner_image')) {
                if (File::exists($bannerImage)) {
                    File::delete($bannerImage);
                }
                $bannerImageName = $request->file('banner_image')->getClientOriginalName();
                $request->file('banner_image')
                    ->storeAs('projects/' . $request->name, $bannerImageName, 'public');
            } else {
                $bannerImageName = $project->banner_image;
            }
        }

        $project->update([
            'name' => $request->name,
            'url' => $request->url,
            'full_image' => $fullImageName,
            'banner_image' => $bannerImageName,
            'languages' => $request->languages,
        ]);

        return response($project, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(project $project)
    {
        $fullImage = public_path("storage/projects/" . $project->name . '/' . $project->full_image);
        $bannerImage = public_path("storage/projects/" . $project->name . '/' . $project->banner_image);
        File::delete($fullImage);
        File::delete($bannerImage);
        $project->delete();

        return response("", 204);
    }
}
