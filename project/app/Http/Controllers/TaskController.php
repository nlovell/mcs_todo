<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(Tasks::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->input();
        $validator = Validator::make($data, [
            'task' => 'required|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
            ]);
        }

        $task = new Tasks();
        $task->task = $data['task'];
        $task->save();

        return response()->json([
            'success' => true,
            'task_id' => $task->id,
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->input();
        $validator = Validator::make($data, [
            'task' => 'required|max:255',
            'done' => 'nullable',
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->messages(),
            ]);
        }

        $task = Tasks::findOrFail($id);
        $task->task = $data['task'];
        $task->done = $data['done'];
        $task->save();

        return response()->json([
            'success' => true,
            'task_id' => $task->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $task = Tasks::find($id);

        $task->delete();

        return response()->json([
            'success' => true,]);
    }
}
