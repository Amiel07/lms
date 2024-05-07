@include('partials.header', ['title' => 'Dashboard'])
<div class="main-container">
    @if (auth()->user()->type === 1)
    @include('partials.sidebar', ['active' => 'account'])
    @endif
    <main class="main home w-full">
        @include('partials.navbar', ['page_title' => 'THRIVE'])
        <section class="flex flex-col p-4 w-full h-auto h-full">
            <div class="card-scroll-container">
                
            </div>
            <div class="dashboard-bottom-container flex flex-row gap-4">
                <div class="bg-white h-auto p-4 w-full rounded-md shadow-lg">
                    <div class="w-full h-auto flex justify-between gap-2">
                        <span class="text-xl">
                            User Account
                        </span>
                        
                    </div>
                    <hr class="my-2">
                    <div class="">
                        <form action="{{route('updatename')}}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-4 max-w-[264px] mb-4">
                            <div class="flex flex-col ">
                                <label for="" class="text-gray-500">First Name</label>
                                <input type="text" class="infoInput rounded-sm py-1 px-2" id="firstname" name="firstname" value="{{$user->firstname}}" disabled></input>
                            </div>
                            
                            <div class="flex flex-col">
                                <label for="" class="text-gray-500">Middle Name</label>
                                <input type="text" class="infoInput rounded-sm py-1 px-2" id="middlename" name="middlename" value="{{$user->middlename}}" disabled></input>
                            </div>

                            <div class="flex flex-col">
                                <label for="" class="text-gray-500">Last Name</label>
                                <input type="text" class="infoInput rounded-sm py-1 px-2" id="lastname" name="lastname" value="{{$user->lastname}}" disabled></input>
                            </div>
                            
                        </div>
                        <button type="button" class="editbtn rounded-sm py-1 px-2 bg-[var(--custom-orange)] text-white" onclick="editClick(this)">Edit</button>
                        <button type="submit" id="submitBtn" class="hidden rounded-sm py-1 px-2 bg-[var(--custom-darkblue)] text-white">Submit</button>
                        </form>
                        <hr class="mt-10 mb-2">
                        <form action="{{route('updatepassword')}}" method="POST">
                            @csrf
                        <div class="flex flex-col max-w-[264px] gap-4 mb-4">
                            <div class="w-full h-auto flex justify-between gap-2">
                                <span class="text-xl">
                                    Security
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <label for="" class="text-gray-500">Old Password</label>
                                <input type="password" class="border-[1px] border-gray-400 rounded-sm py-1 px-2" name="oldpassword" value=""></input>
                            </div>
                            <div class="flex flex-col">
                                <label for="" class="text-gray-500">New Password</label>
                                <input type="password" class="border-[1px] border-gray-400 rounded-sm py-1 px-2" name="newpassword" value=""></input>
                            </div>
                            <div class="flex flex-col">
                                <label for="" class="text-gray-500">Confirm New Password</label>
                                <input type="password" class="border-[1px] border-gray-400 rounded-sm py-1 px-2" name="newpassword_confirmation" value=""></input>
                            </div>
                        </div>
                        <button type="submit" class="editbtn rounded-sm py-1 px-2 bg-[var(--custom-darkblue)] text-white">Submit</button>
                        </form>
                        
                    </div>
                </div>
                
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

    .editing{
        border: 1px solid gray;
    }
</style>
<script>
    function editClick(editBtn) {
        var inputs = document.querySelectorAll('.infoInput');
        if (editBtn.innerHTML === "Cancel") {
            editBtn.innerHTML = "Edit";
            inputs.forEach(function(element) {
                element.disabled = true;
            });
        } else {
            editBtn.innerHTML = "Cancel";
            inputs.forEach(function(element) {
                element.disabled = false;
            });
        }
        inputs.forEach(element => {
            element.classList.toggle('editing');
        });
        document.getElementById('submitBtn').classList.toggle('hidden');
    }
</script>

@include('partials.footer')

@if(session('login'))
<script>
  alertif("{{ session('login') }}");
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