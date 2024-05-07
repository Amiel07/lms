@include('partials.header', ['title' => 'Team'])

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

<section class="section h-[90dvh] flex items-center drop-shadow-lg" id="section1">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 text-center md:grid-cols-1 md:text-start">
            <div class="flex flex-col gap-8 text-center md:px-20">
                {{-- <div>
                    <p class="text-7xl font-black">
                        From <span class="text-[#f2583e]">Clicks</span> to<br>
                        <span class="text-[#f2583e]">Knowledge</span>
                    </p>
                </div> --}}
                <div class="my-8 flex justify-center items-center h-auto w-auto drop-shadow-xl">
                    <span class="self-center text-xl font-semibold whitespace-nowrap px-4 flex items-center">
                        <img class="h-8 w-auto h-full aspect-square" src="{{ asset('images/logo.png') }}" alt="Your Company">
                    </span>
                </div>
                <div class="w-full">
                    <p class="text-lg font-normal leading-tight">
                        Hello! We are ECE 23-012, a group supervised by Engr. Jefril M. Amboy. We developed this web application called THRIVE: 
Technology-enabled Hybrid Resource for Immersive Virtual Education.
                    </p>
                </div>
                <div class="w-full">
                    <p class="text-lg font-normal leading-tight">
                        Our goal is to create an online learning management system (LMS) similar to Google Classroom, which is currently used by 
the university. We hope that this capstone project will serve as a valuable reference for the university when they decide 
to build their own LMS in the future.
                    </p>
                </div>
                {{-- <button class="mt-8 bg-[#f2583e] max-w-[200px] px-10 py-2 rounded-full text-white hover:bg-[#f1472d] hover:cursor-pointer">Learn more</button> --}}
            </div>
            {{-- <div class="team-pic">

            </div> --}}
        </div>
    </div>
</section>

<section class="section h-[100dvh] flex items-center bg-white mt-4" id="section2">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 text-center justify-items-center">
            <div class="w-full">
                <h1 class="text-4xl silfont text-[#f2583e]">
                    <span class="text-black silfont">Meet Team</span> THRIVE
                </h1>
            </div>
            <div class="mt-8 w-full flex flex-col text-lg">
                <span>Coleto, Juan Miguel J.</span>
                <span>Cruz Jr., William P.</span>
                <span>Socorro, Marcelo M.</span>
                <span>Tenorio, Reynald Kenneth James R.</span>
                <span>Velasquez, Gene Amhiel G.</span>
            </div>
            <hr class="my-10">
            <div class="w-full flex flex-col gap-20">
                <p class="text-lg font-normal leading-tight">
                    Thank you for using our web application! We appreciate your time.
                </p>
                <p class="text-2xl font-normal silfont text-[var(--custom-orange)] leading-tight">
                    "Education is the most powerful weapon which you can use to change the world."<br>- Nelson Mandela
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
        /* background-image: url("{{ asset('images/landingbg.jpg') }}");
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat; */
        background: white;
    }

    .team-pic{
        background-image: url("{{ asset('images/team.png') }}");
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