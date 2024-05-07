@include('partials.header', ['title' => $course->course_code. ' - Edit Course'])


<div class="main-container">
    {{-- @include('partials.navbar', ['t_dashboard' => true]) --}}
    @include('partials.sidebar', ['active' => 'courses'])
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => 'Courses > '. $course->course_code .' > Edit Course'])

        {{-- Main Section Container --}}
        <section class="courses-main-section">

            {{-- Header --}}
            <div class="section-header bg-white w-full h-[66px] rounded-md p-4">
                <div class="bg-white breadcrumbs-student w-full h-aut py-2 px-4 rounded-md">
                    <a href="{{route('teacher.courses.all', [''])}}" class="text-gray-500">Courses </a>
                    <a href="{{ route('teacher.courses.course', ['course' => $course->id]) }}" class="text-gray-500">> {{ $course->course_code }} </a>
                    <a href="" class="">> Edit Course</a>
                </div>
            </div>

            {{-- Content --}}
            <div class="section-content bg-white w-full h-[550px] rounded-md pt-8 pb-4 px-5">
                <div class="w-full h-auto">
                    <span class="text-xl">
                        Course Details
                    </span>
                </div>
                <hr>

                {{-- Add Course --}}
                <div class="form-container">
                    <form action="{{ route('teacher.courses.update', ['course' => $course->id]) }}" method="POST" class="grid grid-cols-2 gap-8 w-full">
                        @csrf
                        @method('PUT')
                        <div class="flex flex-col">
                            <label for="" class="custom-label">Course Code</label>
                            <input type="text" name="course_code" id="" class="border-solid border-2 custom-input" value="{{$course->course_code}}">
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="custom-label">Course Name</label>
                            <input type="text" name="name" id="" class="border-solid border-2 custom-input" value="{{$course->name}}">
                        </div>
                        <div class="flex flex-col col-span-2">
                            <label for="" class="custom-label">Description</label>
                            <textarea type="text" name="description" id="" class="border-solid border-2 custom-input">{{$course->description}}</textarea>
                        </div>

                        <div class="flex flex-col">
                            <label for="" class="custom-label">Meeting Link</label>
                            <input type="text" name="meeting_link" id="" class="border-solid border-2 custom-input" value="{{$course->meeting_link}}">
                        </div>

                        {{-- <div class="flex flex-col">
                            <label for="" class="custom-label">Author</label>
                            <input type="text" name="author" id="" class="border-solid border-2 custom-input">
                        </div> --}}
                        <div class="flex flex-col">
                            <label for="" class="custom-label">Invite Code</label>
                            <div class="flex flex-row flex-nowrap gap-2">
                            <input type="text" name="invite_code" id="invite_code" class="border-solid border-2 custom-input w-full" value="{{$course->invite_code}}">
                            <button type="button" class="bg-[var(--custom-orange)] py-1 px-4 text-white rounded-md min-w-[164px]" id="invite_code_generate" onclick="generateUniqueCode()">Generate Code</button>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label for="" class="custom-label">Settings</label>

                            <div class="flex flex-nowrap flex-row gap-2">
                                <input type="checkbox" name="power_ups" value="checked" class="text-sm" {{ ($course->power_ups == true) ? 'checked' : ''}}>Allow Power Ups</input>
                            </div>
                            {{-- <div class="flex flex-nowrap flex-row gap-2">
                                <input type="checkbox" name="" value="checked" class="text-sm">Op</input>
                            </div>
                            <div class="flex flex-nowrap flex-row gap-2">
                                <input type="checkbox" name="" value="checked" class="text-sm">Op</input>
                            </div> --}}

                        </div>

                        
                        <div class="flex items-center col-span-2">
                            <button type="submit" class="custom-button">Submit</button>
                        </div>
                    </form>
                </div>
                {{-- Add Course end --}}
                

            </div>


            {{-- <div class="section-menu bg-white w-full h-auto rounded-md p-4">
                <ul class="">
                    <li>
                        <a href="{{ route('teacher.courses.all',['']) }}" class="header-items">
                            All courses
                        </a>
                    </li>
                </ul>
            </div> --}}
            <div class="section-menu w-full h-auto rounded-md">
                <div class="bg-white h-auto w-full rounded-md p-4 shadow-lg">
                <ul class="flex flex-col gap-4">
                    <li>
                        <a href="{{ route('teacher.courses.all',['']) }}">
                            <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                <i class='bx bx-book-bookmark menu-button-icon' ></i>
                                <span class="hidden lg:block">&nbsp;All Courses</span>
                            </button>
                        </a>
                    </li>
                </ul>
                </div>
            </div>

        </section>


    </main>
