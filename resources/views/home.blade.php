@extends('layouts.app')

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Question</th>
                <th class="text-center">Asked by</th>
                <th class="text-center">Asked on</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @if (count($questions) == 0)
                <tr>
                    <td colspan="4" class="text-center">No unanswered questions.</td>
                </tr>
            @else
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ $question->question }}</td>
                        <td class="text-center">{{ $question->asked_by }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::createFromFormat("Y-m-d G:i:s", $question->created_at)->format("F j, Y g:i A") }}</td>
                        <td class="text-center"><button type="button" onclick="sendAnswer({{ $question->id }}, '{{ $question->question }}')" class="btn btn-primary">Answer</button></td>
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
            $('.unanswered-questions').addClass('active');
        });
    </script>
@endsection
