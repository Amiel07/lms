@include('partials.header', ['title' => 'New Course'])


<div class="main-container">
    {{-- @include('partials.navbar', ['t_dashboard' => true]) --}}
    @include('partials.sidebar', ['active' => 'courses'])
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => 'Courses > ' . $course->course_code ])

        {{-- Main Section Container --}}
        <section class="courses-main-section">
            {{-- Header --}}
            <div class="section-header bg-white w-full h-[auto] rounded-md p-4 shadow-lg flex flex-col gap-2">
                <div class="bg-white breadcrumbs-student w-full h-aut py-2 px-4 rounded-md">
                    <a href="{{route('teacher.courses.all', [''])}}" class="text-gray-500">Courses </a>
                    <a href="" class="">> {{ $course->course_code }} </a>
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
                            <a href="{{ $course->meeting_link }}" target="_blank" class="font-bold text-sm text-[var(--custom-orange)]">Open Meeting <i class='bx bx-link-external'></i></a>
                          </div>
                        </div>
                      </div>
                </ul>
            </div>

            {{-- Content --}}
            <div class="section-content flex flex-col gap-16 bg-white w-full h-[550px] rounded-md pt-8 pb-4 px-5 shadow-lg">
                <div class="w-full h-auto">
                    <span class="text-xl">
                        Announcements
                    </span>
                </div>
                <hr>
                <div class="flex flex-row flex-nowrap h-auto">
                    <form action="{{ route('teacher.announcement.store') }}" method="POST" class="w-full h-auto">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}"></input>
                        <div class="flex gap-2 w-full">
                            <span class="flex justify-center items-center text-2xl rounded-full w-[40px] aspect-square max-h-[40px] font-bold">
                                <i class='bx bx-bell-plus'></i>
                            </span>
                            <div class="flex flex-col w-full gap-2">
                                <textarea type="text" name="announcement" class="w-full py-2 px-4 text-sm border-[1px] border-gray-400 rounded-md" rows="1" placeholder="New Announcement..."></textarea>
                                <div class="">
                                    <button type="submit" class="flex justify-center items-center text-lg  max-h-[40px] font-bold text-green-400 hover:text-[var(--custom-orange)]">
                                        Post&nbsp;
                                        <i class='bx bx-send' ></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="flex flex-col gap-4">
                    @foreach ($announcements as $announcement)
                        @php
                        $fullname = $announcement->lastname . ', ' . $announcement->firstname . ' ' . $announcement->middlename;
                        $user_comments = $comments->where('announcement_id', $announcement->id);
                        @endphp
                        
                        <div class="flex items-center justify-center w-full h-auto ">
                            <div class="px-5 py-4 bg-white border-[1px] border-gray-400 rounded-lg w-full">
                                <div class="flex flex-nowrap justify-between">
                                    <div class="flex mb-4">
                                        <span class="flex justify-center items-center text-2xl rounded-full w-[40px] h-[40px] aspect-square font-bold text-white name-color-{{ auth()->user()->firstname[0] }}">
                                            <h1>{{ $announcement->firstname[0] }}</h1>
                                        </span>
                                        <div class="ml-2 mt-0.5">
                                        <span class="block font-medium text-base leading-snug text-black">{{ $fullname }}</span>
                                        <span class="block text-sm text-gray-500 font-light leading-snug">{{ $announcement->created_at->format('F d, Y h:i A') }}</span>
                                        </div>
                                    </div>
                                    <button type="button" class="editbtn rounded-sm py-1 px-2 bg-[var(--custom-orange)] text-white max-h-[32px]" onclick="editClick({{$announcement->id}})">
                                        <i class='bx bx-edit-alt' ></i>
                                    </button>
                                </div>
                                <p class="text-gray-800 leading-snug md:leading-normal" id="announcement_msg_{{$announcement->id}}">{{ $announcement->announcement }}</p>
                                <form action="{{route('announcement.saveedit')}}" method="POST" class="hidden flex flex-col gap-2"  id="announcement_edit_{{$announcement->id}}">
                                    @csrf
                                    <input type="hidden" name="announcement_id" value="{{$announcement->id}}">
                                    <textarea class="text-gray-800 leading-snug md:leading-normal py-1 px-2 border-[1px] border-gray-400 w-full " name="new_announcement">{{ $announcement->announcement }}</textarea>
                                    <button type="submit" class="editbtn rounded-sm py-1 px-2 bg-[var(--custom-orange)] text-white max-h-[32px]" >
                                        Save
                                    </button>
                                </form>
                                <div class="flex justify-between items-center mt-5"> 
                                    <div onclick="openComments({{$announcement->id}})" class="ml-1 text-gray-500 font-light cursor-pointer hover:text-[var(--custom-orange)]">{{ $user_comments->count() .' comments'}}</div>
                                </div>
                                <hr class="my-2">
                                <div id="announcement-comments_{{$announcement->id}}" class="hidden h-auto">
                                    
                                    <div class="module-comments-input">
                                        <form action="{{ route('teacher.announcement.store_comment') }}" method="POST" class=" flex gap-2 w-full">
                                            @csrf
                                            <input type="hidden" name="announcement_id" value="{{ $announcement->id }}"></input>
                                            <span class="flex justify-center items-center text-2xl rounded-full w-[40px] h-[40px] aspect-square font-bold text-white name-color-{{ auth()->user()->firstname[0] }}">
                                                <h1>{{ auth()->user()->firstname[0] }}</h1>
                                            </span>
                                            <input type="text" name="comment" class="w-full py-1 px-4 text-sm border-[1px] border-gray-400 rounded-md" placeholder="Add comment...">
                                            <div class="flex items-center">
                                                <button type="submit" class="flex justify-center items-center text-lg  max-h-[40px] font-bold text-green-400 hover:text-[var(--custom-orange)]">
                                                    Post&nbsp;
                                                    <i class='bx bx-send' ></i>
                                                </button>
                                            </div>
                                            </input>
                                        </form>
                                    </div>
                                    <div class="user-comments">
                                        <div class="w-full flex flex-col">
                                            @foreach ($user_comments as $comment)
                                            @php
                                                 if ($comment->user_id == auth()->user()->id)
                                                    $commenter_fullname = "You";
                                                else
                                                    $commenter_fullname = $comment->lastname . ', ' . $comment->firstname . ' ' . $comment->middlename;
                                            @endphp
                                            <div class="flex mb-4 w-full">
                                                <span class="flex justify-center items-center text-2xl rounded-full w-[40px] h-[40px] aspect-square font-bold text-white name-color-{{ $comment->firstname[0] }}">
                                                    <h1>{{ $comment->firstname[0] }}</h1>
                                                </span>
                                                <div class="ml-2 mt-0.5 bg-gray-200 rounded-md py-2 px-3 w-full">
                                                    <span class="block font-bold text-base leading-snug text-black">{{ $commenter_fullname }}
                                                        <span class="text-sm text-gray-500 font-light leading-snug">&nbsp;{{ $comment->created_at->format('F d, Y h:i A') }}</span>
                                                    </span>
                                                    <p class="text-gray-800 leading-snug md:leading-normal">{{ $comment->comment }}</p>

                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    @endforeach
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
                                <i class='bx bx-bookmarks menu-button-icon' ></i>
                                <span class="hidden lg:block">&nbsp;All Modules</span>
                            </button>
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a href="{{ route('teacher.courses.assessments',['course' => $course->id]) }}">
                            <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                <i class='bx bxs-pen menu-button-icon' ></i>
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
                        <a href="{{ route('teacher.courses.edit',['course' => $course->id]) }}">
                            <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                <i class='bx bx-edit menu-button-icon'></i>
                                <span class="hidden lg:block">&nbsp;Edit Course</span>
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

    function editClick(id){
        const announcement = document.getElementById('announcement_msg_' + id);
        const announcementedit = document.getElementById('announcement_edit_' + id);
        announcement.classList.toggle('hidden');
        announcementedit.classList.toggle('hidden');
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