</div>
<style>
    /* Main Section Container */
    .courses-main-section{
        padding: 1rem;
        display: grid;
        gap: 8px;
        grid-template-columns: 1fr;
        grid-template-rows: auto 1fr;
        grid-template-areas:
        "header"
        "content"
        "menu";
        height: calc(100% - 60px);
    }
    .section-header{
        grid-area: header;
    }
    .section-content{
        grid-area: content;
    }
    .section-menu{
        grid-area: menu;
    }

    /* Section Header */
    .section-header .header-menu{
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 16px;
    }
    .section-header{
        display: flex;
        justify-content: end;
        gap: 8px;
        align-items: center;
    }

    .section-header .header-menu li button{
        display: flex;
        align-items: center;
        justify-content: center;
        background: whitesmoke;
        /* border: 1px solid rgb(181, 181, 181); */
        border-radius: 4px;
        min-width: 24px;
        height: 100%;
    }

    .section-header .header-menu li button:hover{
        background: rgb(238, 238, 238);
    }

    .section-header .header-menu li .header-items{
        background: var(--custom-darkblue);
        color: white;
        border-radius: 4px;
        padding: 4px 8px 4px;
        transition: all 0.2s ease-in-out;
    }
    .section-header .header-menu li .header-items:hover{
        background: var(--custom-orange);
        color: black;
        outline: 1px solid black;
    }
    .section-menu .header-items{
        background: var(--custom-darkblue);
        color: white;
        border-radius: 4px;
        padding: 4px 8px 4px;
        transition: all 0.2s ease-in-out;
    }
    .section-menu .header-items:hover{
        background: var(--custom-orange);
        /* outline: 1px solid black; */
    }


    /* Module Display Container */
    .courses-main-section .section-content{
        display: flex;
        flex-direction: column;
        gap: 12px;
        height: 100%;
    }

    /* Module Display Template */
    .form-container{
        /* background: rgb(246, 251, 255); */
        display: flex;
        width: 100%;
        height: auto;
        border-radius: 6px;
        /* border: 1px solid rgb(181, 181, 181); */
        padding: 16px;
        justify-content: space-between;
        transition: all 0.2s ease-in-out;
    }


    /* Responsiveness */
    @media screen and (min-width: 768px) {
        .courses-main-section{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            grid-template-areas:
            "header header header menu"
            "content content  content menu";
        }
    }


    .custom-label{
        display: inline;
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 600;
    }

    .custom-input{
        border-radius: 5px;
        display: inline;
        padding: 2px 8px;
        resize: none;
    }

    .custom-input:focus{
        outline: none;
    }

    .custom-button{
        border-radius: 5px;
        color: white;
        background: var(--custom-darkblue);
        padding: 4px 16px;
        transition: all 0.2s ease-in-out;
    }
    .custom-button:hover{        
        background: var(--custom-orange );
    }
</style>

<script>

    var codeField = document.getElementById("invite_code");

    function generateUniqueCode() {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let code = '';

        for (let i = 0; i < 6; i++) {
            code += characters.charAt(Math.floor(Math.random() * characters.length));
        }

        codeField.value = code;
    }

    
</script>
@include('partials.footer')

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