@include('partials.header', ['title' => 'Login'])
<x-messages />
<main>
    <section>
        <header>
            Login
        </header>
        <form action="/login/process" method="POST">
            @csrf
            @if($errors->has('login'))
                <div class="text-red-600" role="alert">
                    {{ $errors->first('login') }}
                </div>
            @endif
            <div>
                <label for="">Email</label>
                <input type="email" name="email" id="" class="border-solid border-2">
            </div>
            <div>
                <label for="">Password</label>
                <input type="password" name="password" id="" class="border-solid border-2">
            </div>
            <div>
                <button type="submit" class="bg-gray-200 px-4 rounded">Submit</button>
            </div>
        </form>
    </section>
</main>

@include('partials.footer')