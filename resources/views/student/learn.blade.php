@include('partials.header', ['title' => 'Courses'])
<div class="main-container">
    {{-- @include('partials.sidebar', ['active' => 'courses']) --}}
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => 'THRIVE'])
        <section class="courses-main-section p-4">
            <div class="mb-4">
                <div class="bg-white breadcrumbs-student w-full h-aut py-2 px-4 rounded-md shadow-lg">
                    <a href="{{route('student.home')}}" class="text-gray-500">Home </a>
                    <a href="{{ route('student.show_course', ['course'=> $course->id]) }}" class="text-gray-500">> {{$course->course_code}} </a>
                    <a href="{{ route('student.open_course', ['course'=> $course->id]) }}" class="">> Learn </a>
                  </div>
            </div>
            <div class="bg-white w-full h-auto rounded-md p-4 px-5 mb-2 shadow-lg">
                <div class="flex items-center">
                    <div class="flex flex-col h-auto">
                      <span class="font-bold text-4xl">{{ $course->name }}</span>
                      {{-- <p class="font-bold text-sm text-gray-400">{{ $course->description }}</p> --}}
                      {{-- <span class="font-bold text-sm text-gray-400">CERTIFICATES: 0</span> --}}
                    </div>
                  </div>
            </div>
            {{-- Content --}}
            <div class="section-content bg-white w-full h-[auto] rounded-md pt-8 pb-4 px-5 shadow-lg">
                <div class="course-main-container">
                    <div class="left-panel min-w-[250px] pr-4">
                        <ul class="">
                            <div class="mb-6"><span class="font-bold text-2xl uppercase text-green-700" id="user_points">Points: {{ getPoints(auth()->user()->reference_id, $course->id) }}</span></div>
                            <span class="font-bold">Modules</span>
                            @foreach($modules as $index => $module)
                                @if ($index != 0)
                                    <hr>
                                @endif
                                <div class="mb-0">
                                    <form action="{{route('course.progress.markAsDone')}}" method="POST" class="m-0 rounded-sm flex flex-row">
                                        @csrf
                                        <input type="hidden" name="module_id" value="{{ $module->id }}">
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                                        @php
                                            $prog = $progress->where('module_id', $module->id)->where('student_id', auth()->user()->id)->where('is_assessment', false)->first();
                                        @endphp
                                        {{-- <button type="submit" class="mr-2"><i class='bx bxs-check-square text-green-400'></i></button> --}}
                                        @if ($prog && $prog->is_completed == 1)
                                            <button type="submit" class="mr-2"><i class='bx bxs-check-square text-green-400'></i></button>
                                        @else
                                            <button type="submit" class="mr-2"><i class='bx bxs-check-square text-gray-300'></i></button>
                                        @endif
                                        <li id="module_{{ $module->id }}" value="{{ $module->id }}" class="module w-full hover:bg-blue-100 px-2 py-2 rounded-md font-bold">
                                            {{ $module->name }}
                                        </li>
                                    </form>
                                    
                                    
                                </div>
                            @endforeach
                            <span class="font-bold">Quizzes</span>
                            @foreach($assessments as $index => $assessment)
                                @if ($index != 0)
                                    <hr>
                                @endif
                                <div class="mb-0">
                                    {{-- <form action="{{route('course.progress.markAsDone')}}" method="POST" class="m-0 rounded-sm flex flex-row">
                                        @csrf --}}
                                    <div class="m-0 rounded-sm flex flex-row">
                                        <input type="hidden" name="module_id" value="{{ $assessment->id }}">
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <input type="hidden" name="is_assessment" value="clicked">


                                        {{-- <button type="submit" class="mr-2"><i class='bx bxs-check-square text-green-400'></i></button> --}}
                                        @if (isAssessmentDone(auth()->user()->id, $assessment->id))
                                            <button disabled type="button" class="mr-2"><i class='bx bxs-check-square text-green-400'></i></button>
                                        @else
                                            <button disabled type="button" class="mr-2"><i class='bx bxs-check-square text-gray-300'></i></button>
                                        @endif
                                        <li id="assessment_{{ $assessment->id }}" value="{{ $assessment->id }}" class="assessment w-full hover:bg-blue-100 px-2 py-2 rounded-md font-bold">{{ $assessment->assessment_name }}</li>
                                    {{-- </form> --}}
                                    </div>
                                    
                                    
                                </div>
                            @endforeach
                        </ul>
                    </div>
                
                    <div class="main-panel w-full">
                        
                        <div id="material-section" class="section">
                            <!-- Material content will be displayed here -->
                            @php
                                $videoFormats = array('.mp4', '.mov', '.avi', '.mkv', '.wmv', '.flv', '.webm', '.mpeg', '.mpg');
                                $pdfFormat = array("pdf");
                            @endphp
                            @foreach ($modules as $module) 
                           <div id="module_view_{{$module->id}}" class="module-view flex flex-col sm:px-[5%] md:px-[10%] lg:px-[20%] w-full hidden">
                                <div class="module-header px-2">
                                    <span class="text-4xl">{{ $module->name }}</span>
                                    <p class="text-md text-gray-600">{{ $module->description }}</p>
                                    @php
                                        $module_materials = $materials->where('module_id', $module->id);
                                    @endphp
                                    <p class="text-sm text-gray-600">Resources: {{ $module_materials->count() }}</p>
                                </div>
                                <hr class="bg-[var(--custom-darkblue)] h-[4px] w-full my-4">
                                <div class="module-content grid grid-cols-2 px-2 gap-2">
                                    @foreach ($module_materials as $material)

                                    @if ($material->type == 1)
                                        @if (materialFileType($material->resource, $pdfFormat))
                                        <a href="{{asset('files/'.$material->resource)}}" target="_blank" class="flex flex-row gap-4 w-full h-[80px] rounded-md border-[1px] border-gray-600 px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                            <span class="flex items-center justify-center">
                                                <i class='bx bxs-file-pdf text-red-400 text-4xl' ></i>
                                            </span>
                                            <div class="flex flex-col text-ellipsis overflow-hidden">
                                                <span class="">
                                                    {{ $material->name }}
                                                </span>
                                                <span class="text-sm text-gray-400">
                                                    {{ $material->resource }}
                                                </span>
                                            </div>
                                        </a>
                                        @endif
                                        
                                        @if (materialFileType($material->resource, $videoFormats))
                                        <a href="{{asset('files/'.$material->resource)}}" target="_blank" class="flex flex-row gap-4 w-full h-[80px] rounded-md border-[1px] border-gray-600 px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                            <span class="flex items-center justify-center">
                                                <i class='bx bxs-videos text-green-400 text-4xl'></i>
                                            </span>
                                            <div class="flex flex-col text-ellipsis overflow-hidden">
                                                <span class="">
                                                    {{ $material->name }}
                                                </span>
                                                <span class="text-sm text-gray-400">
                                                    {{ $material->resource }}
                                                </span>
                                            </div>
                                        </a>
                                        @endif
                                    @endif
                                    @if ($material->type == 2)
                                        <a href="{{$material->resource}}" target="_blank" class="flex flex-row gap-4 w-full h-[80px] rounded-md border-[1px] border-gray-600 px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                            <span class="flex items-center justify-center">
                                                {{-- <i class='bx bxs-file-pdf text-red-400 text-4xl' ></i> --}}
                                                <i class='bx bx-link text-blue-400 text-4xl'></i>
                                            </span>
                                            <div class="flex flex-col text-ellipsis overflow-hidden">
                                                <span class="">
                                                    {{ $material->name }}
                                                </span>
                                                <span class="text-sm text-gray-400">
                                                    {{ $material->resource }}
                                                </span>
                                            </div>
                                        </a>
                                    @endif
                                    
                                    @endforeach
                                </div>
                                @if ($module->is_task == 1)
                                <hr class="bg-[var(--custom-darkblue)] h-[1px] w-full my-4">
                                <div class="flex flex-col gap-2">
                                    <div class="text-sm">Submissions</div>
                                    <p class="text-sm text-gray-600">Max file size: 5mb</p>
                                    <form action="{{route('module.upload.taskmaterial')}}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{$course->id}}"/>
                                        <input type="hidden" name="module_id" value="{{$module->id}}"/>

                                        <div class="module-content grid grid-cols-2 px-2 gap-2" id="submissions_{{$module->id}}">
                                            @php
                                                $files = getUploadedFiles($course->id, $module->id);
                                            @endphp
                                            @if (isset($files))
                                                @foreach ($files as $file)
                                                    <div class="">
                                                        <a href="{{$file->filepath}}" target="_blank" class="flex flex-row gap-4 w-full h-[80px] rounded-md border-[1px] border-gray-600 px-4 py-2 hover:bg-gray-100">
                                                            <span class="flex items-center justify-center">
                                                                <i class='bx bx-cloud-upload text-4xl' ></i>
                                                            </span>
                                                            <div class="flex flex-col text-ellipsis overflow-hidden">
                                                                <span class="">
                                                                    {{$file->filename}}
                                                                </span>
                                                                <span class="text-sm text-gray-400">
                                                                    {{$file->filesize}}
                                                                </span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>

                                        <div class="flex flex-row gap-2">
                                            <label for="moduleFileUpload_{{$module->id}}"
                                                class="bg-[var(--custom-darkblue)] text-white text-sm px-4 py-2.5 outline-none rounded w-max cursor-pointer font-[sans-serif]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 mr-2 fill-white inline" viewBox="0 0 32 32">
                                                    <path
                                                    d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z"
                                                    data-original="#000000" />
                                                    <path
                                                    d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z"
                                                    data-original="#000000" />
                                                </svg>
                                            Upload
                                            <input type="file" id='moduleFileUpload_{{$module->id}}' key="{{$module->id}}" name="uploaded_files[]" class="moduleFileUpload hidden" multiple/>
                                            </label>
                                    
                                            <button type="button" id="clearFileUpload_{{$module->id}}" data-action="{{$module->id}}"
                                                class="clearFileUpload bg-[var(--custom-orange)] text-white text-sm px-4 py-2.5 outline-none rounded w-max cursor-pointer font-[sans-serif]">
                                                Clear
                                            </button>
                                            <button type="submit" id=""
                                                class="clearFileUpload bg-[var(--custom-lightblue)] text-white text-xl px-4 py-2.5 outline-none rounded w-max cursor-pointer font-[sans-serif]">
                                                <i class='bx bxs-cloud-upload' ></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                @endif
                                

                                <hr class="bg-[var(--custom-darkblue)] h-[2px] w-full my-4">
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
                                            <div class="flex items-center">
                                                <button type="submit" class="flex justify-center items-center text-lg  max-h-[40px] font-bold text-green-400 hover:text-[var(--custom-orange)]">
                                                    Post&nbsp;
                                                    <i class='bx bx-send' ></i>
                                                </button>
                                            </div>
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
                            @endforeach

                            
                            
                        </div>
                        <div id="assessment-section" class="section">
                            <!-- Assessment content will be displayed here -->
                            @foreach($assessments as $assessment)
                                <form action="{{ route('student.assessments.submit') }}" method="POST" class="submitAssessment">
                                @csrf
                                <div id="assessment_view_{{$assessment->id}}" class="assessment-view flex flex-col sm:px-[5%] md:px-[10%] lg:px-[20%] w-full hidden">
                                        <input type="hidden" name="assessment_id" value="{{$assessment->id}}">
                                    <div class="module-header px-2">
                                        <span class="text-4xl">{{ $assessment->assessment_name }}</span>
                                        {{-- <p class="text-md text-gray-600">{{ $assess->description }}</p> --}}
                                        @php
                                            $total_points = assessmentPoints($assessment);
                                            $taken = isAssessmentDone(auth()->user()->id, $assessment->id);
                                            $score = studentScore(auth()->user()->id, $assessment->id);
                                        @endphp
                                        <p class="text-sm text-gray-600">Total Points: {{ $total_points }}</p>
                                        @if ($assessment->powerups == true)
                                            <p class="text-sm text-gray-600 uppercase font-bold">POWERUPS ENABLED</p>
                                        @endif
                                        @if ($taken)
                                        <p class="text-sm text-gray-600 uppercase">Score: {{ $score }}</p>
                                        @endif
                                    </div>
                                    
                                    <hr class="bg-[var(--custom-darkblue)] h-[4px] w-full my-4">
                                    @if (!$taken)
                                    <div class="assessment-content">
                                        <div>
                                            <p>{{$assessment->direction}}</p>
                                        </div>
                                        @foreach ($assessment->items as $key => $item)
                                            <hr class="my-4">
                                            <div class="flex flex-col">
                                                <div class="flex flex-row flex-nowrap justify-between bg-[var(--custom-orange)] px-4 py-2 rounded-t-md text-white">
                                                    {{-- <span>Item {{$key}}</span> --}}
                                                    <span>Points: {{$item['points']}}</span>
                                                    @if ($assessment->powerups == true && $item['answer_type'] === "multiple_choice")
                                                    <div class="flex items-center w-auto gap-2">
                                                        <button type="button" class="powerup-btn" data-action="sendhelp" data-target="{{$assessment->id}}" data-item="{{$key}}"><i class='bx bx-low-vision'></i></button>
                                                        <button type="button" class="powerup-btn" data-action="50-50" data-target="{{$assessment->id}}" data-item="{{$key}}"><i class='bx bxs-star-half' ></i></button>
                                                        <button type="button" class="powerup-btn" data-action="1by1" data-target="{{$assessment->id}}" data-item="{{$key}}"><i class='bx bx-x-circle' ></i></button>
                                                    </div>
                                                    @endif
                                                    
                                                </div>
                                                <div class="flex flex-col px-4 py-2 border-gray-200 border-[1px] rounded-b-md">
                                                    @if (isset($item['picture']))
                                                        <img src="data:image/png;base64,{{ $item['picture'] }}" alt="Item Picture" style="max-width: 100%; height: auto;">
                                                    @endif
                                                    {{-- <img src="data:image/png;base64,{{ $item['picture'] }}" alt="Base64 Image"> --}}

                                                    <div class="mb-4 font-bold">
                                                        <span> {{$item['question']}}</span>
                                                    </div>

                                                    @if ($item['answer_type'] === "single")
                                                    <div class="flex flex-col gap-2">
                                                        {{-- <div class="">
                                                            <span>Answer:</span>
                                                        </div> --}}
                                                        <div class="">
                                                            <input placeholder="" name="item[{{$key}}]" class="w-full border-[1px] border-gray-400 px-2 py-1 rounded-sm"/>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    @if ($item['answer_type'] === "multiple")
                                                    <div class="flex flex-col gap-2">
                                                        {{-- <div class="">
                                                            <span>Answer:</span>
                                                        </div> --}}
                                                        @foreach ($item['correct_answers'] as $index => $answer)
                                                        <div class="">
                                                            <input placeholder="Answer {{$index + 1}}" name="item[{{$key}}][answers][]" class="w-full border-[1px] border-gray-400 px-2 py-1 rounded-sm"/>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @endif

                                                    @if ($item['answer_type'] === "long")
                                                    <div class="flex flex-col gap-2">
                                                        {{-- <div class="">
                                                            <span>Answer:</span>
                                                        </div> --}}
                                                        <div class="">
                                                            <textarea placeholder="" name="item[{{$key}}]" class="w-full border-[1px] border-gray-400 px-2 py-1 rounded-sm" cols="3"></textarea>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    @if ($item['answer_type'] === "multiple_choice")
                                                    <div class="flex flex-col gap-2">
                                                        {{-- <div class="">
                                                            <span>Answer:</span>
                                                        </div> --}}
                                                        <div id="choices_{{$assessment->id}}_{{$key}}">
                                                            @foreach ($item['choices'] as $index => $choice)
                                                            <div class="flex flex-row flex-nowrap gap-2 justify-start w-full">
                                                                <input type="radio" id="itemRadio_[{{$key}}][{{$index}}]" name="item[{{$key}}]" value="{{$choice}}" class="border-[1px] border-gray-400 px-2 py-1 rounded-sm"/>
                                                                <label for="itemRadio_[{{$key}}][{{$index}}]">{{$choice}}</label>

                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="flex-flex-row flex-reverse mt-4">
                                        <button type="submit" class="py-1 px-4 bg-[var(--custom-orange)] text-white rounded-md">Submit</button>
                                    </div>
                                    @else
                                    <p class="text-2xl text-gray-600 uppercase text-green-600 font-bold">Test Already Taken</p>
                                    @endif
                                </div>
                                </form>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
        </section>
    
    <style>
        .course-main-container {
            display: flex;
            flex-direction: row;
            height: auto;
            min-height: 60vh;
        }
        .left-panel {
            border-right: 1px solid gray;
            margin-right: 16px;
        }
        /* .main-panel {
            width: 100%;
            height: 100%;
        } */
        /* .materials-list{
            margin-left: 16px;
        } */
        .hidden{
            display: none;
        }
        .active{
            /* background: #e4e4e4; */
            color: var(--custom-orange);
        }
        .user-comments{
            overflow-y: scroll;
            max-height: 800px !important;
        }
    </style>
    <script>
        // Add event listeners to modules
        document.querySelectorAll('.module').forEach(item => {
            item.addEventListener('click', event => {

                let assessment_section = document.getElementById('assessment-section');
                if (!assessment_section.classList.contains('hidden')){
                    assessment_section.classList.add('hidden');
                }
                let material_section = document.getElementById('material-section');
                if (material_section.classList.contains('hidden')){
                    material_section.classList.remove('hidden');
                }
                
                // show module view
                let views = document.querySelectorAll('.module-view');
                views.forEach((e) => {
                    if (!e.classList.contains('hidden')) {
                        e.classList.add('hidden');
                    }
                });
                let target = document.getElementById('module_view_' + event.target.value);
                target.classList.remove('hidden');

                // active module
                let modules = document.querySelectorAll('.module');
                modules.forEach((e) => {
                    if (e.classList.contains('active')) {
                        e.classList.remove('active');
                    }
                });
                let assessments = document.querySelectorAll('.assessment');
                assessments.forEach((e) => {
                    if (e.classList.contains('active')) {
                        e.classList.remove('active');
                    }
                });
                event.target.classList.add('active');
            });
        });

        document.querySelectorAll('.assessment').forEach(item => {
            item.addEventListener('click', event => {
                
                let material_section = document.getElementById('material-section');
                if (!material_section.classList.contains('hidden')){
                    material_section.classList.add('hidden');
                }
                let assessment_section = document.getElementById('assessment-section');
                if (assessment_section.classList.contains('hidden')){
                    assessment_section.classList.remove('hidden');
                }
                // show module view
                let views = document.querySelectorAll('.assessment-view');
                views.forEach((e) => {
                    if (!e.classList.contains('hidden')) {
                        e.classList.add('hidden');
                    }
                });
                let target = document.getElementById('assessment_view_' + event.target.value);
                
                target.classList.remove('hidden');

                // active module
                let modules = document.querySelectorAll('.module');
                modules.forEach((e) => {
                    if (e.classList.contains('active')) {
                        e.classList.remove('active');
                    }
                });
                let assessments = document.querySelectorAll('.assessment');
                assessments.forEach((e) => {
                    if (e.classList.contains('active')) {
                        e.classList.remove('active');
                    }
                });
                event.target.classList.add('active');
            });
        });

        window.onload = function() {
            let modules = {!! json_encode($modules) !!}; // Convert PHP array to JavaScript array

            // Check if modules array is not empty
            if (modules.length > 0) {
                    let target_view = document.getElementById('module_view_' + modules[0].id);
                    if (target_view) {
                        target_view.classList.remove('hidden');

                        let target_module = document.getElementById('module_' + modules[0].id);
                        if (target_module) {
                            target_module.classList.add('active');
                        }
                    }
            }
        };

        
        document.querySelectorAll('.moduleFileUpload').forEach(item => {
            item.addEventListener('change', event => {
                const files = event.target.files;
                const id = event.target.id.split('_')[1];
        
                const fileContainer = document.getElementById('submissions_' + id);
                fileContainer.innerHTML = '';
                

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileItem = document.createElement('div');
                    fileItem.innerHTML =
                    `
                    <div class="flex flex-row gap-4 w-full h-[80px] rounded-md border-[1px] border-gray-600 px-4 py-2 hover:bg-gray-100">
                        <span class="flex items-center justify-center">
                            <i class='bx bx-cloud-upload text-4xl' ></i>
                        </span>
                        <div class="flex flex-col text-ellipsis overflow-hidden">
                            <span class="">
                                ${file.name}
                            </span>
                            <span class="text-sm text-gray-400">
                                ${formatBytes(file.size)}
                            </span>
                        </div>
                    </div>
                    `;
                    fileContainer.appendChild(fileItem); 
                }
            });
        });

        document.querySelectorAll('.clearFileUpload').forEach(item => {
            item.addEventListener('click', event => {
                const id = event.target.id.split('_')[1];
                const fileInput = document.getElementById('moduleFileUpload_' + id);
                fileInput.value = null;
                const changeEvent = new Event('change', { bubbles: true });
        
                fileInput.dispatchEvent(changeEvent);

                
                $.ajax({
                    url: "{{ route('module.clear.taskmaterial') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        course_id: '{{$course->id}}',
                        module_id: event.target.getAttribute('data-action')
                    },
                    success: function(response) {
                        console.log(response);
                        // Handle the response here
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle errors here
                    }
                });
            });
        });

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
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

@if(session('mark_done'))
<script>
  notify("Success", "{{ session('mark_done') }}", "success");
</script>
@endif

@if(session('mark_not_done'))
<script>
  notify("Success", "{{ session('mark_not_done') }}", "success");
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