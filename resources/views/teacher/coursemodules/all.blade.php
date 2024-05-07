@include('partials.header', ['title' => $course->course_code . ' - Modules'])
<div class="main-container">
    @include('partials.sidebar', ['active' => 'courses'])
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => 'Courses > '. $course->course_code . ' - ' . $course->name])

        {{-- Main Section Container --}}
        <section class="courses-main-section">

            {{-- Header --}}
            <div class="section-header bg-white w-full h-[66px] rounded-md p-4 ">
                <ul class="header-menu">
                    <li>
                        <a href="{{ route('teacher.modules.new',['course' => $course->id]) }}" class="header-items">
                            <i class='bx bx-plus' ></i>&nbsp;Module
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Content --}}
            <div class="section-content bg-white w-full h-[550px] rounded-md pt-8 pb-4 px-5">
                <div class="w-full h-auto">
                    <span class="text-xl">
                        Your Modules
                    </span>
                </div>
                <hr>
                
            
                @foreach ($modules as $module)
                <div class="module-template">
                    <div class="module-title-container">
                        <div class="module-item">
                            <span class="course-title">
                                {{ $module->name }}
                            </span>
                            <span class="course-modules">
                                {{ $module->description }}
                            </span>
                        </div>
                        <div>
                            <ul class="module-menu">
                                <li>
                                    <form class="deleteModuleForm m-0" action="{{ route('teacher.modules.delete', ['module' => $module->id, 'course' => $course->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <i class='bx bx-trash icon text-[var(--soft-red)]'></i>
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <a href="{{ route('assessments.create', ['course'=> $course->id, 'module' => $module->id]) }}">
                                        <button class="editBtn" onclick="showPanel({{$module->id}})">
                                            <i class='bx bx-book icon'></i>
                                        </button>
                                    <a>
                                </li>
                                <li>
                                    {{-- Add material --}}
                                    <a href="{{ route('teacher.materials.new', ['course'=> $course->id, 'module' => $module->id]) }}">
                                        <button>
                                            <i class='bx bx-book-add icon'></i>
                                        </button>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="material-panel hide" id="panel_{{$module->id}}">

                    </div>
                </div>
                @endforeach

            </div>


            <div class="section-menu bg-white w-full h-auto rounded-md p-4">
                Menu
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
    .module-template{
        background: rgb(246, 251, 255);
        display: flex;
        flex-direction: column;
        width: 100%;
        height: auto;
        border-radius: 6px;
        border: 1px solid rgb(181, 181, 181);
        padding-left: 16px;
        padding-right: 16px;
        justify-content: space-between;
        transition: all 0.2s ease-in-out;
    }
    .module-title-container{
        display: flex;
        width: 100%;
        height: 88px;
        padding-left: 16px;
        padding-right: 16px;
        justify-content: space-between;
        transition: all 0.2s ease-in-out;
    }

    .module-template:hover{
        background: rgb(233, 245, 255);
    }

    .module-template div{
        display: flex;
        align-items: center;
    }

    .module-template .course-title{
        font-weight: 600;
    }
    .module-template .course-modules{
        font-weight: 400;
        font-size: .8rem;
        margin-left: 16px;
    }

    .module-template div .module-menu{
        display: flex;
        flex-direction: row-reverse;
        gap: 8px;
    }

    .material-panel{
        height: 100px;
        width: 100%;
        display: block;
    }
    .hide{
        height: 0;
        display: none;
    }

    /* .module-template div .module-menu .dots-panel{
        flex-direction: column;
    } */


    .module-template div .module-menu li{
        display: flex;
        align-items: center;
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
    function showPanel(id){
        var panel = document.getElementById("panel_" + id);
        panel.classList.toggle('hide');
    }

</script>

@include('partials.footer')

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