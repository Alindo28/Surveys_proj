<x-base>
    <div class="hero bg-base-200 min-h-screen mt-[-5vh]">
    <div class="hero-content flex-col lg:flex-row-reverse gap-[10vw]">
        <div class="text-center lg:text-left">
        <h1 class="text-5xl font-bold">Register now!</h1>
        <p class="py-6">
            Survey.Survey.Survey.Survey.Survey.Survey.Survey.Survey.Survey
        </p>
        </div>
        <div class="card bg-base-100 w-full max-w-[500px] min-h-[30vw] shrink-0 shadow-2xl">
        <div class="flex items-center justify-center mt-8">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-15">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </div>
        <div class="card-body">
            <form action="{{ route('action.register') }}" method="POST" class="fieldset gapy-[1vw]">
            <label for="full_name" class="label">Full Name</label>
            <input required name="full_name" type="text" class="input w-full" value="{{ old('full_name') }}" placeholder="Full Name" />
            <label for="email" class="label">Email</label>
            <input required name="email" type="email" class="input w-full" value="{{ old('email') }}" placeholder="Email" />
            <label for="password" class="label">Password</label>
            <input required name="password" type="password" class="input w-full" placeholder="Password" />
            <label for="password_confirmation" class="label">Confirm Password</label>
            <input required name="password_confirmation" type="password" class="input w-full" placeholder="Password" />
            <button class="btn btn-neutral mt-4">Register</button>
            </form>

            <div class="mt-3">
                Already have an account? <span class="text-blue-600/70"><a href="{{ route('show.login') }}">Log-in</a></span>
            </div>
        </div>
        </div>
    </div>
    </div>
</x-base>

