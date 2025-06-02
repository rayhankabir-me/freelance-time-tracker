<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateRequest;
use App\Http\Requests\TimeLogRequest;
use App\Http\Resources\TimeLogResource;
use App\Models\TimeLog;
use App\Services\ProjectService;
use App\Services\TimeLogService;
use Exception;
use Illuminate\Http\Request;

class TimeLogController extends Controller
{
    private TimeLogService $timeLogService;


    public function __construct(TimeLogService $timeLogService)
    {
        $this->timeLogService = $timeLogService;
    }

    public function index(PaginateRequest $request)
    {
        try {
            return TimeLogResource::collection($this->timeLogService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function manual(TimeLogRequest $request)
    {
        try {
            return new TimeLogResource($this->timeLogService->manual($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function start(Request $request)
    {
        try {
            return new TimeLogResource($this->timeLogService->start($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function end(Request $request, TimeLog $timeLog)
    {
        try {
            return new TimeLogResource($this->timeLogService->end($request, $timeLog));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(TimeLog $timeLog)
    {
        try {
            $this->timeLogService->destroy($timeLog);
            return response('', 202);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(TimeLog $timeLog)
    {
        try {
            return new TimeLogResource($this->timeLogService->show($timeLog));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
