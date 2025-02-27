<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\Task\CreateTask;
use App\Http\Requests\Task\UpdateTask;
use App\Helpers\HttpResponseHelper;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10); // Number of items per page
            $page = $request->query('page', 1); // Page number
            $status = $request->query('status', 'pending'); // Default filter: pending tasks
            $sortBy = $request->query('sort_by', 'created_at'); // Default sorting column
            $sortOrder = $request->query('sort_order', 'desc'); // Default sorting order
    
            if (!is_numeric($perPage) || !is_numeric($page)) {
                return HttpResponseHelper::error('Invalid per_page or page parameter', 400);
            }
    
            // Query Builder
            $query = Task::with('user');
    
            // Filtering by Status (default is "pending")
            if (!in_array($status, ['completed', 'pending'])) {
                return HttpResponseHelper::error('Invalid status parameter', 400);
            }
            $query->where(['status' => $status,'user_id'=>auth()->user()->id]);
    
            // Sorting (default is "created_at desc")
            if (!in_array($sortBy, ['created_at', 'updated_at', 'title'])) {
                return HttpResponseHelper::error('Invalid sort_by parameter', 400);
            }
    
            if (!in_array($sortOrder, ['asc', 'desc'])) {
                return HttpResponseHelper::error('Invalid sort_order parameter', 400);
            }
    
            $query->orderBy($sortBy, $sortOrder);
    
            // Pagination
            $tasks = $query->paginate($perPage, ['*'], 'page', $page);
    
            return HttpResponseHelper::success($tasks, 'Tasks retrieved successfully', 200);
        } catch (\Exception $e) {
            return HttpResponseHelper::error($e->getMessage(), 500, []);
        }
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTask $request)
    {
        try{
            $inputs=$request->only(['title','description']);
            $inputs['user_id']=auth()->user()->id;
            $task=Task::create($inputs);
            return HttpResponseHelper::success($task,'Task created successfully');

        }
        catch(\Exception $e){
            return HttpResponseHelper::error($e->getMessage(),500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTask $request, Task $task)
    {
        try{
            $inputs=$request->only(['title','description','status']);
            $task->fill($inputs);
            $task->save();
            return HttpResponseHelper::success($task,'Task updated successfully');
        }
        catch(\Exception $e){
            return HttpResponseHelper::error($e->getMessage(),500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task)
    {
     
        try{
            if($task->user_id!==auth()->user()->id){
                return HttpResponseHelper::error('You are not authorized to delete this task',403);
            }
            $task->delete();
            return HttpResponseHelper::success($task,'Task deleted successfully');
        }
        catch(\Exception $e){
            return HttpResponseHelper::error($e->getMessage(),500);
        }
    }
}
