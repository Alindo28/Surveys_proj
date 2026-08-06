<x-base>

<div class="max-w-5xl mx-auto px-6 py-10">

    <div class="mb-8">
        <h1 class="text-4xl font-bold">
            My Profile
        </h1>

        <p class="text-base-content/60 mt-2">
            Manage your account information and settings.
        </p>
    </div>


    <div class="grid lg:grid-cols-3 gap-8">

{{-- Profile Card --}}
<div class="card bg-base-100 shadow-xl">

    <div class="card-body items-center text-center">

        <div class="avatar">
            <div class="w-28 rounded-full bg-primary text-primary-content flex items-center justify-center text-4xl font-bold">
                {{ strtoupper(substr(auth()->user()->full_name,0,1)) }}
            </div>
        </div>

        <div class="flex items-center">
        <div class="mb-6 flex flex-col items-start ml-[px]">
            <h2 class="text-2xl font-bold mt-4">
                {{ auth()->user()->full_name }}
            </h2>

            <p class="text-base-content/60">
                {{ auth()->user()->email }}
            </p>
        </div>

        <a href="" class="pl-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
        </svg>
        </a>
        </div>



        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn bg-purple-600 text-white hover:bg-purple-600/70">Log-out</button>
        </form>

        <div class="divider my-5"></div>

<div class="w-full space-y-3">

    <div class="flex justify-between items-center">
        <span class="text-base-content/60">
            Subscription
        </span>

        <span class="badge
            @switch(auth()->user()->subscription)
                @case('free') badge-neutral @break
                @case('plus') badge-info @break
                @case('pro') badge-primary @break
                @case('ultra') badge-secondary @break
            @endswitch
        ">
            {{ ucfirst(auth()->user()->subscription) }}
        </span>
    </div>

    <div class="flex justify-between items-center">
        <span class="text-base-content/60">
            Tier
        </span>

        <span class="badge
            @switch(auth()->user()->tier)
                @case('bronze') badge-neutral @break
                @case('silver') badge-ghost @break
                @case('gold') badge-warning @break
                @case('platinum') badge-info @break
                @case('diamond') badge-primary @break
            @endswitch
        ">
            {{ ucfirst(auth()->user()->tier) }}
        </span>
    </div>

</div>

        <div class="mt-6 w-full">

            <a href="{{ route('profile.subsciptions.show') }}"><button class="btn btn-primary w-full">
                Manage Subscription
            </button></a>

        </div>

    </div>

</div>



        <div class="lg:col-span-2 space-y-6">

            {{-- Personal Information --}}
            <div class="card bg-base-100 shadow">

                <div class="card-body">

                    <h2 class="card-title">
                        Personal Information
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6 mt-4">

                        <div>
                            <p class="text-sm text-base-content/60">
                                Name
                            </p>

                            <p class="font-medium">
                                {{ auth()->user()->full_name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-base-content/60">
                                Email
                            </p>

                            <p class="font-medium">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-base-content/60">
                                Joined
                            </p>

                            <p class="font-medium">
                                {{ auth()->user()->created_at->format('F d, Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-base-content/60">
                                Account ID
                            </p>

                            <p class="font-medium">
                                #{{ auth()->user()->id }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Security --}}
            <div class="card bg-base-100 shadow">

                <div class="card-body">

                    <h2 class="card-title">
                        Security
                    </h2>

                    <div class="flex justify-between items-center mt-3">

                        <div>
                            <h3 class="font-semibold">
                                Password
                            </h3>

                            <p class="text-sm text-base-content/60">
                                Keep your account secure with a strong password.
                            </p>
                        </div>

                        <a href="{{ route('profile.update.password.show') }}"><button class="btn btn-outline">
                            Change Password
                        </button></a>

                    </div>

                </div>

            </div>


            {{-- Preferences --}}
            <div class="card bg-base-100 shadow">

                <div class="card-body">

                    <h2 class="card-title">
                        Preferences
                    </h2>

                    <div class="form-control">

                        <label class="label cursor-pointer">

                            <span class="label-text">
                                Email notifications
                            </span>

                            <input type="checkbox" class="toggle toggle-primary">

                        </label>

                    </div>

                </div>

            </div>


            {{-- Danger Zone --}}
            <div class="card bg-error/10 border border-error/20">

                <div class="card-body">

                    <h2 class="card-title text-error">
                        Danger Zone
                    </h2>

                    <p class="text-sm">
                        Permanently delete your account and all associated data.
                    </p>

                    <div class="card-actions justify-end mt-4">
                        <form action="{{ route('profile.delete') }}" method="post">
                            @method('delete')
                            @csrf
                        <button class="btn btn-error">
                            Delete Account
                        </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</x-base>
