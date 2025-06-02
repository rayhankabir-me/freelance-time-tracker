<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateRequest;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Exception;

class ProjectController extends Controller
{
    private ProjectService $projectService;


    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(PaginateRequest $request)
    {
        try {
            return ProjectResource::collection($this->projectService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(ProjectRequest $request)
    {
        try {
            return new ProjectResource($this->projectService->store($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(ProjectRequest $request, Project $project)
    {
        try {
            return new ProjectResource($this->projectService->update($request, $project));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(Project $project)
    {
        try {
            $this->projectService->destroy($project);
            return response('', 202);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(Project $project)
    {
        try {
            return new ProjectResource($this->projectService->show($project));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
