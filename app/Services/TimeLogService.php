<?php

namespace App\Services;

use App\Http\Requests\TimeLogRequest;
use App\Models\Project;
use App\Models\TimeLog;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PaginateRequest;


class TimeLogService
{
    public $timeLog;
    public $timeLogFilter = ['project_id', 'start_time'];


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

            return TimeLog::where(
                function ($query) use ($requests) {
                    foreach ($requests as $key => $request) {
                        if (in_array($key, $this->timeLogFilter)) {
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

    public function manual(TimeLogRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $project = Project::findOrFail($request['project_id']);
                if ($project->client->user_id !== auth()->id()) {
                    throw new HttpResponseException(
                        response()->json([
                            'message' => "This project isn't belong to you...!"
                        ], 403)
                    );
                }
                $hours = Carbon::parse($request['start_time'])->floatDiffInHours(Carbon::parse($request['end_time']));
                $this->timeLog = TimeLog::create([
                    'project_id' => $request->project_id,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'description' => $request->description,
                    'hours' => $hours,
                ]);
            });
            return $this->timeLog;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function start(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $data = $request->validate([
                    'project_id'  => 'required|exists:projects,id',
                    'description' => 'nullable|string',
                ]);

                $project = Project::findOrFail($data['project_id']);
                if ($project->client->user_id !== auth()->id()) {
                    throw new HttpResponseException(
                        response()->json([
                            'message' => "This project isn't belong to you...!"
                        ], 403)
                    );
                }

                $this->timeLog = TimeLog::create([
                    'project_id' => $data['project_id'],
                    'start_time' => Carbon::now()->format('y-m-d h:m:s'),
                    'description' => $data['description'] ?? "",
                ]);
            });
            return $this->timeLog;
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
    function show(TimeLog $timeLog): TimeLog
    {
        try {
            return $timeLog->load('project');
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */

    public
    function destroy(TimeLog $timeLog)
    {
        try {
            DB::transaction(function () use ($timeLog) {
                $timeLog->delete();
            });
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function end(Request $request, TimeLog $timeLog)
    {
        try {
            DB::transaction(function () use ($request, $timeLog) {
                $this->timeLog = $timeLog;

                if ($this->timeLog->project->client->user_id !== auth()->id()) {
                    throw new HttpResponseException(
                        response()->json([
                            'message' => "This time log isn't belong to you...!"
                        ], 403)
                    );
                }
                $hours = Carbon::parse($this->timeLog->start_time)->floatDiffInHours(Carbon::now()->format('y-m-d h:m:s'));
                $this->timeLog->end_time = Carbon::now()->format('y-m-d h:m:s');
                $this->timeLog->hours = $hours;
                $this->timeLog->save();
            });
            return $this->timeLog;

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 422);
        }
    }


}
