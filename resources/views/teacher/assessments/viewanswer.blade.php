@include('partials.header', ['title' => 'Answer'])
<div class="main-container">
    {{-- @include('partials.sidebar', ['active' => 'courses']) --}}
    <main class="main home w-full">
        
        <section class="courses-main-section p-4">
            {{-- Content --}}
            <div class="section-content bg-white w-full h-[auto] rounded-md pt-8 pb-4 px-5 shadow-lg">
                <div class="course-main-container">
                
                    <div class="main-panel w-full">
                        <div id="assessment-section" class="section">
                            <!-- Assessment content will be displayed here -->
                            {{-- <button id="generatePDF" class="px-4 py-2 bg-[var(--custom-orange)] text-white">Download</button> --}}
                            <form action="{{ route('student.assessments.submit') }}" method="POST" class="submitAssessment">
                            @csrf
                            <div id="downloadable">
                            <div id="assessment_view" class="assessment-view flex flex-col sm:px-[5%] md:px-[10%] lg:px-[20%] w-full">
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
                                    @php
                                        $fullname = $student->lastname . ", " . $student->firstname . " " . $student->middlename;
                                    @endphp
                                    <p class="text-lg text-gray-600 uppercase font-bold">{{$fullname}}</p>
                                    {{-- <p class="text-sm text-gray-600 uppercase">Score: {{ $score }}</p> --}}
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
                                                {{-- @if ($assessment->powerups == true && $item['answer_type'] === "multiple_choice")
                                                <div class="flex items-center w-auto gap-2">
                                                    <button type="button" class="powerup-btn" data-action="sendhelp" data-target="{{$assessment->id}}" data-item="{{$key}}"><i class='bx bx-low-vision'></i></button>
                                                    <button type="button" class="powerup-btn" data-action="50-50" data-target="{{$assessment->id}}" data-item="{{$key}}"><i class='bx bxs-star-half' ></i></button>
                                                    <button type="button" class="powerup-btn" data-action="1by1" data-target="{{$assessment->id}}" data-item="{{$key}}"><i class='bx bx-x-circle' ></i></button>
                                                </div>
                                                @endif --}}
                                                
                                            </div>
                                            <div class="flex flex-col px-4 py-2 border-gray-200 border-[1px] rounded-b-md">
                                                @if (isset($item['picture']))
                                                    <img src="data:image/png;base64,{{ $item['picture'] }}" alt="Item Picture" style="max-width: 100%; height: auto;">
                                                @endif
                                                {{-- <img src="data:image/png;base64,{{ $item['picture'] }}" alt="Base64 Image"> --}}

                                                <div class="mb-4 font-bold">
                                                    <span>{{$key}}. {{$item['question']}}</span>
                                                </div>

                                                @if ($item['answer_type'] === "single")
                                                <div class="flex flex-col gap-2">
                                                    <div class="">
                                                        <span>Answer:</span>
                                                    </div>
                                                    <div class="">
                                                        <input placeholder="" name="item[{{$key}}]" class="w-full border-[1px] border-gray-400 px-2 py-1 rounded-sm"
                                                        value="{{$answers->answers[$key]}}"
                                                        disabled
                                                        />
                                                    </div>
                                                </div>
                                                @endif

                                                @if ($item['answer_type'] === "multiple")
                                                <div class="flex flex-col gap-2">
                                                    <div class="">
                                                        <span>Answer:</span>
                                                    </div>
                                                    @foreach ($item['correct_answers'] as $index => $answer)
                                                    <div class="">
                                                        <input placeholder="Answer {{$index + 1}}" name="item[{{$key}}][answers][]" class="w-full border-[1px] border-gray-400 px-2 py-1 rounded-sm"
                                                        value="{{$answers->answers[$key]['answers'][$index]}}"
                                                        disabled
                                                        />
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif

                                                @if ($item['answer_type'] === "long")
                                                
                                                <div class="flex flex-col gap-2">
                                                    <div class="">
                                                        <span>Answer:</span>
                                                    </div>
                                                    <div class="">
                                                        <textarea placeholder="" name="item[{{$key}}]" class="w-full border-[1px] border-gray-400 px-2 py-1 rounded-sm" cols="3" disabled>{{$answers->answers[$key]}}</textarea>
                                                    </div>
                                                </div>
                                                @endif

                                                @if ($item['answer_type'] === "multiple_choice")
                                                <div class="flex flex-col gap-2">
                                                    <div class="">
                                                        <span>Answer:</span>
                                                    </div>
                                                    <div id="choices_{{$assessment->id}}_{{$key}}">
                                                        @foreach ($item['choices'] as $index => $choice)
                                                        <div class="flex flex-row flex-nowrap gap-2 justify-start w-full">
                                                            <input type="radio" id="itemRadio_[{{$key}}][{{$index}}]" name="item[{{$key}}]" value="{{$choice}}" class="border-[1px] border-gray-400 px-2 py-1 rounded-sm"
                                                            
                                                            @if ($answers->answers[$key] === $choice)
                                                            checked
                                                            @endif

                                                            disabled
                                                            />
                                                            <label for="itemRadio_[{{$key}}][{{$index}}]">{{$choice}}</label>
                                                            {{-- {{$answers->answers[$key]}} --}}
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            
                                        </div>
                                    @endforeach
                                </div>
                                
                                
                                @else
                                <p class="text-2xl text-gray-600 uppercase text-green-600 font-bold">Test Already Taken</p>
                                @endif
                            </div>
                            </div>
                            </form>
                            
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
        document.getElementById('generatePDF').addEventListener('click', event => {
            var doc = $('#downloadable');
            $.ajax({
                type: 'POST',
                url: '/download-answer',
                data: {
                    _token: '{{ csrf_token() }}',
                    data: {
                        content: doc.html()
                    }
                },
                success: function(response) {
                    console.log(response);
                    alertify.success('Downloading...');
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    alertify.error('Oops. Something went wrong.');
                }
            });
        })
        

        


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