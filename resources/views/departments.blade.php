@extends('layouts.app')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Departments
            @if (Auth::user()->type == "admin")
                <a href="#addDept" data-toggle="modal" data-target="#addDept" class="pull-right"><i class="fa fa-plus fa-fw"></i> Add Department</a>
            @endif
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Department Name</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($departments) == 0)
                        <tr>
                            <td colspan="2" class="text-center">No departments.</td>
                        </tr>
                    @else
                        @foreach ($departments as $department)
                            <tr>
                                <td>{{ $department->name }}</td>
                                <td class="text-center">
                                    @if (Auth::user()->type == "admin")
                                        @if ($department->deleted_at == "" || $department->deleted_at == null)
                                            <a href="/departments/delete/{{ $department->id }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this department?');"><i class="fa fa-trash fa-fw"></i> Delete</a>
                                        @else
                                            <a href="/departments/restore/{{ $department->id }}" class="btn btn-info btn-xs" onclick="return confirm('Are you sure you want to restore this department');"><i class="fa fa-undo fa-fw"></i> Restore</a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="pull-right">
        {!! $departments->links() !!}
    </div>

    <div id="addDept" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form action="/departments/save" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-users fa-fw"></i> Add Department</h4>
                    </div>
                    <div class="modal-body">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Name</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required />

                            @if ($errors->has('username'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-fw"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(function() {
            $('.departments').addClass('active');
        });
    </script>
@endsection