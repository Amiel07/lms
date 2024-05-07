@include('partials.header', ['title' =>  'Submitted Files'])


<div class="main-container">
    {{-- @include('partials.navbar', ['t_dashboard' => true]) --}}
    
    <main class="main home w-full">
        <section class="courses-main-section">
            <div class="section-content flex flex-col gap-16 bg-white w-full h-[550px] rounded-md pt-8 pb-4 px-5 shadow-lg">
                <div class="w-full h-auto">
                    <span class="text-xl">
                        Submission List
                    </span>
                </div>
                <hr>
                <div class="module-content grid grid-cols-3 px-2 gap-2">
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