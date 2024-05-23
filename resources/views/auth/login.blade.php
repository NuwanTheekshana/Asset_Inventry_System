@extends('layouts.app1')

@section('title')
        Login Page
@endsection

@section('content')

  
 <div class="main mt-5">

<section class="sign-in">
           <div class="container">
               <div class="signin-content">

                   <div class="signin-image">
                       <figure><img src="{{ asset('img/gif/loging.gif') }}" alt="sing up image" style="margin-top: 50px;"></figure>
                       <a class="signup-image-link"><b>Created by :</b> HNBA - IT Department</a>
                   </div>

            
                   <div class="signin-form">
                       <h2 class="form-title">Sign In</h2>

                       <form method="POST" class="register-form" id="login-form" action="{{ route('login') }}">
                       @csrf
                           <div class="form-group">
                               <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                               <input type="email" name="email" id="email" class="@error('email') is-invalid @enderror" placeholder="Email Address"/>

                               @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    &nbsp;&nbsp;<strong><i class="zmdi zmdi-alert-circle"></i>&nbsp;&nbsp;{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>

                               

                           <div class="form-group">
                               <label for="password"><i class="zmdi zmdi-lock"></i></label>
                               <input type="password" name="password" id="password" lass="@error('password') is-invalid @enderror" placeholder="Password"/>

                               @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong><i class="zmdi zmdi-alert-circle"></i>&nbsp;&nbsp;{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>

                           <div class="form-group form-button">
                               <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                           </div>
                       </form>
                       <div class="social-login">
                          
                       </div>
                   </div>
               </div>
           </div>
       </section>


</div>

@endsection
