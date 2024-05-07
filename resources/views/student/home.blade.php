@include('partials.header', ['title' => 'Courses'])
@php
    $fullname = auth()->user()->lastname . ', ' . auth()->user()->firstname . ' ' . auth()->user()->middlename;
@endphp
<div class="main-container">
    {{-- @include('partials.sidebar', ['active' => 'courses']) --}}
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => 'THRIVE'])

        
        {{-- Main Section Container --}}
        <section class="courses-main-section p-4 flex flex-col gap-4 min-h-[90vh]">
          <div class="bg-white breadcrumbs-student w-full h-aut py-2 px-4 rounded-md shadow-lg">
            <a href="{{route('student.home')}}" class="">Home </a>
          </div>
          <div class="flex gap-4">
          <div class="section-content w-[350px] min-w-[350px] h-full ">
            <div class="flex flex-col gap-4 h-full ">
              <div class="bg-white h-full flex flex-row flex-wrap gap-4 p-4 rounded-md shadow-lg">
                <div class="flex items-center justify-center w-full">
                  <span class="flex justify-center items-center text-6xl rounded-full w-[164px] aspect-square font-bold text-white name-color-{{ auth()->user()->firstname[0] }}">
                    <h1>{{ auth()->user()->firstname[0] }}</h1>
                  </span>
                </div>
                <div class="flex items-center">
                  <div class="flex flex-col h-auto">
                    <span class="font-bold text-xl">{{ $fullname }}</span>
                    @if ($courses->isEmpty())
                    <span class="text-red-400 font-bold"> NOT ENROLLED </span>
                    @else
                    <span class="text-green-300 font-bold"> ENROLLED </span>
                    @endif
                    
                    {{-- <span class="font-bold text-sm text-gray-400">POINTS: 0</span> --}}
                    <span class="font-bold text-sm text-gray-400">CERTIFICATES: {{ $certificates->count() }}</span>
                  </div>
                </div>
              </div>
              <div class="bg-white h-full flex flex-row flex-wrap gap-4 p-4 rounded-md shadow-lg">
                <div class="relative flex flex-col text-gray-700 w-96 rounded-xl bg-clip-border">
                  <ul class="w-full">
                    <li class="w-full">
                      <a href="{{ route('account') }}" class="">
                        <button type="submit" class="hover:bg-blue-100 w-full text-start py-4 px-2 rounded-md">
                        Account
                        <button>
                      </a>
                    </li>
                    {{-- <hr class="my-2">
                    <li class="w-full">
                      <a href="#" class="">
                        <button class="hover:bg-blue-100 w-full text-start py-4 px-2 rounded-md">
                        Certificates
                        <button>
                      </a>
                    </li> --}}
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="section-content bg-white w-full h-auto rounded-md pt-8 pb-4 px-5 shadow-lg">
                <div class="w-full h-auto mb-2">
                    <span class="text-xl">
                        Continue Learning...
                    </span>
                </div>
                <hr class="py-4 ">
                {{-- If there is no courses --}}
                @if ($courses->isEmpty())
                <div class="flex flex-col w-full h-full justify-center items-center">
                  <div class="">
                    <i class='bx bx-book-reader text-9xl text-[var(--custom-darkblue)]'></i>

                  </div>
                  <div class="my-4">
                    <span>Oops, you are not enrolled in a class yet.</span>
                  </div>
                  <div class="">
                    <a href="{{ route('student.enroll', ['']) }}">
                      <button class="bg-[var(--custom-darkblue)] rounded-md py-2 px-8 text-[var(--custom-white)] hover:bg-[var(--custom-orange)] hover:text-white">Enroll</button>
                    </a>
                  </div>
                </div>
                @endif
                <div class="flex flex-row flex-wrap gap-4">
                  @foreach($courses as $course)
                  <div class="max-w-sm min-w-[300px] bg-white border border-gray-200 rounded-lg shadow">
                    {{-- Course Code --}}
                    <div class="flex items-center py-4 px-4 bg-[var(--custom-darkblue)] text-[var(--custom-white)] rounded-t-lg">
                        <span class="text-3xl font-bold">{{ $course->course_code }}</span>
                    </div>
                    <div class="p-5" >
                   
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-justify text-gray-900">{{ $course->name }}</h5>
                        <span class="block">
                        <a href="{{ $course->meeting_link }}" target="_blank" class="font-bold text-sm text-[var(--custom-orange)]">Open Meeting <i class='bx bx-link-external'></i></a>
                        </span>

                        {{-- <p class="mb-3 font-normal text-sm max-h-[60px] text-wrap truncate text-gray-700">{{ $course->description }}</p> --}}
  
                        <a href="{{ route('student.show_course', ['course'=> $course->id]) }}" class="inline-flex mt-4 items-center px-3 py-2 text-sm font-medium text-center text-[var(--custom-darkblue)] bg-[var(--custom-lightblue)] rounded-lg hover:bg-[var(--custom-orange)] focus:ring-4 focus:outline-none focus:ring-blue-300">
                            Continue
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                        <a href="{{ route('student.show_certificate', ['course'=> $course->id]) }}" target="_blank" class="inline-flex mt-4 items-center px-3 py-2 text-sm font-medium text-center text-[var(--custom-darkblue)] border-2 border-[var(--custom-lightblue)] rounded-lg hover:text-[var(--custom-orange)] hover:border-[var(--custom-orange)] focus:ring-4 focus:outline-none focus:ring-blue-300">
                          Certificate
                          &nbsp;
                          <i class='bx bx-award' ></i>
                        </a>
                    </div>
                  </div>
                  @endforeach
                </div>
                
                
            </div>
          </div>
          <div class="flex p-4 flex-wrap bg-white rounded-md shadow-xl gap-4">
            <a href="https://dione.batstate-u.edu.ph/student/#/" target="_blank">
              <div class="flex p-2 rounded-md border-[2px] border-red-300 w-[164px] h-[164px] hover:scale-[1.05] hover:bg-gray-200 items-center justify-center">
                <h4 class="text-bold text-center text-red-400">Student Portal</h4>
              </div>
            </a>
            <a href="https://sites.google.com/g.batstate-u.edu.ph/ctcs2021" target="_blank">
              <div class="flex p-2 rounded-md border-[2px] border-red-300 w-[164px] h-[164px] hover:scale-[1.05] hover:bg-gray-200 items-center justify-center">
                <h4 class="text-bold text-center text-red-400">CTCS 2021</h4>
              </div>
            </a>
            <a href="https://batstateu.edu.ph/" target="_blank">
              <div class="flex p-2 rounded-md border-[2px] border-red-300 w-[164px] h-[164px] hover:scale-[1.05] hover:bg-gray-200 items-center justify-center">
                <h4 class="text-bold text-center text-red-400">BatStateU Website</h4>
              </div>
            </a>
            <a href="https://dione.batstate-u.edu.ph/enrollment/#/auth/student" target="_blank">
              <div class="flex p-2 rounded-md border-[2px] border-red-300 w-[164px] h-[164px] hover:scale-[1.05] hover:bg-gray-200 items-center justify-center">
                <h4 class="text-bold text-center text-red-400">Registration Portal</h4>
              </div>
            </a>
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