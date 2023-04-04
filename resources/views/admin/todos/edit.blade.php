@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.todo.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.todos.update", [$todo->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="item">{{ trans('cruds.todo.fields.item') }}</label>
                <input class="form-control {{ $errors->has('item') ? 'is-invalid' : '' }}" type="text" name="item" id="item" value="{{ old('item', $todo->item) }}" required>
                @if($errors->has('item'))
                    <div class="invalid-feedback">
                        {{ $errors->first('item') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.todo.fields.item_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.todo.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Todo::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $todo->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.todo.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection