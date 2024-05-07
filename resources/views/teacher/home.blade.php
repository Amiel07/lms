@include('partials.header', ['title' => 'Dashboard'])
<div class="main-container">
    @include('partials.sidebar', ['active' => 'dashboard'])
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => 'Dashboard'])
        <section class="flex flex-col p-4 w-full h-auto h-full">
            <div class="card-scroll-container">
                <div class="flex flex-col m-auto p-auto">
                          <div class="flex overflow-x-scroll pb-4 hide-scroll-bar">
                            <div class="flex flex-nowrap">
                                @foreach ($courses as $course)
                                @if ($course->hidden)
                                    @continue
                                @endif
                                @php
                                    $enrollees = $enrollments->where('course_id', $course->id);
                                @endphp
                                <div class="inline-block px-3">
                                    <a href="{{ route('teacher.courses.course',['course' => $course->id]) }}"
                                        class="flex flex-col cursor-pointer min-w-64 max-w-64 min-h-50 max-h-50 px-6 py-10 overflow-hidden bg-white hover:bg-gradient-to-br hover:from-purple-400 hover:via-blue-400 hover:to-blue-500 rounded-xl shadow-lg duration-300 hover:shadow-2xl group">
                                        <div class="flex flex-row justify-between items-center gap-2">
                                            <div class="px-4 py-4 bg-gray-300 rounded-xl bg-opacity-30 text-nowrap">
                                                <span class="">{{ $course->course_code }}</span>
                                            </div>
                                            <div class="inline-flex text-sm text-gray-600 group-hover:text-gray-200 sm:text-base">
                                                <span class="w-24 overflow-hidden text-ellipsis">{{ $course->name }}</span>
                                            </div>
                                        </div>
                                        <h1 class="text-3xl sm:text-4xl xl:text-5xl font-bold text-gray-700 mt-6 group-hover:text-gray-50">{{ $enrollees->count() }}</h1>
                                        <div class="flex flex-row justify-between group-hover:text-gray-200">
                                            <p>Enrolled</p>
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 group-hover:text-gray-200"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                    clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </div>
                                    </a>
                                </div>

                                @endforeach
                                {{-- <div class="inline-block px-3">
                                <div class="w-64 h-40 max-w-xs overflow-hidden rounded-lg shadow-md bg-white hover:shadow-xl transition-shadow duration-300 ease-in-out"></div>
                                </div> --}}
                              
                              
                            </div>
                          </div>
                    </div>
            </div>
            <hr class="my-2">
            <div class="dashboard-bottom-container flex flex-row gap-4">
                <div class="bg-white h-auto p-4 w-full rounded-md shadow-lg">
                    <div class="w-full h-auto">
                        <span class="text-xl">
                            Notifications
                        </span>
                    </div>
                    <hr class="py-2">
                    <div class="flex flex-col gap-1 max-h-80 overflow-y-scroll">
                        @foreach ($notifications as $index => $notification)
                        @if ($index != 0)
                        <hr>
                        @endif
                        <div class="py-2 px-4 text-gray-500 rounded-md">
                            {{ $notification->data['message'] }}
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="w-full md:w-1/3 lg:1/3">
                    <div class="bg-white p-4 rounded-md shadow-lg">

                        <ul class="flex flex-col gap-4">
                            <li>
                                <a href="{{ route('teacher.courses.all',['']) }}">
                                    <button  class="flex flex-row items-center hover:text-[var(--custom-orange)]">
                                        <i class='bx bx-book-bookmark menu-button-icon' ></i>
                                        <span class="hidden lg:block">&nbsp;All Courses</span>
                                    </button>
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="flex p-4 flex-wrap bg-white rounded-md shadow-xl gap-4 mt-4">
                <a href="https://dione.batstate-u.edu.ph/portal/faculty/#/auth" target="_blank">
                  <div class="flex p-2 rounded-md border-[2px] border-red-300 w-[164px] h-[164px] hover:scale-[1.05] hover:bg-gray-200 items-center justify-center">
                    <h4 class="text-bold text-center text-red-400">Instructor Portal</h4>
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
              </div>
        </section>
    </main>
</div>
<style>
    .hide-scroll-bar {
      -ms-overflow-style: none;
      scrollbar-width: thin;
    }
    .hide-scroll-bar::-webkit-scrollbar {
      display: block;
    }
</style>


@include('partials.footer')

@if(session('login'))
<script>
  alertif("{{ session('login') }}");
</script>
@endif