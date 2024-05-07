@include('partials.header', ['title' => $course->course_code .' - '.$course->name])


<div class="main-container">

    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => 'THRIVE'])
        <div class="w-full px-4 pt-4 ">
            <div class="bg-white breadcrumbs-student w-full h-aut py-2 px-4 rounded-md shadow-lg">
                <a href="{{route('student.home')}}" class="text-gray-500">Home </a>
                <a href="{{ route('student.show_course', ['course'=> $course->id]) }}" class="">> {{$course->course_code}} </a>
              </div>
        </div>
        {{-- Main Section Container --}}
        <section class="courses-main-section">
            
            {{-- Header --}}
            <div class="section-header bg-white w-full h-[auto] rounded-md p-4 shadow-lg">
                <ul class="header-menu">
                    <div class="flex flex-row flex-nowrap gap-4">
                        <span class="flex justify-center items-center text-nowrap text-6xl rounded-xl w-[auto] h-[164px] p-4 font-bold text-white name-color-{{strtolower($course->name[0])}}">
                          <h1>{{ $course->course_code }}</h1>
                        </span>
                        <div class="flex items-center">
                          <div class="flex flex-col h-auto gap-4">
                            <span class="font-bold text-4xl">{{ $course->name }}</span>
                            
                            <p class="font-bold text-sm text-gray-400">{{ $course->description }}</p>
                            <a href="{{ $course->meeting_link }}" target="_blank" class="font-bold text-sm text-[var(--custom-orange)]">Open Meeting <i class='bx bx-link-external'></i></a>
                            <span class="text-md uppercase">POINTS: {{getPoints(auth()->user()->reference_id, $course->id)}}</span>
                          </div>
                        </div>
                      </div>
                </ul>
            </div>

            {{-- Content --}}
            <div class="section-content bg-white w-full h-[550px] rounded-md pt-8 pb-4 px-5 shadow-lg">
                <div class="w-full h-auto">
                    <span class="text-xl">
                        Announcements
                    </span>
                </div>
                <hr>
                <div class="flex flex-col gap-4">
                    @foreach ($announcements as $announcement)
                        @php
                            
                            $fullname = $announcement->lastname . ', ' . $announcement->firstname . ' ' . $announcement->middlename;
                            $user_comments = $comments->where('announcement_id', $announcement->id);
                        @endphp
                        <div class="flex items-center justify-center w-full h-auto">
                            <div class="px-5 py-4 bg-white border-[1px] border-gray-400 rounded-lg w-full">
                                <div class="flex mb-4">
                                    <span class="flex justify-center items-center text-2xl rounded-full w-[40px] h-[40px] aspect-square font-bold text-white name-color-{{ $announcement->firstname[0] }}">
                                        <h1>{{ $announcement->firstname[0] }}</h1>
                                    </span>
                                    <div class="ml-2 mt-0.5">
                                    <span class="block font-medium text-base leading-snug text-black">{{ $fullname }}</span>
                                    <span class="block text-sm text-gray-500 font-light leading-snug">{{ $announcement->created_at->format('F d, Y h:i A') }}</span>
                                    </div>
                                </div>
                                <p class="text-gray-800 leading-snug md:leading-normal">{{ $announcement->announcement }}</p>
                                <div class="flex justify-between items-center mt-5"> 
                                    <div onclick="openComments({{$announcement->id}})" class="ml-1 text-gray-500 font-light cursor-pointer hover:text-[var(--custom-orange)]">{{ $user_comments->count() .' comments'}}</div>
                                </div>
                                <hr class="my-2">
                                <div id="announcement-comments_{{$announcement->id}}" class="hidden">
                                    
                                    <div class="module-comments-input">
                                        <form action="{{ route('teacher.announcement.store_comment') }}" method="POST" class=" flex gap-2 w-full">
                                            @csrf
                                            <input type="hidden" name="announcement_id" value="{{ $announcement->id }}"></input>
                                            <span class="flex justify-center items-center text-2xl rounded-full w-[40px] h-[40px] aspect-square font-bold text-white name-color-{{ auth()->user()->firstname[0] }}">
                                                <h1>{{ auth()->user()->firstname[0] }}</h1>
                                            </span>
                                            <input type="text" name="comment" class="w-full py-1 px-4 text-sm border-[1px] border-gray-400 rounded-md" placeholder="Add comment...">
                                            </input>
                                            <div class="flex items-center">
                                                <button type="submit" class="flex justify-center items-center text-lg  max-h-[40px] font-bold text-green-400 hover:text-[var(--custom-orange)]">
                                                    Post&nbsp;
                                                    <i class='bx bx-send' ></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="user-comments p-2">
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
                            <a href="{{ route('student.open_course', ['course'=> $course->id]) }}">
                                <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                    <i class='bx bx-book-bookmark menu-button-icon' ></i>
                                    <span class="hidden lg:block">&nbsp;Start Learning</span>
                                </button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </section>


    </main>
</div>
<script>
    function uncheckCheckboxes() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
        updateSelectedCount(1);
    }

    function selectAll() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
        });
        updateSelectedCount();
        var select = document.querySelector('.js-example-basic-single');
        select.value = '';
    }

    function updateSelectedCount(num = 0) {
        var selectedCount = 0;
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                selectedCount++;
            }
        });

        if (num != 0) selectedCount = 1;
        document.getElementById('selectedCount').textContent = 'Selected: ' + selectedCount;
    }

    function clearSelected() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
        updateSelectedCount();
        var select = document.querySelector('.js-example-basic-single');
        select.value = '';
    }
</script>

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
        /* justify-content: end; */
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