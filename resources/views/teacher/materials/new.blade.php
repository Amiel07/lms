@include('partials.header', ['title' => 'New Material'])


<div class="main-container">
    {{-- @include('partials.navbar', ['t_dashboard' => true]) --}}
    @include('partials.sidebar', ['active' => 'courses'])
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => $course->name. ' > ' . $module->name . ' > New Material'])

        {{-- Main Section Container --}}
        <section class="courses-main-section">

            {{-- Header --}}
            <div class="section-header bg-white w-full h-[auto] rounded-md p-4 shadow-lg flex flex-col gap-2">
                <div class="bg-white breadcrumbs-student w-full h-aut py-2 px-4 rounded-md">
                    <a href="{{route('teacher.courses.all', [''])}}" class="text-gray-500">Courses </a>
                    <a href="{{ route('teacher.courses.course', ['course' => $course->id]) }}" class="text-gray-500">> {{ $course->course_code }} </a>
                    <a href="{{ route('teacher.courses.modules', ['course' => $course->id]) }}" class="text-gray-500">> {{ $module->name }} </a>
                    <a href="" class="">> New Material </a>
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
            <div class="section-content bg-white w-full h-[550px] rounded-md pt-8 pb-4 px-5">
                <div class="w-full h-auto">
                    <span class="text-xl">
                        Material Details
                    </span>
                </div>
                <hr>

                {{-- Add Course --}}
                <div class="form-container">
                    <form action="{{ route('teacher.materials.save_new',['course' => $course->id, 'module' => $module->id]) }}" enctype="multipart/form-data" method="POST" class="grid grid-cols-2 gap-8 w-full">
                        @csrf
                        <div class="flex flex-col">
                            <label for="" class="custom-label">Material Name</label>
                            <input type="text" name="name" id="" class="border-solid border-2 custom-input">
                        </div>
                        <div class="flex flex-col ">
                            <label for="" class="custom-label">Resource Type</label>
                            <select name="type" id="resourceType" class="border-solid border-2 custom-input" onchange="typeChange(this)">
                                <option value="1">File</option>
                                <option value="2">Link</option>
                                {{-- <option value="3">YouTube API</option> --}}
                            </select>
                            {{-- <input type="text" name="author" id="" class="border-solid border-2 custom-input"> --}}
                        </div>
                        <div class="flex flex-col col-span-2">
                            <label for="inputFile" class="custom-label">Resource</label>
                            <input type="file" id="inputFile" name="resource" class="border-solid border-2 custom-input">
                        </div>
                        
                        <div class="flex items-center">
                            <button type="submit" class="custom-button">Submit</button>
                        </div>
                    </form>
                </div>
                {{-- Add Course end --}}
                <script>
                    function handleFile(files) {
                        const inputBox = document.getElementById('resource');
                        
                        // Check if a file has been selected
                        if (files.length > 0) {
                            const filePath = files[0].name;
                            inputBox.value = filePath;
                        } else {
                            filePathDisplay.textContent = 'No file selected';
                        }
                    }
                    function changeResource(){
                        const inputBox = document.getElementById('resource');
                        var resourceType = document.getElementById('resourceType');
                        var chooseButton = document.getElementById('chooseFileBtn');
                        if (resourceType.value == 1){
                            chooseButton.classList.remove('hidden');
                            inputBox.value = 'No file selected';
                        }
                        else{
                            chooseButton.classList.add('hidden');
                            
                            inputBox.value = ' ';
                        }
                    }
                </script>

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
                                <span class="hidden lg:block">&nbsp;All courses</span>
                            </button>
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a href="{{ route('teacher.courses.modules',['course' => $course->id]) }}">
                            <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                <i class='bx bx-book-bookmark menu-button-icon' ></i>
                                <span class="hidden lg:block">&nbsp;All modules</span>
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
    function typeChange(target){
        let input = document.getElementById('inputFile');
        if (target.value != "1"){
            input.setAttribute('type', 'text');
        }
        else{
            input.setAttribute('type', 'file');
        }
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