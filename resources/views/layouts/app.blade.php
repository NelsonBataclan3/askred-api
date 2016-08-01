<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ask Red</title>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }

        .table > tbody > tr > td {
            vertical-align: middle;
        }

        .question-here {
            margin-bottom: 2.0em;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Ask Red
                </a>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ url("/logout") }}">Sign Out</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </nav>

    @if (!Auth::guest())
    <div class="container">
        <div class="col-xs-3">
            <div class="list-group">
                <a class="list-group-item unanswered-questions" href="{{ url('/home') }}">
                    <i class="fa fa-question fa-fw"></i> Unanswered Questions
                </a>
                <a class="list-group-item answered-questions" href="{{ url('/answered') }}">
                    <i class="fa fa-check fa-fw"></i> Answered Questions
                </a>
                <a class="list-group-item users" href="{{ url('/users') }}">
                    <i class="fa fa-users fa-fw"></i> System Users
                </a>
            </div>
        </div>
        <div class="col-xs-9">
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
            @yield('content')
        </div>
    </div>
    <div id="answerModal" class="modal fade" role="dialog">
        <form action="{{ url('/send') }}" method="post">
            {!! csrf_field() !!}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Answer</h4>
                    </div>
                    <div class="modal-body">
                        <h3 class="text-center question-here"></h3>
                        <input type="hidden" name="id" class="questionID" value="" />
                        <input type="text" class="form-control answer-here" name="answer" placeholder="Your answer" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times fa-fw"></i> Close</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save fa-fw"></i> Save</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <script>
        function sendAnswer(id, question)
        {
            $('.question-here').html(question);
            $('.questionID').val(id);
            $('#answerModal').modal();
        }
    </script>
    @else
        <div class="container">
            <div class="col-xs-12">
                @yield('content')
            </div>
        </div>
    @endif
</body>
</html>
