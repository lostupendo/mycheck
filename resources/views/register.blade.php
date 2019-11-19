@extends('app')

@section('title', 'Register')

@section('content')
    <script>
        function registerUser(registerForm) {
            $.post('/js/api.php', {action:'register', name:registerForm.name.value, email:registerForm.email.value, password:registerForm.password.value}, function(data){
                if (data.success === true) {
                    location.href='{{route('login')}}';
                }
                else {
                    $('#alert').show().addClass('alert-danger');
                    $('#alert div').text(data.message);
                }
            }, 'json');
        }
    </script>
    <div class="content">
        <div class="m-auto" style="width:600px">
            <div class="h1">
                Register
            </div>
            <div id="alert" class="alert d-none">
                <div></div>
            </div>
            <form onsubmit="return false;">
                @csrf
                <div class="form-group form-row">
                    <div class="col-md-3">
                        <label for="name" class="col-form-label">Full Name</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control">
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col-md-3">
                        <label for="email" class="col-form-label">Email</label>
                    </div>
                    <div class="col-md-9">
                        <input type="email" name="email" id="email" value="{{old('email')}}" class="form-control">
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
                        <button type="button" class="btn btn-primary" onclick="registerUser(this.form)">Submit</button>
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col-md-12 text-right">
                        Already registered? <a href="{{route('login')}}">Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
