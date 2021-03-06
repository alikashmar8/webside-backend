<?php

namespace App\Http\Controllers;

use App\Enums\ProjectType;
use App\Models\Project;
use Intervention\Image\Facades\Image;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Http\Request;
use Validator;


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
        return response()->json($projects, 200);
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
    /*public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        return response()->json([$projects], 200);
    }*/

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'url' => 'required|url',
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
        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $input = $request->all();

        if ($image = $request->file('image')) {
            $imageDestinationPath = 'storage/images/projects/';
            $fileNameToStore = time() . $image->getClientOriginalName();
            $image->move($imageDestinationPath, $fileNameToStore);
            $input['image'] = "$fileNameToStore";
            Project::create($input);
        } else {
            return response()->json(['message' => 'Image should be provided'], 400);
        }
        return response()->json(['message' => 'Project created successfully'], 201);
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
        return response()->json([$project], 200);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'is_done' => 'required',
            'type' => ['required', new EnumValue(ProjectType::class)],
        ])
        ]);

        // TODO: check if image passed
        $project->update($request->all());

        return response()->json(['message' => 'project created successfully'], 201);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $input = $request->all();
        if ($image = $request->file('image')) {
            $imageDestinationPath = 'storage/images/projects/';
            $fileNameToStore = time() . $image->getClientOriginalName();
            $image->move($imageDestinationPath, $fileNameToStore);
            $input['image'] = "$fileNameToStore";
        } else {
            unset($input['image']);
        }
        $project->update($input);

        return response()->json(['message' => 'project updated successfully'], 201);
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
        $project->delete();
        return response()->json(['message' => 'project deleted successfully'], 201);
    }
}
