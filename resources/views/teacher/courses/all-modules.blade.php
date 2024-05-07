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
                    <a href="" class="">> All Modules </a>
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
                        Module List
                    </span>
                </div>
                <hr>
                <div class="">
                    @foreach ($modules as $module)
                    @if ($module->course_id != $course->id)
                        @continue
                    @endif
                    <div class="module-container">
                        <div class="module-section">
                            <div class="module-display">
                                <div class="module-name"><span>{{ $module->name }}</span></div>
                                <div class="module-desc"><span>{{ $module->description }}</span></div>
                                <div class="module-desc uppercase"><span>{{ ($module->is_task) ? 'Task' : '' }}</span></div>
                                
                            </div>
                            <div class="module-menu">
                                <ul class="module-menu-items">
                                    <li>
                                        <a href="{{ route('module.submissions', ['id' => $module->id]) }}">
                                            <button class="module-menu-button menu-options">
                                                <i class='bx bxs-cloud-upload menu-button-icon'></i>
                                                <span class="hidden lg:block">&nbsp;Submitted Files</span>
                                            </button>
                                        </a>
                                    </li>
                                    <li>
                                        <button onclick="showMaterials({{$module->id}})" class="module-menu-button menu-options">
                                            <i class='bx bx-file menu-button-icon'></i>
                                            <span class="hidden lg:block">&nbsp;All Materials</span>
                                        </button>
                                    </li>
                                    <li>
                                        <a href="{{ route('teacher.materials.new',['course' => $course, 'module' =>$module]) }}">
                                            <button class="module-menu-button menu-options">
                                                <i class='bx bxs-file-plus menu-button-icon' ></i>
                                                <span class="hidden lg:block">&nbsp;New Material</span>
                                            </button>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('teacher.modules.edit',['course' => $course, 'module' =>$module]) }}">
                                            <button class="module-menu-button menu-options">
                                                <i class='bx bx-edit menu-button-icon' ></i>
                                                <span class="hidden lg:block">&nbsp;Edit</span>
                                            </button>
                                        </a>
                                    </li>
                                    <li>
                                        <button onclick="showComments({{$module->id}})" class="module-menu-button menu-options">
                                            <i class='bx bx-comment-detail menu-button' ></i>
                                            <span class="hidden lg:block">&nbsp;Comments</span>
                                        </button>
                                    </li>
                                    <li>
                                        <form class="deleteModuleForm m-0" action="{{ route('teacher.modules.delete', ['module' => $module->id, 'course' => $course->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="module-menu-button">
                                                <i class='bx bx-trash menu-button-icon text-[var(--soft-red)]'></i>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="hide" id="materials_{{$module->id}}">
                            @foreach ($materials as $material)
                            @if ($material->module_id != $module->id)
                                @continue
                            @endif
                            <div class="material-container">
                                <div class="material-section">
                                    <div class="material-display">
                                        <div class="material-name"><span>{{ $material->name }}</span></div>
                                        {{-- <div class="material-desc"><span>{{ $material->resource }}</span></div> --}}
                                    </div>
                                    <div class="material-menu">
                                        <ul class="material-menu-items">
                                            <li>
                                                <form class="deleteMaterialForm m-0" action="{{ route('teacher.materials.delete', ['module' => $module->id, 'course' => $course->id, 'material' => $material->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="material-menu-button">
                                                        <i class='bx bx-trash menu-button-icon text-[var(--soft-red)]'></i>
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <a href="{{route('teacher.materials.edit', ['course'=>$course->id, 'module' => $module->id, 'material' => $material->id])}}">
                                                    <button class="module-menu-button menu-options">
                                                        <i class='bx bx-edit menu-button-icon' ></i>
                                                        <span class="hidden lg:block">&nbsp;Edit</span>
                                                    </button>
                                                </a>
                                            </li>
                                            <li>
                                                @if ($material->type === 1)
                                                <a href="{{'/files/'. $material->resource}}" target="_blank">
                                                    <button type="submit" class="material-menu-button menu-options">
                                                        <i class='bx bx-search-alt-2 menu-button-icon' ></i>
                                                        <span class="hidden lg:block">&nbsp;View</span>
                                                    </button>
                                                </a>
                                                @endif
                                                @if ($material->type === 2)
                                                <a href="{{$material->resource}}" target="_blank">
                                                    <button type="submit" class="material-menu-button menu-options">
                                                        <i class='bx bx-search-alt-2 menu-button-icon' ></i>
                                                        <span class="hidden lg:block">&nbsp;View</span>
                                                    </button>
                                                </a>
                                                @endif
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                        <div class="hide" id="comments_{{$module->id}}">
                            <div class="module-comments-section px-2">
                                <div class="module-comments-input">
                                    <form action="{{ route('teacher.module.store_comment') }}" method="POST" class=" flex gap-2 w-full">
                                        @csrf
                                        <input type="hidden" name="module_id" value="{{ $module->id }}"></input>
                                        <span class="flex justify-center items-center text-2xl rounded-full w-[40px] h-[40px] aspect-square font-bold text-white name-color-{{ auth()->user()->firstname[0] }}">
                                            <h1>{{ auth()->user()->firstname[0] }}</h1>
                                        </span>
                                        <input type="text" name="comment" class="w-full py-1 px-4 text-sm border-[1px] border-gray-400 rounded-md" placeholder="Add comment...">
                                        </input>
                                    </form>
                                </div>
                                <div class="user-comments p-2">
                                    @php
                                        $user_comments = $comments->where('module_id', $module->id);
                                    @endphp
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
                    {{-- <li>
                        <a href="{{ route('teacher.courses.all',['']) }}">
                            <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                <i class='bx bx-book-bookmark menu-button-icon' ></i>
                                <span class="hidden lg:block">&nbsp;All Courses</span>
                            </button>
                        </a>
                    </li>
                    <hr> --}}
                    <li>
                        <a href="{{ route('teacher.modules.new',['course' => $course->id]) }}">
                            <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                <i class='bx bx-bookmark-plus menu-button-icon' ></i>
                                <span class="hidden lg:block">&nbsp;New Module</span>
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

    /* Course Display */
    .module-container{
        height: auto;
        width: 100%;
        /* background: blue; */
        margin: 10px 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding: 0px;
    }

    .module-container .module-section{
        height: 120px;
        width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        border-radius: 10px;
        box-shadow: 0 0 10px 2px rgba(0,0,0,0.2);
    }

    .module-container .module-section .module-display{
        height: 100%;
        width: 45%;
        padding: 8px;
        display: flex;
        flex-direction: column;
        background: var(--custom-darkblue);
        border-radius: 10px 0 0 10px;
    }

    .module-display .module-name{
        height: 100%;
        font-size: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        padding: 0 16px;
        color: var(--custom-white);
    }
    .module-display .module-desc{
        height: 100%;
        display: flex;
        align-items: center;
        padding: 0 16px;
        color: var(--custom-white);
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
        flex-wrap: wrap;
    }

    .module-menu .module-menu-items{
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 16px;
        font-size: 2rem;
    }
    .module-menu .module-menu-items li{
        display: flex;
        align-items: center;
        justify-content: center;
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

    .hide{
        /* display: none; */
        height: 0;
        overflow: hidden;
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
    .user-comments{
        overflow-y: scroll;
        max-height: 400px !important;
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

    function showMaterials(id){
        var panel = document.getElementById("materials_" + id);
        panel.classList.toggle('hide');
    }
    function showComments(id){
        var panel = document.getElementById("comments_" + id);
        panel.classList.toggle('hide');
        console.log("com");
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