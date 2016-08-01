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
                <th class="text-center">Answered on</th>
            </tr>
            </thead>
            <tbody>
            @if (count($questions) == 0)
                <tr>
                    <td colspan="5" class="text-center">No answered questions.</td>
                </tr>
            @else
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ urldecode($question->question) }}</td>
                        <td class="text-center">{{ $question->answer }}</td>
                        <td class="text-center">{{ $question->asked_by }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::createFromFormat("Y-m-d G:i:s", $question->created_at)->format("F j, Y g:i A") }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::createFromFormat("Y-m-d G:i:s", $question->updated_at)->format("F j, Y g:i A") }}</td>
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
@endsection
