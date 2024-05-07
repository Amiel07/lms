@include('partials.header', ['title' => 'Welcome'])


<div class="container">
    <div class="forms-container">
      <div class="form-control signup-form">
        <form action="{{ route('process_register') }}" method="POST">
            @csrf
          <h2>SIGN UP</h2>
          <hr>
          <input type="text" name="firstname" id="" placeholder="FIRSTNAME" class="border-solid border-2">
          <input type="text" name="middlename" id="" placeholder="MIDDLENAME" class="border-solid border-2">
          <input type="text" name="lastname" id="" placeholder="LASTNAME" class="border-solid border-2">
          <input type="email" name="email" id="" placeholder="EMAIL" class="border-solid border-2">
          <input type="password" name="password" id="" placeholder="PASSWORD" class="border-solid border-2">
          <input type="password" name="password_confirmation" id="" placeholder="CONFIRM PASSWORD" class="border-solid border-2">
            <div class="radio-inputs">
                <label class="radio">
                  <input type="radio" name="type" value="2" checked="">
                  <span class="name">Student</span>
                </label>
                <label class="radio">
                  <input type="radio" name="type" value="1">
                  <span class="name">Teacher</span>
                </label>
              </div>
            <button type="submit">Sign up</button>
        </form>
        
      </div>
      <div class="form-control signin-form">
        <form action="{{ route('process_login') }}" method="POST">
            @csrf
            
          <h2>SIGN IN</h2>
          <hr>
          <input type="email" name="email" id="" placeholder="EMAIL" class="border-solid border-2">
          <input type="password" name="password" id="" placeholder="PASSWORD" class="border-solid border-2">
          <button type="submit">Sign in</button>
        </form>
      </div>
    </div>
    <div class="intros-container">
      <div class="intro-control signin-intro">
        <div class="intro-control__inner">
          <h3 class="text-2xl">Welcome back!</h3>
          <p>
            Glad to have you back! Sign in to stay in touch with us!
          </p>
          <button id="signup-btn">No account yet? Signup.</button>
        </div>
      </div>
      <div class="intro-control signup-intro">
        <div class="intro-control__inner">
          <h3 class="text-2xl">Come join us!</h3>
          <p>
            We are excited to have you here! Create an account to start learning with us!
          </p>
          <button id="signin-btn">Already have an account? Signin.</button>
        </div>
      </div>
    </div>
  </div>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");
    @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css");
    * {
    margin: 0px;
    padding: 0px;
    box-sizing: border-box;
    }

    body {
    font-family: "Poppins", sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #eee;
    font-size: 14px;
    background-image: url("{{ asset('images/landingbg.jpg') }}");
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    }

    .container {
    background-color: #fff;
    border-radius: 10px;
    width: 760px;
    max-width: 100vw;
    height: 524px;
    position: relative;
    overflow-x: hidden;
    box-shadow: 0 0 50px 10px rgba(0, 0, 0, 0.1);
    }
    .container .forms-container {
    position: relative;
    width: 50%;
    text-align: center;
    }
    .container .forms-container .form-control {
    position: absolute;
    width: 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
    height: 524px;
    transition: all 0.5s ease-in;
    }
    .container .forms-container .form-control h2 {
    font-size: 2rem;
    }
    .container .forms-container .form-control form {
    display: flex;
    flex-direction: column;
    margin: 0px 30px;
    justify-content: center;
    }
    .container .forms-container .form-control form input {
    margin: 5px 0px;
    border: none;
    padding: 10px 20px;
    background-color: #efefef;
    border-radius: 25px;
    }
    .container .forms-container .form-control form button {
    border: none;
    padding: 10px;
    margin-top: 5px;
    background-color: transparent;
    border-radius: 25px;
    color: #f2583e;
    cursor: pointer;
    text-transform: uppercase;
    outline: 2px solid #f2583e;
    font-size: 1rem;
    }

    .container .forms-container .signin-form form button:hover, .container .forms-container .signin-form form button:active, .container .forms-container .signin-form form button:focus {
        outline: none;
        transition: all 0.1s ease-in-out;
        background-color: #f2583e;
        color: #fff;
    }
    .container .forms-container .form-control form hr{
        margin: 10px;
    }
    .container .forms-container .form-control form button:focus {
    outline: none;
    }
    .container .forms-container .form-control .socials .fa-facebook-f {
    padding: 5px 8px;
    background-color: #3b5998;
    }
    .container .forms-container .form-control .socials .fa-google-plus-g {
    padding: 5px 4px;
    background-color: #db4a39;
    }
    .container .forms-container .form-control .socials .fa-linkedin-in {
    padding: 5px 6px;
    background-color: #0e76a8;
    }
    .container .forms-container .form-control.signup-form {
    opacity: 0;
    z-index: 1;
    left: 200%;
    }
    .container .forms-container .form-control.signin-form {
    opacity: 1;
    z-index: 2;
    left: 0%;
    }
    .container .intros-container {
    position: relative;
    left: 50%;
    width: 50%;
    text-align: center;
    }
    .container .intros-container .intro-control {
    position: absolute;
    width: 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
    height: 524px;
    color: #fff;
    background: linear-gradient(170deg, #ff9c8b, #f2583e);
    transition: all 0.5s ease-in;
    font-size: 0.8rem;
    }
    .container .intros-container .intro-control .intro-control__inner {
    margin: 0px 30px;
    }
    .container .intros-container .intro-control button {
    border: none;
    padding: 15px 30px;
    background-color: #fff;
    border-radius: 50px;
    color: #db4a39;
    margin: 10px 0px;
    cursor: pointer;
    
    }
    .container .intros-container .intro-control button:focus, .container .intros-container .intro-control button:hover {
    outline: none;
    transform: scale(0.95);
    transition: all 0.1s ease-in-out;
    }
    .container .intros-container .intro-control h3,
    .container .intros-container .intro-control p {
    margin: 10px 0px;
    }
    .container .intros-container .intro-control.signin-intro {
    opacity: 1;
    z-index: 2;
    }
    .container .intros-container .intro-control.signup-intro {
    opacity: 0;
    z-index: 1;
    }

    .change .forms-container .form-control.signup-form {
    opacity: 1;
    z-index: 2;
    transform: translateX(-100%);
    }
    .change .forms-container .form-control.signup-form button {
        border: none;
        padding: 10px;
        margin-top: 5px;
        background-color: transparent;
        border-radius: 25px;
        color: #34495e;
        cursor: pointer;
        text-transform: uppercase;
        outline: 2px solid #34495e;
        transition: all 0.3s ease-in-out;
    }
    .change .forms-container .form-control.signup-form button:focus, .change .forms-container .form-control.signup-form button:hover{
        outline: none;
        transition: all 0.1s ease-in-out;
        background-color: #34495e;
        color: #fff;
    }
    .change .forms-container .form-control.signin-form {
    opacity: 0;
    z-index: 1;
    transform: translateX(-100%);
    }
    .change .intros-container .intro-control {
    transform: translateX(-100%);
    background: linear-gradient(170deg, #77bed2, #34495e);
    }
    .change .intros-container .intro-control #signin-btn {
    background-color: #d5e1dd;
    color: #34495e;
    }
    .change .intros-container .intro-control.signin-intro {
    opacity: 0;
    z-index: 1;
    }
    .change .intros-container .intro-control.signup-intro {
    opacity: 1;
    z-index: 2;
    }

    @media screen and (max-width: 480px) {
    .container {
        height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .container .forms-container {
        order: 2;
        width: 100%;
        height: 50vh;
    }
    .container .forms-container .form-control {
        position: absolute;
        height: 50vh;
    }
    .container .forms-container .form-control.signup-form {
        left: 0%;
        margin-top: 70px;
    }
    .container .intros-container {
        order: 1;
        width: 100%;
        left: 0%;
        height: 40vh;
    }
    .container .intros-container .intro-control {
        position: absolute;
        height: 40vh;
    }

    .change .forms-container .form-control.signup-form {
        transform: translateX(0%);
    }
    .change .forms-container .form-control.signin-form {
        transform: translateX(0%);
    }
    .change .intros-container .intro-control {
        transform: translateX(0%);
    }
    }

    /* Radio */
    .radio-inputs {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    border-radius: 0.5rem;
    background-color: #EEE;
    box-sizing: border-box;
    box-shadow: 0 0 0px 1px rgba(0, 0, 0, 0.06);
    padding: 0.20rem;
    width: 100%;
    font-size: 14px;
    margin: 4px 0;
    }

    .radio-inputs .radio {
    flex: 1 1 auto;
    text-align: center;
    }

    .radio-inputs .radio input {
    display: none;
    }

    .radio-inputs .radio .name {
    display: flex;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    border-radius: 0.5rem;
    border: none;
    padding: .25rem 0;
    color: rgba(51, 65, 85, 1);
    transition: all .15s ease-in-out;
    }

    .radio-inputs .radio input:checked + .name {
    background-color: #fff;
    font-weight: 600;
    }

        
</style>

<script>
    const signupBtn = document.getElementById("signup-btn");
    const signinBtn = document.getElementById("signin-btn");
    const mainContainer = document.querySelector(".container");

    signupBtn.addEventListener("click", () => {
    mainContainer.classList.toggle("change");
    });
    signinBtn.addEventListener("click", () => {
    mainContainer.classList.toggle("change");
    });
</script>


@include('partials.footer')
            

@if(session('message'))
<script>
  notify("Success", "{{ session('message') }}", "success");
</script>
@endif


{{-- Collect all errors --}}
@php
    $errorString = '';
@endphp

@foreach ($errors->all() as $error)
    @php
        $errorString .= $error . '\n';
    @endphp
@endforeach

@if ($errors->any())
  <script>
    notify("Error", "{{ $errorString }}", "error");
  </script>
@endif