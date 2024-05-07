@include('partials.header', ['title' => 'New Quiz'])
<div class="main-container">
    @include('partials.sidebar', ['active' => 'courses'])
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => $course->name. ' > New Quiz'])

        {{-- Main Section Container --}}
        <section class="courses-main-section">

            {{-- Header --}}
            <div class="section-header bg-white w-full h-[66px] rounded-md p-4">
                <ul class="header-menu">
                    <li>
                        <a href="{{ route('teacher.courses.new',['']) }}" class="header-items">
                            <i class='bx bx-plus' ></i>&nbsp;Course
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Content --}}
            <div class="section-content bg-white w-full h-[550px] rounded-md pt-8 pb-4 px-5">
                <div class="w-full h-auto">
                    <span class="text-xl">
                        Create Quiz for <strong>{{ $course->name }}</strong>
                    </span>
                </div>
                
                <form action="{{ route('assessments.store', ['course' => $course->id]) }}" method="POST">
                    @csrf
                    <label for="assessment_name">Name: </label>
                    <input type="text" name="assessment_name" placeholder="New Quiz" id="assessment_name" required>
                    <div id="items-container"></div>
            
                    <button type="button" onclick="addItem()" class="add-item">Add Item</button>
                    <button type="submit" class="create-assessment">Create Quiz</button>
                </form>
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
        background: var(--custom-darkblue);
        border-radius: 10px 0 0 10px;
    }

    .course-display .course-code{
        height: 100%;
        font-size: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        padding: 0 16px;
        color: var(--custom-white);
    }
    .course-display .course-desc{
        height: 100%;
        display: flex;
        align-items: center;
        padding: 0 16px;
        color: var(--custom-white);
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
<script>
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
                    <option value="single">Single Answer Input</option>
                    <option value="multiple">Multiple Answer Input</option>
                    <option value="long">Long Input</option>
                    <option value="multiple_choice">Multiple Choice</option>
                </select>
            
            <div id="correct-answer-container${itemCount}"  class="correct-answer-container"></div>
            <button type="button" onclick="deleteItem(this)" class="item-delete">Delete</button>
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
                <label for="correct_answer">Correct Answer:</label>
                <input type="text" name="items[${itemCount}][correct_answer]" class="single-correct-answer" required>
            `;
        } else if (answerType === 'multiple') {
            correctAnswerContainer.innerHTML = `
                <label for="correct_answer">Correct Answer(s):</label>
                <div>
                    <input type="text" name="items[${itemCount}][correct_answers][]" class="multiple-correct-answer" required>
                    <button type="button" onclick="addMoreCorrectAnswer(this)"  class="multiple-correct-answer-add add-more">Add More</button>
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
        const newInput = document.createElement('div');

        
        const select = container.parentNode.parentNode.querySelector("select");
        if (select.value === 'multiple_choice') {
            newInput.innerHTML = `
            <input type="text" name="items[${itemCount}][choices][]" class="multiple-choice-answer" required>
            <input type="checkbox" name="items[${itemCount}][correct_choice][]" value="" onchange="updateCheckboxValue(this)"> Correct
        `;
        }else{
            newInput.innerHTML = `
            <input type="text" name="items[${itemCount}][correct_answers][]" class="multiple-correct-answer" required>
        `;
        }
        
        container.appendChild(newInput);
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

