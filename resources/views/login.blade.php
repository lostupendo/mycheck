@extends('app')

@section('title', 'Log In')

@section('content')
    <script>
        function loginUser(loginForm) {
            $.post('/js/api.php', {action:'login', email:loginForm.email.value, password:loginForm.password.value}, function(data){
                // write token as a comment
                if (data.success === true) {
                    $('#alert').show().removeClass('alert-danger').addClass('alert-success');
                    $('#alert div').text('Token is: ' + data.message);
                    $('#api_token').val(data.message);
                    $('#reveal_name_container').removeClass('d-none');
                }
                else {
                    $('#alert').show().removeClass('alert-success').addClass('alert-danger');
                    $('#alert div').text(data.message);
                }
            }, 'json');
        }
        function showTokenInput() {
            $('#reveal_name_input').removeClass('d-none');
            $('#reveal_name_input input').val('');
        }
        function getToken() {
            return $('#api_token').val();
        }
        function setToken(token) {
            $('#api_token').val(token);
        }
        function revealName() {
            var apiToken = getToken();
            $.post('/js/api.php', {action:'user_data', api_token:apiToken}, function(data){
                if (data.success === true) {
                    $('#alert').hide();
                    $('#reveal_name_link').removeClass('d-none').html('Your name must be <span style="font-weight:bold">' + data.message + '</span>!');
                }
                else {
                    $('#alert').show().removeClass('alert-success').addClass('alert-danger');
                    $('#alert div').text('Error. Could not fetch name.');
                }
            }, 'json');
        }
    </script>
    <div class="content">
        <div class="m-auto" style="width:600px">
            <div class="h1">
                Log In
            </div>
            <div id="alert" class="alert">
                <div></div>
            </div>
            <form method="post" action="{{route('login')}}">
                @csrf
                <input type="hidden" name="api_token" id="api_token" value="">
                <div class="form-group form-row">
                    <div class="col-md-3">
                        <label for="email" class="col-form-label">Email</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="email" id="email" value="{{old('email')}}" class="form-control">
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col-md-3">
                        <label for="password" class="col-form-label">Password</label>
                    </div>
                    <div class="col-md-9">
                        <input type="password" name="password" id="password" value="" class="form-control">
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-primary" type="button" onclick="loginUser(this.form)">Submit</button>
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col-md-12 text-right">
                        Not a registered user? <a href="{{route('register')}}">Register here</a>
                    </div>
                </div>
                <div class="form-group form-row d-none" id="reveal_name_container">
                    <div class="col-md-12 text-right" id="reveal_name_link">
                        Got a token? <a href="javascript:showTokenInput()">Click here</a>
                    </div>
                    <div class="col-md-12 text-right d-none" id="reveal_name_input">
                        <input type="text" placeholder="Write token here">
                        <button type="button" class="btn border-primary" onclick="revealName()">Submit Token</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
