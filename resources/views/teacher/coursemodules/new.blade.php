@include('partials.header', ['title' => $course->course_code . ' - ' . 'All Modules'])


<div class="main-container">
    {{-- @include('partials.navbar', ['t_dashboard' => true]) --}}
    @include('partials.sidebar', ['active' => 'courses'])
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => 'Courses > ' . $course->course_code . ' > ' . 'All Modules' ])

        {{-- Main Section Container --}}
        <section class="courses-main-section">
            
            {{-- Header --}}
            <div class="section-header bg-white w-full h-[auto] rounded-md p-4 shadow-lg flex flex-col gap-2">
                <div class="bg-white breadcrumbs-student w-full h-aut py-2 px-4 rounded-md">
                    <a href="{{route('teacher.courses.all', [''])}}" class="text-gray-500">Courses </a>
                    <a href="{{ route('teacher.courses.course', ['course' => $course->id]) }}" class="text-gray-500">> {{ $course->course_code }} </a>
                    <a href="{{ route('teacher.courses.modules', ['course' => $course->id]) }}" class="text-gray-500">> All Modules </a>
                    <a href="" class="">> New Module </a>
                </div>
                <ul class="header-menu w-full">
                    <div class="flex flex-row flex-nowrap gap-4">
                        <span class="flex justify-center items-center text-nowrap text-6xl rounded-xl w-[auto] h-[164px] p-4 font-bold text-white name-color-{{strtolower($course->name[0])}}">
                          <h1>{{ $course->course_code }}</h1>
                        </span>
                        <div class="flex items-center">
                          <div class="flex flex-col h-auto gap-4">
                            <span class="font-bold text-4xl">{{ $course->name }}</span>
                            
                            <p class="font-bold text-sm text-gray-400">{{ $course->description }}</p>
                            {{-- <span class="font-bold text-sm text-gray-400">CERTIFICATES: 0</span> --}}
                          </div>
                        </div>
                      </div>
                </ul>
            </div>

            {{-- Content --}}
            <div class="section-content flex flex-col gap-16 bg-white w-full h-[550px] rounded-md pt-8 pb-4 px-5 shadow-lg">
                <div class="w-full h-auto">
                    <span class="text-xl">
                        Module Details
                    </span>
                </div>
                <hr>
                <div class="flex flex-row flex-nowrap h-auto">
                    <hr>
                    {{-- Add Course --}}
                    <div class="form-container">
                        <form action="{{ route('teacher.modules.save_new',['course' => $course]) }}" method="POST" class="grid grid-cols-1 gap-8 w-full">
                            @csrf
                            <div class="flex flex-col">
                                <label for="" class="custom-label">Module Name</label>
                                <input type="text" name="name" id="" class="border-solid border-2 custom-input">
                            </div>
                            <div class="flex flex-col">
                                <label for="" class="custom-label">Description</label>
                                <textarea type="text" name="description" id="" rows="1" class="border-solid border-2 custom-input"></textarea>
                            </div>
                            <div class="flex flex-col">
                                <label for="" class="custom-label">Settings</label>
                                <div class="flex flex-nowrap flex-row gap-2">
                                    <input type="checkbox" name="is_task" value="checked" class="text-sm">Is Task</input>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <button type="submit" class="custom-button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>


            <div class="section-menu w-full h-auto rounded-md">
                <div class="bg-white h-auto w-full rounded-md p-4 shadow-lg">
                <ul class="flex flex-col gap-4">
                    <li>
                        <a href="{{ route('teacher.courses.modules',['course' => $course->id]) }}">
                            <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                <i class='bx bx-bookmarks menu-button-icon' ></i>
                                <span class="hidden lg:block">&nbsp;All Modules</span>
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
        justify-content: start;
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
        flex-direction: column;
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
        /* resize: none; */
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
@if(session('success'))
<script>
  notify("Success", "{{ session('success') }}", "success");
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
