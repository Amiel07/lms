@include('partials.header', ['title' => 'Certification - '.$course->name])


<div class="main-container">
    {{-- @include('partials.navbar', ['t_dashboard' => true]) --}}
    @include('partials.sidebar', ['active' => 'certifications'])
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => $course->name . ' > Certify'])

        {{-- Main Section Container --}}
        <section class="courses-main-section">

            {{-- Header --}}
            <div class="section-header bg-white w-full h-[66px] rounded-md p-4 shadow-lg">
                <div class="bg-white breadcrumbs-student w-full h-aut py-2 px-4 rounded-md">
                    <a href="{{ route('teacher.certifications.courses') }}" class="text-gray-500">Certificates </a>
                    <a href="" class="">> {{$course->course_code}} </a>
                </div>
            </div>

            {{-- Content --}}
            <div class="section-content bg-white w-full h-[550px] rounded-md pt-8 pb-4 px-5">
                <div class="w-full h-auto">
                    <span class="text-xl">
                        Course Details
                    </span>
                </div>
                <hr>
                <div class="flex flex-col">
                    <form action="{{ route('teacher.certify.generate', ['course' => $course->id]) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-2 gap-8 w-full">
                            <div>
                                <span>{{ $course->course_code }} - </span>
                                <span class="text-lg">{{ $course->name }}</span>
                                <br>
                                <span class="text-lg text-gray-500">{{ $students->count() }} student enrolled</span>
                                <br>
                                <span class="text-lg text-gray-500">{{ $completedStudents->count() }} completed the course</span>
                                <br>
                                <span class="text-lg text-gray-500">{{ $alreadyCertified->count() }} student already certified</span>
                                <br>
                                <span class="text-lg text-gray-500">{{ $studentsToCertify->count() }} student not certified</span>
                            </div>
                            <div class="border-[1px] border-gray-200 w-full overflow-scroll p-2 h-[200px] col-span-2">
                                @foreach ($studentsToCertify as $student)
                                    <input type="checkbox" value="{{ $student->id }}" name="student_ids[]" onchange="updateSelectedCount()"> {{ $student->lastname.', '.$student->firstname.' '.$student->middlename }}</input>
                                    <br>
                                @endforeach
                            </div>
                        </div>
                        <div class="student-certificate mt-8 grid grid-cols-2 gap-8">
                                <div>
                                    <span>Select one:</span>
                                    <select class="js-example-basic-single bg-gray-200 w-full" name="state" onchange="uncheckCheckboxes()" disabled>
                                        <option value="">Select One</option>
                                        @foreach ($completedStudents as $student)
                                            <option value="{{ $student->id }}">{{ $student->lastname.', '.$student->firstname.' '.$student->middlename }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="student-certificate flex flex-wrap gap-4 items-end mt-2">
                                    <button type="button" onclick="selectAll()" class="rounded-md bg-blue-200 px-4 py-2 hover:bg-blue-300">Select all</button>
                                    <button type="button" onclick="clearSelected()"  class="rounded-md bg-gray-200 px-4 py-2 hover:bg-gray-300">Clear selected</button>
                                    <button type="submit"  class="rounded-md bg-green-200 px-4 py-2 hover:bg-green-300">Generate</button>
                                    <span id="selectedCount">Selected: 0</span>
                                </div>
                        </div>
                    </form>
                    <span class="mt-8">Preview:</span>
                    <canvas id="pdfCanvas"></canvas>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
                    
                </div>

            </div>


            <div class="section-menu w-full h-auto rounded-md">
                <div class="bg-white h-auto w-full rounded-md p-4 shadow-lg">
                <ul class="flex flex-col gap-4">
                    <li>
                        No Options
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

<script>
    // PDF.js worker URL
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

    // Path to your PDF file
    var pdfUrl = '/thrivecert/THRIVECERT.pdf'; // Assuming your public URL is accessible from the root

    // Asynchronous function to load and display PDF on canvas
    async function loadPdfToCanvas(pdfUrl) {
        // Fetch PDF document
        const loadingTask = pdfjsLib.getDocument(pdfUrl);
        const pdfDocument = await loadingTask.promise;

        // Get the first page of the PDF
        const pageNumber = 1;
        const page = await pdfDocument.getPage(pageNumber);

        // Set canvas element
        const canvas = document.getElementById('pdfCanvas');
        const context = canvas.getContext('2d');

        // Set desired width and height of the canvas
        const canvasWidth = 561; // Adjust as needed
        const canvasHeight = 397; // Adjust as needed

        // Set canvas dimensions
        canvas.width = canvasWidth;
        canvas.height = canvasHeight;

        // Get the viewport of the PDF page
        const viewport = page.getViewport({ scale: 1 });

        // Calculate scaling factors to fit the PDF page into the canvas
        const scale = Math.min(canvasWidth / viewport.width, canvasHeight / viewport.height);

        // Get the scaled dimensions
        const scaledWidth = viewport.width * scale;
        const scaledHeight = viewport.height * scale;

        // Calculate the offset to center the PDF page on the canvas
        const offsetX = (canvasWidth - scaledWidth) / 2;
        const offsetY = (canvasHeight - scaledHeight) / 2;

        // Render PDF page on canvas with the calculated scaling and offset
        const renderContext = {
            canvasContext: context,
            viewport: page.getViewport({ scale: scale }),
            transform: [scale, 0, 0, scale, offsetX, offsetY]
        };
        await page.render(renderContext);
    }

    // Call the function to load and display PDF on canvas
    loadPdfToCanvas(pdfUrl);
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