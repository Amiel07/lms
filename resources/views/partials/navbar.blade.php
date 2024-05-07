<nav x-data="{ open: false }" class="nav">
  <div class=" w-full flex flex-wrap justify-between items-center">
    @if (auth()->user()->type == 2)
    <a href="{{route('student.home')}}">
        <span class="self-center text-xl font-semibold whitespace-nowrap px-4 flex items-center">
            <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="Your Company">
            <span class="self-center text-xl font-semibold whitespace-nowrap px-4">
            {{ $page_title }}
            </span>
        </span>
    </a>
    @endif
    @if (auth()->user()->type == 1)
    <a href="{{route('teacher.home')}}">
        <span class="self-center text-xl font-semibold whitespace-nowrap px-4 flex items-center">
            <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="Your Company">
            <span class="text-xl font-extrabold ml-2">THRIVE</span>
        </span>
    </a>
    @endif
    <button @click="open = !open" class="md:hidden">
        <svg class="fill-white" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
    </button>
    {{-- <div x-show="open" class="w-full md:block md:w-auto" id="navbar">
        <ul class="flex flex-col md:flex-row px-4">
            <li>
                <form action="/logout" method="POST" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="block py-2 pr-4 pl-3">Logout</button>
                </form>
            </li>
        </ul>
    </div> --}}
    @if (auth()->user()->type == 2)
    <div class="w-full md:block md:w-auto" id="navbar">
        <ul class="flex flex-col md:flex-row">
            <li>
                <a href="{{ route('student.enroll', ['']) }}" method="POST" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="block py-1 px-6 bg-[var(--custom-darkblue)] rounded-md text-white hover:bg-[var(--custom-orange)]">Enroll</button>
                </a>
            </li>
            <li>
                <form action="/logout" method="POST" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="block py-1 px-4">Logout</button>
                </form>
            </li>
        </ul>
    </div>
    @endif
  </div>
</nav>