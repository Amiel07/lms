@include('partials.header', ['title' => 'Welcome'])

<style>
    @import url('https://fonts.googleapis.com/css2?family=Shadows+Into+Light+Two&display=swap');
</style>
<nav class="bg-transparent">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
            <a href="/" class="flex flex-shrink-0 items-center">
                <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="Your Company">
                
                <span class="text-xl font-extrabold ml-2">THRIVE</span>
            </a>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            <a href="/login" class="bg-[transparent] px-6 py-1 rounded-full text-black">Log In</a>
            <a href="/register" class="bg-[#f2583e] px-6 py-1 rounded-full text-white hover:bg-[#f1472d] hover:cursor-pointer">Sign Up</a>
            </div>
        </div>
    </div>
</nav>

<section class="section h-[90vh] flex items-center drop-shadow-lg" id="section1">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 text-center md:grid-cols-2 md:text-start ">
            <div class="">
                <div>
                    <p class="text-7xl font-black">
                        From <span class="text-[#f2583e]">Clicks</span> to<br>
                        <span class="text-[#f2583e]">Knowledge</span>
                    </p>
                </div>
                <div class="my-8">
                    {{-- <p class="text-4xl silfont">
                        Transforming Education<br>through Interaction
                    </p> --}}
                </div>
                <div class="md:w-[80%] ">
                    <p class="text-lg font-normal leading-tight">
                        THRIVE (Technology enabled Hybrid Resource for Immersive Virtual Education) is an Online Learning Platform that is designed to help teachers and students to adopt the online learning method of education.
                    </p>
                </div>
                <button class="mt-8 bg-[#f2583e] px-10 py-2 rounded-full text-white hover:bg-[#f1472d] hover:cursor-pointer">Learn more</button>
            </div>
        </div>
    </div>
</section>

<section class="section h-[70vh] flex items-center bg-white mt-4" id="section2">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 text-center justify-items-center">
            {{-- <div class="w-[55%]">
                <h1 class="text-4xl silfont text-[#f2583e]">
                    Navigating the realm of education can be overwhelming without the proper resources.
                </h1>
            </div> --}}
            <div class="mt-8 w-[80%]">
                <p class="text-lg">
                    At THRIVE, we're your shortcut to seamless learning journey. As your premier online learning destination, 
                    we're here to connect you with engaging content, a vibrant community, and tools to make learning a breeze. 
                    Say goodbye to learning challenges and hello to a user-friendly platform that saves you time and energy. 
                    Join us for an educational adventure where interaction and exploration take center stage. 
                    Your path to learning is about to get a whole lot more accessible and enjoyable.
                </p>
            </div>
        </div>
    </div>
</section>


<section class="section h-auto flex items-center bg-white mt-4 pb-32" id="section3">
    {{-- <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="flex flex-col h-full justify-center text-center md:text-end h-[auto] md:h-[400px] lg:w-[360px]">
                <div>
                    <span class="text-[#f2583e] text-5xl font-black">Our<br>Team</span>
                    <br>
                    <span class="">Meet the brilliant minds<br> behind the scenes</span>
                </div>
            </div>
            <div class="profile-card bg-[#f2583e] drop-shadow-lg h-[400px] lg:w-[360px] w-[300px]">
                <span class="text-white font-semibold text-xl drop-shadow-lg">John Doe</span>
                <span class="text-white font-normal text-md drop-shadow-lg">johndoe@gmail.com</span>
            </div>
            <div class="profile-card bg-[#2b3e42] drop-shadow-lg h-[400px] lg:w-[360px] w-[300px]">
                <span class="text-white font-semibold text-xl drop-shadow-lg">John Doe</span>
                <span class="text-white font-normal text-md drop-shadow-lg">johndoe@gmail.com</span>
            </div>
            <div class="profile-card bg-[#77bed2] drop-shadow-lg h-[400px] lg:w-[360px] w-[300px]">
                <span class="text-white font-semibold text-xl drop-shadow-lg">John Doe</span>
                <span class="text-white font-normal text-md drop-shadow-lg">johndoe@gmail.com</span>
            </div>
             <div class="profile-card bg-[#34495e] drop-shadow-lg h-[400px] lg:w-[360px] w-[300px]">
                 <span class="text-white font-semibold text-xl drop-shadow-lg">John Doe</span>
                 <span class="text-white font-normal text-md drop-shadow-lg">johndoe@gmail.com</span>
            </div>
            <div class="profile-card bg-[#c5d1cc] drop-shadow-lg h-[400px] lg:w-[360px] w-[300px]">
                <span class="text-white font-semibold text-xl drop-shadow-lg">John Doe</span>
                <span class="text-white font-normal text-md drop-shadow-lg">johndoe@gmail.com</span>
            </div>
        </div>
    </div> --}}
</section>


<style>
    body{
        font-family: "Poppins", sans-serif;
        
        height: 100vh;
        background-color: #eee;
        font-size: 14px;
        background-image: url("{{ asset('images/landingbg.jpg') }}");
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .silfont{
        font-family: "Shadows Into Light Two";
    }

    #section2{
        box-shadow: 0 0 80px 100px white;
    }
    .profile-card{
        /* height: 400px;
        width: 380px; */
        border-radius: 8px;
        padding: 24px 16px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-width: 300px;
    }
</style>

@include('partials.footerband')
@include('partials.footer')