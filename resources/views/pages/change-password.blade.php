<x-base>
    <div class="hero bg-base-200 min-h-screen">
    <div class="hero-content flex-col lg:flex-row-reverse gap-[10vw] w-full">

        <div class="card bg-base-100 w-full max-w-[500px] shrink-0 shadow-2xl">
        <div class="flex flex-col items-center justify-center mt-8">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-15">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>

            <p class="mt-3 text-[14px] text-gray-600/60">Email: {{ auth()->user()->email }}</p>
        </div>
        <div class="card-body">
            <form action="{{ route('profile.update.password') }}" method="POST" class="fieldset gapy-[1vw]">
                @csrf
                @method('put')
            <label for="password" class="label">Old Password</label>
            <input name="password" required type="password" class="input w-full" placeholder="Old Password" />
            <label for="new_password" class="label">New Password</label>
            <input name="new_password" required type="password" class="input w-full" placeholder="new password" />
            <label for="confirm_new_password" class="label">Confirm New Password</label>
            <input name="confirm_new_password" required type="password" class="input w-full" placeholder="confirm password" />
            <button class="btn btn-neutral mt-4">Confirm</button>
            </form>

            @include('components.errortext')
        </div>
        </div>
    </div>
    </div>
</x-base>
