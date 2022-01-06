<?php

namespace App\Http\Controllers;

use App\Enums\ProjectType;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return response()->json(['projects' => $projects], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'is_done' => 'required',
            'type' => ['required', new EnumValue(ProjectType::class)],
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($request->hasFile('images')) {
            $project = Project::create($request->all());
            $image = $request->image;
            $destinationPath = public_path('storage/projects_images/');
            $fileNameToStore = time() . $image->getClientOriginalName();
            $img = Image::make($image->getRealPath());
            $img->resize(650, 650, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $fileNameToStore);
            $project->image = $fileNameToStore;
            $project->save();
            $destinationPath = public_path('/storage/images');
        } else {
            return response()->json(['message' => 'Image should be provided'], 400);
        }
        return response()->json(['message' => 'project created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response()->json(['project' => $project], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'is_done' => 'required',
            'type' => ['required', new EnumValue(ProjectType::class)],
        ]);

        // TODO: check if image passed
        $project->update($request->all());

        return response()->json(['message' => 'project created successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
