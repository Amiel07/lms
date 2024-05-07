@include('partials.header', ['title' => 'Courses'])
<div class="main-container">
    @include('partials.sidebar', ['active' => 'courses'])
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => 'Courses'])

        {{-- Main Section Container --}}
        <section class="courses-main-section">

            {{-- Header --}}
            <div class="section-header bg-white w-full h-[66px] rounded-md p-4 shadow-lg">
                <div class="bg-white breadcrumbs-student w-full h-aut py-2 px-4 rounded-md">
                    <a href="{{route('teacher.courses.all', [''])}}" class="text-gray-500">Courses </a>
                    {{-- <a href="" class="">> All Courses </a> --}}
                </div>
            </div>

            {{-- Content --}}
            <div class="section-content bg-white w-full h-[550px] rounded-md pt-8 pb-4 px-5 shadow-lg">
                <div class="w-full h-auto">
                    <span class="text-xl">
                        Your Courses
                    </span>
                </div>
                <hr>
                {{-- Course --}}
                @foreach ($courses as $course)
                @if ($course->hidden == 1)
                    @continue
                @endif
                <div class="course-container">
                    <div class="course-section">
                        <div class="course-display name-color-{{strtolower($course->name[0])}}">
                            <div class="course-code"><span>{{ $course->course_code }}</span></div>
                            {{-- <div class="course-desc text-sm"><span>{{ $course->meeting_link }}</span></div> --}}
                            <div class="course-desc">Invite Code:&nbsp;<span>{{ $course->invite_code }}</span></div>
                        </div>
                        <div class="course-menu">
                            <ul class="course-menu-items">
                                <li>
                                    <form class="deleteCourseForm m-0" action="{{ route('teacher.courses.delete', ['course' => $course->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="course-menu-button">
                                            <i class='bx bx-trash menu-button-icon text-[var(--soft-red)]'></i>
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form class="archiveCourseForm m-0" action="{{ route('teacher.courses.archive', ['course' => $course->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="course-menu-button menu-options">
                                            <i class='bx bx-archive-in menu-button-icon' ></i>
                                            <span class="hidden lg:block">&nbsp;Archive</span>
                                        </button>
                                    </form>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('teacher.announcement.new',['course' => $course->id]) }}">
                                        <button class="course-menu-button menu-options">
                                            <i class='bx bx-edit-alt menu-button-icon' ></i>
                                            <span class="hidden lg:block">&nbsp;Announcements</span>
                                        </button>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('teacher.modules.new',['course' => $course->id]) }}">
                                        <button class="course-menu-button menu-options">
                                            <i class='bx bx-book-add menu-button-icon'></i>
                                            <span class="hidden lg:block">&nbsp;New Module</span>
                                        </button>
                                    </a>
                                </li>
                                <li>
                                    <button onclick="showModules({{$course->id}})"  class="course-menu-button menu-options">
                                        <i class='bx bx-book-bookmark menu-button-icon' ></i>
                                        <span class="hidden lg:block">&nbsp;All Modules</span>
                                    </button>
                                </li> --}}
                                <li>
                                    <a href="{{ route('teacher.courses.edit',['course' => $course->id]) }}">
                                        <button  class="course-menu-button menu-options">
                                            <i class='bx bx-edit menu-button-icon'></i>
                                            <span class="hidden lg:block">&nbsp;Edit</span>
                                        </button>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('teacher.courses.course',['course' => $course->id]) }}">
                                        <button  class="course-menu-button menu-options">
                                            <i class='bx bx-search-alt menu-button-icon'></i>
                                            <span class="hidden lg:block">&nbsp;View</span>
                                        </button>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
                @endforeach

            </div>


            <div class="section-menu w-full h-auto rounded-md">
                <div class="bg-white h-auto w-full rounded-md p-4 shadow-lg">
                <ul class="flex flex-col gap-4">
                    <li>
                        <a href="{{ route('teacher.courses.new',['']) }}">
                            <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                <i class='bx bx-book-add menu-button-icon' ></i>
                                <span class="hidden lg:block">&nbsp;New Course</span>
                            </button>
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a href="{{ route('teacher.archived.all',['']) }}">
                            <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                <i class='bx bx-archive-in menu-button-icon' ></i>
                                <span class="hidden lg:block">&nbsp;Archived Courses</span>
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
        height: auto;
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
        /* outline: 1px solid black; */
    }


    /* Course Display */
    .course-container{
        height: auto;
        width: 100%;
        /* background: blue; */
        margin: 10px 0;
        display: flex;
        flex-direction: column;
        padding: 0px;
    }

    .course-container .course-section{
        height: 120px;
        width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        border-radius: 10px;
        box-shadow: 0 0 10px 2px rgba(0,0,0,0.2);
    }

    .course-container .course-section .course-display{
        height: 100%;
        width: 45%;
        padding: 8px;
        display: flex;
        flex-direction: column;
        border-radius: 10px 0 0 10px;
    }

    .course-display .course-code{
        height: 100%;
        font-size: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        padding: 0 16px;
        color: white;
    }
    .course-display .course-desc{
        height: 100%;
        display: flex;
        align-items: center;
        padding: 0 16px;
        color: white;
    }

    .course-container .course-section .course-menu{
        height: 100%;
        width: 55%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        border-radius: 0 10px 10px 0;
        flex-wrap: wrap;
    }

    .course-menu .course-menu-items{
        display: flex;
        flex-flow: row-reverse;
        gap: 16px;
        font-size: 2rem;
    }
    .course-menu .course-menu-items li{
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Module */
    .module-container{
        height: auto;
        width: 100%;
        /* background: blue; */
        margin: 10px 0;
        display: flex;
        flex-direction: column;
        padding: 0px 8px;
    }

    .module-container .module-section{
        height: 90px;
        width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        margin-bottom: 8px;
        border-radius: 10px;
        box-shadow: 0 0 10px 2px rgba(0,0,0,0.2);
    }

    .module-container .module-section .module-display{
        height: 100%;
        width: 45%;
        padding: 8px;
        display: flex;
        flex-direction: column;
        background: var(--custom-orange);
        border-radius: 10px 0 0 10px;
    }

    .module-display .module-name{
        height: 100%;
        font-size: 1.3rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        padding: 0 16px;
        color: white;
    }
    .module-display .module-desc{
        height: 100%;
        display: flex;
        align-items: center;
        padding: 0 16px;
        color: white;
    }

    .module-container .module-section .module-menu{
        height: 100%;
        width: 55%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        border-radius: 0 10px 10px 0;
    }

    .module-menu .module-menu-items{
        display: flex;
        flex-flow: row-reverse;
        gap: 16px;
        font-size: 2rem;
    }
    .module-menu .module-menu-items li{
        display: flex;
        align-items: center;
        justify-content: center;
    }


    /* Material */
    .material-container{
        height: auto;
        width: 100%;
        /* background: blue; */
        display: flex;
        flex-direction: column;
        padding: 0px 8px;
    }

    .material-container .material-section{
        height: 60px;
        width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        margin-bottom: 8px;
        border-radius: 10px;
        box-shadow: 0 0 10px 2px rgba(0,0,0,0.2);
    }

    .material-container .material-section .material-display{
        height: 100%;
        width: 45%;
        padding: 8px;
        display: flex;
        flex-direction: row;
        background: var(--custom-lightblue);
        border-radius: 10px 0 0 10px;
        gap: 20px;
        
    }

    .material-display .material-name{
        height: 100%;
        display: flex;
        align-items: center;
        padding: 0 16px;
        color: var(--custom-darkblue);
    }
    .material-display .material-desc{
        height: 100%;
        display: flex;
        align-items: center;
        padding: 0 16px;
        color: var(--custom-darkblue);
    }

    .material-container .material-section .material-menu{
        height: 100%;
        width: 55%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        border-radius: 0 10px 10px 0;
    }

    .material-menu .material-menu-items{
        display: flex;
        flex-flow: row-reverse;
        gap: 16px;
        font-size: 2rem;
    }
    .material-menu .material-menu-items li{
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hide{
        /* display: none; */
        height: 0;
        overflow: hidden;
    }

    /* Menu Button */
    .course-menu-button, .module-menu-button, .material-menu-button{
        font-size: 1rem;
        cursor: pointer;
    }
    .course-menu-button:hover, .module-menu-button:hover, .material-menu-button:hover{
        /* border-bottom: 2px solid var(--custom-darkblue); */
        color: var(--custom-orange);
    }
    .menu-options{
        color: var(--custom-darkblue);
        padding: 2px 4px;
        display: inline-flex;
        align-items: center;
        line-height: 0.9rem;
    }
    .menu-button-icon{
        font-size: 1.2rem;
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
</style>

<script>
    function showModules(id){
        var panel = document.getElementById("modules_" + id);
        panel.classList.toggle('hide');
    }

    function showMaterials(id){
        var panel = document.getElementById("materials_" + id);
        panel.classList.toggle('hide');
    }
</script>


@include('partials.footer')

@if(session('success'))
<script>
  notify("Success", "{{ session('success') }}", "success");
</script>
@endif
@if(session('error'))
<script>
  notify("Error", "{{ session('error') }}", "error");
</script>
@endif
@if(session('course_save'))
<script>
  notify("Success", "{{ session('course_save') }}", "success");
</script>
@endif



@if(session('module_save'))
<script>
  notify("Success", "{{ session('module_save') }}", "success");
</script>
@endif

@if(session('delete_success'))
<script>
  notify("Success", "{{ session('delete_success') }}", "success");
</script>
@endif

@if(session('delete_failed'))
<script>
  notify("Error", "{{ session('delete_failed') }}", "error");
</script>
@endif

@if(session('assessment_created'))
<script>
  notify("Success", "{{ session('assessment_created') }}", "success");
</script>
@endif