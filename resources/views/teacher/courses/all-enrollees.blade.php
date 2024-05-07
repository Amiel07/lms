@include('partials.header', ['title' => $course->course_code . ' - ' . 'All Enrollees'])


<div class="main-container">
    {{-- @include('partials.navbar', ['t_dashboard' => true]) --}}
    @include('partials.sidebar', ['active' => 'courses'])
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => 'Courses > ' . $course->course_code. ' > ' . 'All Enrollees' ])

        {{-- Main Section Container --}}
        <section class="courses-main-section">
            {{-- Header --}}
            <div class="section-header bg-white w-full h-[auto] rounded-md p-4 shadow-lg flex flex-col gap-2">
                <div class="bg-white breadcrumbs-student w-full h-aut py-2 px-4 rounded-md">
                    <a href="{{route('teacher.courses.all', [''])}}" class="text-gray-500">Courses </a>
                    <a href="{{ route('teacher.courses.course', ['course' => $course->id]) }}" class="text-gray-500">> {{ $course->course_code }} </a>
                    <a href="" class="">> All Enrollees </a>
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
                            <span class="font-bold text-sm text-gray-400">INVITE CODE: {{ $course->invite_code }}</span>
                          </div>
                        </div>
                      </div>
                </ul>
            </div>

            {{-- Content --}}
            <div class="section-content flex flex-col gap-16 bg-white w-full h-[550px] rounded-md pt-8 pb-4 px-5 shadow-lg">
                <div class="w-full h-auto">
                    <span class="text-xl">
                        Enrollee List
                    </span>
                </div>
                <hr>
                <div class="">
                    <form action="{{route('teacher.givepointsall')}}" method="POST" class="giveAllPointsForm">
                        @csrf
                        <input type="hidden" name="course_id" value="{{$course->id}}"></input>
                        <input type="number" name="points" value="0" class="border-[1px] border-gray-400 px-2 py-1"></input>
                        <button class="text-green-700 h-full w-auto">
                            Give Points To All
                            <i class='bx bx-diamond'></i>
                        </button>
                    </form>
                </div>
                <div class="flex flex-col px-2">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="px-2 py-1 text-start">Name</th>
                                <th class="px-2 py-1 text-start">Progress</th>
                                <th class="px-2 py-1 text-start">Actions</th>
                                <th class="px-2 py-1 text-start">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enrollees as $index => $enrollee)
                            @php
                                $fullname = $enrollee->lastname . ', ' . $enrollee->firstname . ' ' . $enrollee->middlename;
                                $progress = completedModuleCount($enrollee->id, $course->id) . ' completed / ' . moduleCount($course->id) . ' total';
                            @endphp
                            <tr class="hover:bg-blue-100">
                                <td class="px-2 py-1">{{ $fullname }}</td>
                                <td class="px-2 py-1 uppercase text-xs">{{ $progress }}</td>
                                <td class="px-2 py-1 uppercase text-xs text-start">
                                    <form action="{{ route('teacher.enrollee.remove', ['course' => $course->id]) }}" method="POST" class="removeEnrolleeForm h-full">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="enrollment_id" value="{{$enrollee->enrollment_id}}"></input>
                                        <button class="text-red-400 h-full w-auto">
                                            Remove
                                            <i class='bx bx-message-square-x'></i>
                                        </button>
                                    </form>
                                    
                                </td>
                               <td class="px-2 py-1 uppercase text-xs text-start">
                                <form action="{{route('teacher.givepoints')}}" method="POST" class="giveEnrolleeForm h-full flex flex-wrap gap-2 items-center">
                                    @csrf
                                    <input type="hidden" name="enrollment_id" value="{{$enrollee->enrollment_id}}"></input>
                                    {{-- <input type="hidden" name="course_id" value="{{$course->id}}"></input> --}}
                                    <label>{{$enrollee->points}}</label>
                                    <input type="number" name="points" value="0" class="border-[1px] border-gray-400 px-2 py-1"></input>
                                    <button class="text-green-700 h-full w-auto">
                                        Give Points
                                        <i class='bx bx-diamond'></i>
                                    </button>
                                </form>
                               </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>


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
                    <hr>
                    <li>
                        <a href="{{ route('teacher.courses.modules',['course' => $course->id]) }}">
                            <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                <i class='bx bx-book-bookmark menu-button-icon' ></i>
                                <span class="hidden lg:block">&nbsp;All Modules</span>
                            </button>
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a href="{{ route('teacher.courses.assessments',['course' => $course->id]) }}">
                            <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                <i class='bx bx-book-bookmark menu-button-icon' ></i>
                                <span class="hidden lg:block">&nbsp;All Quizzes</span>
                            </button>
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a href="{{ route('teacher.courses.enrollees',['course' => $course->id]) }}">
                            <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                <i class='bx bx-user menu-button-icon' ></i>
                                <span class="hidden lg:block">&nbsp;All Enrollees</span>
                            </button>
                        </a>
                    </li>
                    <hr>
                    <li>
                        <form class="deleteCourseForm m-0" action="{{ route('teacher.courses.delete', ['course' => $course->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex flex-row items-center text-[var(--soft-red)] hover:text-[var(--custom-orange)]">
                                <i class='bx bx-trash menu-button-icon'></i>
                                <span class="hidden lg:block">&nbsp;Delete Course</span>
                            </button>
                        </form>
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
        background: rgb(246, 251, 255);
        display: flex;
        width: 100%;
        height: auto;
        border-radius: 6px;
        border: 1px solid rgb(181, 181, 181);
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

    .user-comments{
        overflow-y: scroll;
        max-height: 364px !important;
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
    function openComments(id){
        let target = document.getElementById('announcement-comments_' + id);
        target.classList.toggle('hidden');
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