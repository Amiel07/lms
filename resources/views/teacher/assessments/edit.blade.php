@include('partials.header', ['title' => 'Edit Quiz'])


<div class="main-container">
    {{-- @include('partials.navbar', ['t_dashboard' => true]) --}}
    @include('partials.sidebar', ['active' => 'courses'])
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => 'Courses > New Course'])

        {{-- Main Section Container --}}
        <section class="courses-main-section">

            {{-- Header --}}
            <div class="section-header bg-white w-full h-[66px] rounded-md p-4">
                <div class="bg-white breadcrumbs-student w-full h-aut py-2 px-4 rounded-md">
                    <a href="{{route('teacher.courses.all', [''])}}" class="text-gray-500">Courses </a>
                    <a href="{{ route('teacher.courses.course', ['course' => $course->id]) }}" class="text-gray-500">> {{ $course->course_code }} </a>
                    <a href="{{ route('teacher.courses.assessments', ['course' => $course->id]) }}" class="text-gray-500">> All Quizzes </a>
                    <a href="" class="">> Edit Quiz </a>
                </div>
            </div>

            {{-- Content --}}
            <div class="section-content bg-white w-full h-[550px] rounded-md pt-8 pb-4 px-5">
                <div class="w-full h-auto">
                    <span class="text-xl">
                        Quiz Details
                    </span>
                </div>
                <hr>

                <form action="{{ route('assessments.update', ['course' => $course->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col gap-2">
                        {{-- {{json_encode($assessment)}} --}}
                        <input type="hidden" name="assessment_id" value="{{$assessment->id}}">
                        <label for="" class="custom-label">Name</label>
                        <input type="text" name="assessment_name" id="" class="border-solid border-2 custom-input" required value="{{$assessment->assessment_name}}">
                        <label for="" class="custom-label">Directions</label>
                        <textarea type="text" name="direction" id="" class="border-solid border-2 custom-input" required>{{$assessment->direction}}</textarea>
                        <div class="flex flex-row flex-nowrap gap-2">
                            <input type="checkbox" id="checkBox" name="powerups" value="true" @if ($assessment->powerups) checked @endif>
                            <label for="checkBox" class="custom-label uppercase font-bold">ENABLE POWERUPS</label>
                        </div>
                    </div>

                    <div id="items-container" class="my-2">
                        @foreach ($assessment->items as $num => $item)
                        <div class="item assessment-item-container">
                            
                                <div class="item-header">
                                    <label for="item">Item:</label>
                                    <input type="text" name="items[{{$num}}][item]" id="item{{$num}}" value="{{$num}}" class="item-number" required disabled>
                                </div>
                                <div class="item-body assessment-item">
                                    <label for="points">Points:</label>
                                    <input type="number" name="items[{{$num}}][points]" class="item-point" required value="{{$item['points']}}">
                    
                                    <label for="question">Question:</label>
                                    <textarea type="text" name="items[{{$num}}][question]" class="item-question">{{$item['question']}}</textarea>
                    
                                    <label for="picture">Upload Picture:</label>
                                    <input type="file" name="items[{{$num}}][picture]" id="item-upload-{{$num}}" class="item-upload">
                    
                                    <label for="answer_type">Answer Type:</label>
                                    <select name="items[{{$num}}][answer_type]" onchange="addCorrectAnswer(this)" class="item-select" required>
                                        <option value="">...</option>
                                        <option value="single" @if ($item['answer_type'] === 'single') selected @endif>Single Answer</option>
                                        <option value="multiple" @if ($item['answer_type'] === 'multiple') selected @endif>Multiple Answer</option>
                                        <option value="long" @if ($item['answer_type'] === 'long') selected @endif>Essay Type Answer</option>
                                        <option value="multiple_choice" @if ($item['answer_type'] === 'multiple_choice') selected @endif>Multiple Choice</option>
                                    </select>
                                
                                    <div id="correct-answer-container{{$num}}"  class="correct-answer-container">
                                        @if ($item['answer_type'] === 'single') 
                                                <p class="text-sm text-gray-500">
                                                    *Use ";" in between to separate acceptable answers (i.e. Jose;Rizal).<br>
                                                    *Use "<>" in between to specify the acceptable range, inclusively (i.e. 5.3<>6.05).
                                                </p>
                                                <label for="correct_answer">Correct Answer:</label>
                                                <input type="text" name="items[{{$num}}][correct_answer]" class="single-correct-answer" required value="{{$item['correct_answer']}}">
                                            
                                        @endif
                                        @if ($item['answer_type'] === 'multiple') 
                                                <p class="text-sm text-gray-500">*Please make sure you have "_" in the question to add answer fields. The number of fields will reflect the number of "_". The answers are checked in order of the "_".</p>
                                                <label for="correct_answer">Correct Answer(s):</label>
                                                <div>
                                                    <button type="button" onclick="addMoreCorrectAnswer(this)"  class="multiple-correct-answer-add add-more">Auto Add Fields</button>
                                                    @foreach ($item['correct_answers'] as $answer)
                                                    <div class="">
                                                        <input type="text" name="items[{{$num}}][correct_answers][]" class="multiple-correct-answer" required value="{{$answer}}">
                                                    </div>
                                                    @endforeach
                                                </div>
                                        @endif
                                        @if ($item['answer_type'] === 'multiple_choice')
                                                <label for="correct_answer">Correct Answer:</label>
                                                <div>
                                                    
                                                    @foreach ($item['choices'] as $cnum => $choice)
                                                    @if ($cnum === 0)
                                                    <input type="text" name="items[{{$num}}][choices][]" class="multiple-choice-answer" required value="{{$choice}}">
                                                    <input type="checkbox" name="items[{{$num}}][correct_choice][]" value="{{$choice}}" onchange="updateCheckboxValue(this)" @if (in_array($choice, $item["correct_choice"])) checked @endif> Correct
                                                    <button type="button" onclick="addMoreCorrectAnswer(this)"  class="multiple-choice-answer-add add-more">Add More</button>
                                                    @continue
                                                    @endif
                                                    <div class="">
                                                        <input type="text" name="items[{{$num}}][choices][]" class="multiple-choice-answer" required value="{{$choice}}">
                                                        <input type="checkbox" name="items[{{$num}}][correct_choice][]" value="{{$choice}}" onchange="updateCheckboxValue(this)" @if (in_array($choice, $item["correct_choice"])) checked @endif> Correct
                                                        <button type="button" class="text-red-400" onclick="deleteElement(this)"><i class='bx bx-trash'></i></button>
                                                    </div>
                                                    @endforeach
                                                </div>
                                        @endif
                                    </div>
                                    <button type="button" onclick="deleteItem(this)" class="item-delete">
                                        <span class="flex items-center justify-center gap-2 text-red-400">
                                                    <i class='bx bxs-plus-square text-lg'></i>
                                                    <span>Remove Question</span>
                                        </span>
                                    </button>
                                </div>
                            
                        </div>
                        @endforeach
                    </div>

                    <div class="flex flex-col gap-2 w-auto">
                        <button type="button" onclick="addItem()" class="add-item mt-2 max-w-[200px]">
                            <span class="flex items-center gap-2 hover:text-[var(--custom-orange)]">
                                <i class='bx bxs-plus-square text-lg '></i>
                                <span>Add Question</span>
                            </span>
                        </button>
                        <button type="submit" class="create-assessment max-w-[200px]">
                            <span class="flex items-center gap-2 hover:text-[var(--custom-orange)]">
                                <i class='bx bxs-save text-lg'></i>
                                <span>Update Quiz</span>
                            </span>
                        </button>
                    </div>
                </form>
                

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
                        <a href="{{ route('teacher.courses.assessments', ['course' => $course->id]) }}">
                            <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                <i class='bx bx-book-bookmark menu-button-icon' ></i>
                                <span class="hidden lg:block">&nbsp;All Quizzes</span>
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
    function deleteElement(button) {
        var parentElement = button.parentElement;
        parentElement.remove();
    }
    function addItem() {
        const itemsContainer = document.getElementById('items-container');
        const itemCount = itemsContainer.children.length + 1;

        const newItem = document.createElement('div');
        newItem.classList.add('item');
        newItem.classList.add('assessment-item-container');

        newItem.innerHTML = `
            <div class="item-header">
                <label for="item">Item:</label>
                <input type="text" name="items[${itemCount}][item]" id="item${itemCount}" value="${itemCount}" class="item-number" required disabled>
            </div>
            <div class="item-body assessment-item">
                <label for="points">Points:</label>
                <input type="number" name="items[${itemCount}][points]" class="item-point" required>

                <label for="question">Question:</label>
                <textarea type="text" name="items[${itemCount}][question]" class="item-question"></textarea>

                <label for="picture">Upload Picture:</label>
                <input type="file" name="items[${itemCount}][picture]" class="item-upload">

                <label for="answer_type">Answer Type:</label>
                <select name="items[${itemCount}][answer_type]" onchange="addCorrectAnswer(this)" class="item-select" required>
                    <option value="">...</option>
                    <option value="single">Single Answer</option>
                    <option value="multiple">Multiple Answer</option>
                    <option value="long">Essay Type Answer</option>
                    <option value="multiple_choice">Multiple Choice</option>
                </select>
            
            <div id="correct-answer-container${itemCount}"  class="correct-answer-container"></div>
            <button type="button" onclick="deleteItem(this)" class="item-delete">
                <span class="flex items-center justify-center gap-2 text-red-400">
                            <i class='bx bxs-plus-square text-lg'></i>
                            <span>Remove Question</span>
                </span>
            </button>
            </div>
        `;

        itemsContainer.appendChild(newItem);
        updateItemIndices();
    }

    function addCorrectAnswer(select) {
        const itemContainer = select.parentNode;
        const itemCount = itemContainer.querySelector('input[name^="items"]').getAttribute('name').match(/\d+/)[0];
        const answerType = select.value;
        const correctAnswerContainer = document.getElementById(`correct-answer-container${itemCount}`);
        correctAnswerContainer.innerHTML = ''; // Clear previous correct answer inputs

        if (answerType === 'single') {
            correctAnswerContainer.innerHTML = `
                <p class="text-sm text-gray-500">
                    *Use ";" in between to separate acceptable answers (i.e. Jose;Rizal).<br>
                    *Use "<>" in between to specify the acceptable range, inclusively (i.e. 5.3<>6.05).
                </p>
                <label for="correct_answer">Correct Answer:</label>
                <input type="text" name="items[${itemCount}][correct_answer]" class="single-correct-answer" required>
            `;
        } else if (answerType === 'multiple') {
            correctAnswerContainer.innerHTML = `
                <p class="text-sm text-gray-500">*Please make sure you have "_" in the question to add answer fields. The number of fields will reflect the number of "_". The answers are checked in order of the "_".</p>
                <label for="correct_answer">Correct Answer(s):</label>
                <div>
                    <button type="button" onclick="addMoreCorrectAnswer(this)"  class="multiple-correct-answer-add add-more">Auto Add Fields</button>
                </div>
            `;
        } else if (answerType === 'multiple_choice') {
            correctAnswerContainer.innerHTML = `
                <label for="correct_answer">Correct Answer:</label>
                <div>
                    <input type="text" name="items[${itemCount}][choices][]" class="multiple-choice-answer" required>
                    <input type="checkbox" name="items[${itemCount}][correct_choice][]" value="" onchange="updateCheckboxValue(this)" > Correct
                    <button type="button" onclick="addMoreCorrectAnswer(this)"  class="multiple-choice-answer-add add-more">Add More</button>
                </div>
            `;
        }
    }

    function addMoreCorrectAnswer(button) {
        const container = button.parentNode;
        const itemCount = container.parentNode.id.replace('correct-answer-container', '');
        

        
        const select = container.parentNode.parentNode.querySelector("select");
        if (select.value === 'multiple_choice') {
            let newInput = document.createElement('div');
            newInput.innerHTML = `
            <input type="text" name="items[${itemCount}][choices][]" class="multiple-choice-answer" required>
            <input type="checkbox" name="items[${itemCount}][correct_choice][]" value="" onchange="updateCheckboxValue(this)"> Correct
            <button type="button" class="text-red-400" onclick="deleteElement(this)"><i class='bx bx-trash'></i></button>
        `;
            container.appendChild(newInput);
        }else{
            const question = container.parentNode.parentNode.parentNode.querySelector(".item-question");
            let count = 0;
            for (let i = 0; i < question.value.length; i++){
                if (question.value[i] === '_'){
                    count++;
                }
            }
            
            container.innerHTML = `
            <button type="button" onclick="addMoreCorrectAnswer(this)"  class="multiple-correct-answer-add add-more">Auto Add Fields</button>
            `;

            for (let i = 0; i < count; i++){
                let newInput = document.createElement('div');
                newInput.innerHTML += `
                <input type="text" name="items[${itemCount}][correct_answers][]" class="multiple-correct-answer" required>
                `;
                container.appendChild(newInput);
            }
            
        }
        
        // container.appendChild(newInput);
    }


    function updateCheckboxValue(checkbox) {
        const inputValue = checkbox.previousElementSibling.value;
        checkbox.value = inputValue;
    }

    function deleteItem(button) {
        const item = button.parentNode.parentNode;
        const itemsContainer = item.parentNode
        itemsContainer.removeChild(item);
        updateItemIndices();
    }

    function updateItemIndices() {
        const itemsContainer = document.getElementById('items-container');
        const items = itemsContainer.children;
        for (let i = 0; i < items.length; i++) {
            const inputs = items[i].querySelectorAll('input, select');
            inputs.forEach(input => {
                const oldName = input.getAttribute('name');
                const newName = oldName.replace(/\[\d+\]/, `[${i + 1}]`);
                input.setAttribute('name', newName);
                if (input.id.startsWith("item")){
                    input.setAttribute('value', i + 1);
                    input.setAttribute('id', "item" + (i+1));
                }
                
            });
            const correctAnswerContainer = items[i].querySelector(`[id^="correct-answer-container"]`);
            if (correctAnswerContainer) {
                correctAnswerContainer.id = `correct-answer-container${i + 1}`;
            }
        }
    }
