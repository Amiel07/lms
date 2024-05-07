@include('partials.header', ['title' => 'Courses'])
<div class="main-container">
    {{-- @include('partials.sidebar', ['active' => 'courses']) --}}
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => 'Courses'])

        {{-- Main Section Container --}}
        <section class="courses-main-section p-4">

            {{-- Content --}}
            <div class="section-content bg-white w-full h-[85%] rounded-md pt-8 pb-4 px-5">
                <div class="flex justify-center items-center">
                    <div class="flex flex-col rounded-md py-4 px-8 w-[70%] md:w-[50%] lg:w-[40%] border-[1px] border-gray-400">
                        <span class="text-sm text-gray-600">
                            You are currently signed in as
                        </span>
                        <div class="flex items-center mt-2">
                            <i class='bx bx-group text-3xl bg-[var(--custom-darkblue)] text-[var(--custom-white)] rounded-full p-2 mr-2 '></i>
                            <div class="flex flex-col">
                                <span class="text-md">
                                    {{ auth()->user()->firstname . " " . auth()->user()->lastname }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ auth()->user()->email }}
                                </span>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="flex justify-center items-center mt-8">
                    <div class="flex flex-col rounded-md py-4 px-8 w-[70%] md:w-[50%] lg:w-[40%] border-[1px] border-gray-400">
                        <span class="text-lg">
                            Invite Code
                        </span>
                        <span class="text-sm text-gray-500">
                            Codes are given by your teacher
                        </span>
                        <div class="w-72 mt-4">
                            <form action="{{ route('student.enroll.save',['']) }}" method="POST">
                                @csrf
                                <div class="relative w-full min-w-[200px] h-10 mb-2">
                                <input type="text" name="invite_code" class="border-[1px] border-gray-500 rounded-md text-xl py-1 px-2">
                                   
                                </div>
                                <a href="{{ route('student.enroll', ['']) }}">
                                    <button class="bg-[var(--custom-darkblue)] rounded-md py-2 px-8 text-[var(--custom-white)] hover:bg-[var(--custom-orange)] hover:text-white">Enroll</button>
                                </a>
                            </form>
                          </div>    
                    </div>
                </div>

            </div>
        </section>


    </main>
</div>
<style>
    /* Main Section Container */
    
</style>

<script>

</script>


@include('partials.footer')
@if(session('course_save'))
<script>
  notify("Success", "{{ session('course_save') }}", "success");
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