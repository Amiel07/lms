@php
$sidebarState = $_COOKIE['sidebarState'] ?? 'notset';

if ($sidebarState === 'close') {
    echo "<aside class='aside sidebar close'>";
} else {
    echo "<aside class='aside sidebar'>";
}
@endphp

{{-- <aside class="aside sidebar"> --}}
    <header>
        <div class="image-text">
            <span class="image">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z"/></svg>
            </span>
            <div class="text header-text">
                <span class="name">{{ auth()->user()->firstname . " " . auth()->user()->lastname }}</span>
                <span class="profession">{{ auth()->user()->email }}</span>
            </div>
        </div>
        <i class="bx bx-chevron-right toggle"></i>
    </header>

    <div class="menu-bar">
        <div class="menu">
            <ul class="menu-links">
                <li class="nav-link">
                    <a href="{{ route('teacher.home',['']) }}"
                    @if ($active == "dashboard")
                        class="active"
                    @endif
                    >
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="{{ route('teacher.courses.all') }}"
                    @if ($active == "courses")
                        class="active"
                    @endif
                    >
                        <i class='bx bx-book-open icon'></i>
                        <span class="text nav-text">Courses</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="{{ route('teacher.certifications.courses') }}"
                    @if ($active == "certifications")
                        class="active"
                    @endif
                    >
                        <i class='bx bx-award icon' ></i>
                        <span class="text nav-text">Certifications</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="{{ route('account') }}"
                    @if ($active == "account")
                        class="active"
                    @endif
                    class="flex items-center"
                    >
                        <i class='bx bxs-user-account icon'></i>
                        <span class="text nav-text"><button type="submit" class="w-auto h-full">Account</button></span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="bottom-content">
            <li class="nav-link">
                <form action="/logout" method="POST">
                    @csrf
                    {{-- <a type="submit" class="logout"> --}}
                        
                        <button type="submit" class=" logout">
                            <i class='bx bx-log-out icon' ></i>
                            <span class="text">
                                Logout
                            </span>
                        </button>
                    {{-- </a> --}}
                </form>
            </li>
        </div>
    </div>
</aside>

<script>
const body = document.querySelector("body"),
sidebar = body.querySelector(".sidebar"),
toggle = body.querySelector(".toggle");



toggle.addEventListener("click", () =>{
    console.log("here");
    sidebar.classList.toggle("close");
    var sidebarState = sidebar.classList.contains('close') ? 'close' : 'visible';
    document.cookie = 'sidebarState=' + encodeURIComponent(sidebarState) + '; path=/';
});
</script>