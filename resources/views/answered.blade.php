@extends('layouts.app')

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p>
                <i class="fa fa-times fa-fw"></i> {!! Session::get('error') !!}
            </p>
        </div>
    @endif
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p>
                <i class="fa fa-check fa-fw"></i> {!! Session::get('success') !!}
            </p>
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-times fa-fw"></i> There were problems with your action:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Question</th>
                <th>Answer</th>
                <th class="text-center">Asked by</th>
                <th class="text-center">Asked on</th>
                <th class="text-center">Answered by</th>
                <th class="text-center">Answered on</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @if (count($questions) == 0)
                <tr>
                    <td colspan="7" class="text-center">No answered questions.</td>
                </tr>
            @else
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ urldecode($question->question) }}</td>
                        <td class="text-center">{{ $question->answer }}</td>
                        <td class="text-center">{{ $question->asked_by }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::createFromFormat("Y-m-d G:i:s", $question->created_at)->format("F j, Y g:i A") }}</td>
                        <td class="text-center">
                            {{ \App\User::withTrashed()->find($question->answered_by)->name }}<br />
                            <span class="text-muted">@if (\App\User::withTrashed()->find($question->answered_by)->type == "admin") Admin @else {{ \App\Department::withTrashed()->find(\App\User::withTrashed()->find($question->answered_by)->department) }}@endif</span>
                        </td>
                        <td class="text-center">{{ \Carbon\Carbon::createFromFormat("Y-m-d G:i:s", $question->updated_at)->format("F j, Y g:i A") }}</td>
                        <td class="text-center"><a href="#" class="btn btn-primary btn-xs" onclick="editAnswer({{ $question->id }}, '{{ \App\Question::find($question->id)->question }}')"><i class="fa fa-pencil fa-fw"></i> Edit Answer</a></td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <div class="text-right">
        {!! $questions->render() !!}
    </div>
    <script>
        $(function() {
            $('.answered-questions').addClass('active');
        });
    </script>
    <div id="editAnswer" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form action="/answered/edit" method="post">
                <input type="hidden" name="id" class="questionID" value="" />
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-pencil fa-fw"></i> Edit Answer</h4>
                    </div>
                    <div class="modal-body">
                        {!! csrf_field() !!}

                        <h3 class="text-center question-here"></h3>

                        <div class="form-group">
                            <label for="name">Answer</label>
                            <input id="name" type="text" class="form-control" name="answer" value="" required />

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-fw"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editAnswer(id, question)
        {
            $('.question-here').html(question);
            $('.questionID').val(id);
            $('#editAnswer').modal();
        }
    </script>
@endsection
