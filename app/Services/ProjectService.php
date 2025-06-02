<?php

namespace App\Services;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PaginateRequest;


class ProjectService
{
    public $project;
    public $projectFilter = ['name', 'email', 'contact_person'];


    /**
     * @throws Exception
     */
    public function list(PaginateRequest $request)
    {
        try {
            $requests = $request->all();
            $method = $request->get('paginate', 0) == 1 ? 'paginate' : 'get';
            $methodValue = $request->get('paginate', 0) == 1 ? $request->get('per_page', 10) : '*';
            $orderColumn = $request->get('order_column') ?? 'id';
            $orderType = $request->get('order_type') ?? 'desc';

            return Project::with('client')->where(
                function ($query) use ($requests) {
                    foreach ($requests as $key => $request) {
                        if (in_array($key, $this->projectFilter)) {
                            $query->where($key, 'like', '%' . $request . '%');
                        }
                    }
                }
            )->orderBy($orderColumn, $orderType)->$method(
                $methodValue
            );
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function store(ProjectRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->project = Project::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'client_id' => $request->client_id,
                    'status' => $request->status,
                    'deadline' => $request->deadline,
                ]);
            });
            return $this->project;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function update(ProjectRequest $request, Project $project)
    {
        try {
            DB::transaction(function () use ($project, $request) {
                $this->project = $project;
                $this->project->title = $request->title;
                $this->project->description = $request->description;
                $this->project->status = $request->status;
                $this->project->client_id = $request->client_id;
                $this->project->deadline = $request->deadline;
                $this->project->save();
            });
            return $this->project;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public
    function show(Project $project): Project
    {
        try {
            return $project->load('client');
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */

    public
    function destroy(Project $project)
    {
        try {
            DB::transaction(function () use ($project) {
                $project->delete();
            });
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }
}
