@include('partials.header', ['title' => 'Register'])

<main>
    <section>
        <header>
            Register
        </header>
        <form action="{{ route('process_register') }}" method="POST">
            @csrf
            <div>
                <label for="">Firstname</label>
                <input type="text" name="firstname" id="" class="border-solid border-2">
            </div>
            <div>
                <label for="">Middlename</label>
                <input type="text" name="middlename" id="" class="border-solid border-2">
            </div>
            <div>
                <label for="">Lastname</label>
                <input type="text" name="lastname" id="" class="border-solid border-2">
            </div>
            <div>
                <label for="">Email</label>
                <input type="email" name="email" id="" class="border-solid border-2">
            </div>
            <div>
                <label for="">Password</label>
                <input type="password" name="password" id="" class="border-solid border-2">
            </div>
            <div>
                <label for="">Confirm Password</label>
                <input type="password" name="password_confirmation" id="" class="border-solid border-2">
            </div>
            <div>
                <label for="">You are:</label>
                <input type="radio" name="type" id="" value="2">
                <label for="">Student</label>
                <input type="radio" name="type" id="" value="1">
                <label for="">Teacher</label>
            </div>
            <div>
                <button type="submit" class="bg-gray-200 px-4 rounded">Submit</button>
            </div>
        </form>
    </section>
</main>

@include('partials.footer')