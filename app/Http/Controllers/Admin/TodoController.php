<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTodoRequest;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('todo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $todos = Todo::with(['user'])->get();

        return view('admin.todos.index', compact('todos'));
    }

    public function create()
    {
        abort_if(Gate::denies('todo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.todos.create');
    }

    public function store(StoreTodoRequest $request)
    {
        $todo = Todo::create($request->all());

        return redirect()->route('admin.todos.index');
    }

    public function edit(Todo $todo)
    {
        abort_if(Gate::denies('todo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $todo->load('user');

        return view('admin.todos.edit', compact('todo'));
    }

    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $todo->update($request->all());

        return redirect()->route('admin.todos.index');
    }

    public function show(Todo $todo)
    {
        abort_if(Gate::denies('todo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $todo->load('user');

        return view('admin.todos.show', compact('todo'));
    }

    public function destroy(Todo $todo)
    {
        abort_if(Gate::denies('todo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $todo->delete();

        return back();
    }

    public function massDestroy(MassDestroyTodoRequest $request)
    {
        $todos = Todo::find(request('ids'));

        foreach ($todos as $todo) {
            $todo->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