</script>

<style>
    .add-item, .create-assessment{
        /* border-radius: 4px;
        background: rgb(54, 73, 94);
        padding: 2px 8px;
        color: white;
        margin-top: 8px; */
    }
    .add-item{

    }
    .create-assessment{

    }
    #assessment_name{
        border: 1px solid gray;
        border-radius: 4px;
        padding: 2px 8px;
    }
    .assessment-item-container{
        /* border: 2px solid gray; */
        box-shadow: 0 0 10px 2px rgba(0,0,0,0.2);
        border-radius: 10px;
        margin: 16px 0px;

    }
    .assessment-item{
        /* border: 2px solid gray; */
        /* padding: 8px 6px; */
        display: grid;
        gap: 8px;
    }
    .item-number, .item-point, .item-question, .item-select, .single-correct-answer, .multiple-correct-answer,.multiple-choice-answer{
        border: 1px solid gray;
        border-radius: 4px;
        padding: 2px 8px;
    }

    .item-number{
        background: transparent;
        border: none;
    }
    .item-point{
        
    }
    .item-question{
        
    }
    .item-upload{
        
    }
    .item-select{
        
    }
    .correct-answer-container{
        
    }
    .item-delete{
        border-radius: 4px;
        /* background: red; */
    }
    .single-correct-answer{

    }
    .multiple-correct-answer{

    }
    .multiple-correct-answer-add{

    }
    .multiple-choice-answer{

    }
    .multiple-choice-answer-add{

    }
    .add-more{
        border-radius: 4px;
        background: rgb(54, 73, 94);
        color:white;
        padding: 2px 4px;
    }
    .item-header{
        background:rgb(54, 73, 94);
        color: white;
        padding: 8px 8px;
        border-radius: 10px 10px 0 0;
    }
    .item-body{
        padding: 8px;
    }

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
    window.onload = function () {
        var jsonItems = JSON.parse('<?php echo json_encode($assessment->items); ?>');
        for (var key in jsonItems) {
            if (jsonItems.hasOwnProperty(key)) {
                var question = jsonItems[key];

                if (question.picture){
                    var base64String = question.picture;

                    // Convert base64 string to Blob
                    var byteCharacters = atob(base64String);
                    var byteNumbers = new Array(byteCharacters.length);
                    for (var i = 0; i < byteCharacters.length; i++) {
                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                    }
                    var byteArray = new Uint8Array(byteNumbers);
                    var blob = new Blob([byteArray], { type: 'image/png' }); // Adjust the type accordingly

                    // Convert Blob to File
                    var file = new File([blob], "question_"+ key + ".png", { type: 'image/png' }); // Adjust the file name and type accordingly

                    var fileInput = document.getElementById('item-upload-' + key);
                    // fileInput.files = [file];

                    var fileList = new DataTransfer();
                    fileList.items.add(file);
                    fileInput.files = fileList.files;
                }
            }
        }
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