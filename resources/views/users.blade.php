@extends('layouts.app')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Users
            <a href="#addUser" data-toggle="modal" data-target="#addUser" class="pull-right"><i class="fa fa-plus fa-fw"></i> Add User</a>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($users) == 0)
                        <tr>
                            <td colspan="2" class="text-center">No users.</td>
                        </tr>
                    @else
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td class="text-center">
                                    @if ($user->deleted_at == "" || $user->deleted_at == null)
                                        <a href="/users/delete/{{ $user->id }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fa fa-trash fa-fw"></i> Delete</a>
                                    @else
                                        <a href="/users/restore/{{ $user->id }}" class="btn btn-info btn-xs" onclick="return confirm('Are you sure you want to restore this user?');"><i class="fa fa-undo fa-fw"></i> Restore</a>
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
        {!! $users->links() !!}
    </div>

    <div id="addUser" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form action="/users/save" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-users fa-fw"></i> Add User</h4>
                    </div>
                    <div class="modal-body">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username">Username</label>
                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required />

                            @if ($errors->has('username'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password_confirmation">Confirm Password</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required />

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
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
            $('.users').addClass('active');
        });
    </script>
@endsection