<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\Admin\TodoResource;
use App\Models\Todo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoApiController extends Controller
{
    public function index()
    {
        return new TodoResource(Todo::with(['createdBy'])->get());
    }

    public function store(StoreTodoRequest $request)
    {
        $request->merge(['status' => 0]);
        $todo = new Todo($request->all());
        $todo->createdBy()->associate(auth()->user());
        $todo->save();

        return (new TodoResource($todo))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Todo $todo)
    {
        return new TodoResource($todo->load(['createdBy']));
    }

    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $todo->update($request->all());

        return (new TodoResource($todo))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
