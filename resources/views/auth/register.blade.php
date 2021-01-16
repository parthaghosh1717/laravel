@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Session Message --> 
            @if(Session::has('success')) 

                <div class="col-sm-12">
                    <div class="alert   alert-success alert-dismissible fade show" role="alert" >
                        <span class="badge badge-pill badge-success">Success</span> 
                            <strong> {{ Session::get('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

            @endif  
          <!--End of Session Message -->
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" id="register_from">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Eg: Amit Sarkar"   autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>

                            <div class="col-md-6 form-inline">
                                <input id="gender" type="radio" class="@error('gender') is-invalid @enderror" name="gender" value="Male"   autocomplete="gender" autofocus style="margin-right: 4px;"> Male

                                <input id="gender" type="radio" class="@error('gender') is-invalid @enderror" name="gender" value="Female"   autocomplete="gender" autofocus style="margin-left: 10px; margin-right: 4px;"> Female
                                <br><label for="gender" generated="true" class="error" style="display: none; margin-left: 5px;">This field is required.</label>

                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}"   autocomplete="address" autofocus>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="amit@gmail.com"   autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="utype" class="col-md-4 col-form-label text-md-right">Register As</label>

                            <div class="col-md-6 form-inline">
                                <input id="utype" type="radio" class="@error('utype') is-invalid @enderror" name="utype" value="S"   autocomplete="utype" autofocus style="margin-right: 4px;"> Student

                                <input id="utype" type="radio" class="@error('utype') is-invalid @enderror" name="utype" value="T"   autocomplete="utype" autofocus style="margin-left: 10px; margin-right: 4px;"> Teacher
                                <br><label for="utype" generated="true" class="error" style="display: none; margin-left: 5px;">This field is required.</label>
                                @error('utype')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"   autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"   autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                 
                                <input type="submit" class="btn btn-primary" name="submit" value="Register">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
@include('includes.scripts')

<script>
   $(document).ready(function(){
      $('#register_from').validate({
         rules:{ 
            name:{required: true},
            gender:{required: true},
            address:{required: true},
            utype:{required: true},
             password_confirmation:{required: true, equalTo: "#password"},
            email:{
                    required: true, 
                    email:true,
                    remote: {
                        url: '{{ route("user.email.check") }}',
                        type: "post",
                        data: {
                            email: function() {
                              return $( "#email" ).val();
                            },
                        _token: '{{ csrf_token() }}'
                        }
                    }     

            } 
                        
         },

          messages: {
            email:{
               remote: 'This email has already been taken.'  
            } ,
        }
          
      });
   });
</script>
@endsection
 
 