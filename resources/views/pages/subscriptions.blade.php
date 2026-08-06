<x-base>

<div class="max-w-6xl mx-auto px-6 py-10">

    {{-- Header --}}
    <div class="text-center mb-12">

        <h1 class="text-4xl font-bold">
            Subscription Plans
        </h1>

        <p class="text-base-content/60 mt-3">
            Upgrade your account to unlock more features and earn higher tiers.
        </p>

    </div>


    {{-- Current Subscription --}}
    <div class="card bg-base-100 shadow-xl border border-primary/20 mb-10">

        <div class="card-body">

            <h2 class="card-title">
                Your Subscription
            </h2>

            <div class="grid md:grid-cols-2 gap-6 mt-4">

                <div>

                    <p class="text-sm text-base-content/60">
                        Current Plan
                    </p>

                    <div class="badge badge-primary badge-lg mt-2">
                        {{ ucfirst(auth()->user()->subscription) }}
                    </div>

                </div>

                <div>

                    <p class="text-sm text-base-content/60">
                        Current Tier
                    </p>

                    <div class="badge badge-warning badge-lg mt-2">
                        {{ ucfirst(auth()->user()->tier) }}
                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- Subscription Plans --}}
    <div class="grid md:grid-cols-4 gap-6">

        {{-- Free --}}
        <div class="card bg-base-100 shadow-md">

            <div class="card-body">

                <h2 class="card-title">
                    Free
                </h2>

                <div class="text-3xl font-bold">
                    $0
                </div>

                <ul class="mt-4 space-y-2 text-sm">

                    <li>✓ Create surveys</li>
                    <li>✓ View responses</li>
                    <li>✓ Community access</li>

                </ul>

                <div class="card-actions mt-6">

                    @if(auth()->user()->subscription == 'free')
                    <button
                        class="btn btn-outline w-full"
                        disabled>
                        Current Plan
                    </button>


                    @else
                        <button disabled></button>
                    @endif


                </div>

            </div>

        </div>



        {{-- Plus --}}
        <div class="card bg-base-100 shadow-md border border-info">

            <div class="card-body">

                <h2 class="card-title">
                    Plus
                </h2>

                <div class="text-3xl font-bold">
                    $9<span class="text-base font-normal">/week</span>
                </div>

                <ul class="mt-4 space-y-2 text-sm">

                    <li>✓ Everything in Free</li>
                    <li>✓ Advanced analytics</li>
                    <li>✓ Custom branding</li>

                </ul>

                <div class="card-actions mt-6">

                    @switch(auth()->user()->subscription)
                        @case('free')
                            <button class="btn btn-info w-full">
                                Upgrade
                            </button>
                            @break
                        @case('plus')
                        <div>
                        <button
                            class="btn btn-outline w-full"
                            >
                            Renew
                        </button>
                        <p class="text-[12px] text-accent mt-2">Expiration: {{ auth()->user()->subscription_expiration->format('M j, Y \a\t g:i A') }}</p>
                        </div>
                        @break

                        @default


                    @endswitch



                </div>

            </div>

        </div>



        {{-- Pro --}}
        <div class="card bg-primary text-primary-content shadow-xl scale-105">

            <div class="card-body">

                <div class="badge badge-secondary self-start">
                    MOST POPULAR
                </div>

                <h2 class="card-title mt-2">
                    Pro
                </h2>

                <div class="text-3xl font-bold">
                    $19<span class="text-base font-normal">/week</span>
                </div>

                <ul class="mt-4 space-y-2 text-sm">

                    <li>✓ Everything in Plus</li>
                    <li>✓ AI insights</li>
                    <li>✓ Unlimited surveys</li>
                    <li>✓ Priority support</li>

                </ul>

                <div class="card-actions mt-6">

                    @switch(auth()->user()->subscription)
                        @case('free')
                            <button class="btn btn-info w-full">
                                Upgrade
                            </button>
                            @break
                        @case('plus')
                            <button class="btn btn-info w-full">
                                Upgrade
                            </button>
                            @break
                        @case('pro')
                        <div>
                        <button
                            class="btn btn-outline w-full"
                            >
                            Renew
                        </button>
                        <p class="text-[12px] text-accent mt-2">Expiration: {{ auth()->user()->subscription_expiration->format('M j, Y \a\t g:i A') }}</p>
                        </div>
                        @break

                        @default


                    @endswitch

                </div>

            </div>

        </div>



        {{-- Ultra --}}
        <div class="card bg-base-100 shadow-md border border-secondary">

            <div class="card-body">

                <h2 class="card-title">
                    Ultra
                </h2>

                <div class="text-3xl font-bold">
                    $49<span class="text-base font-normal">/week</span>
                </div>

                <ul class="mt-4 space-y-2 text-sm">

                    <li>✓ Everything in Pro</li>
                    <li>✓ Dedicated support</li>
                    <li>✓ Enterprise analytics</li>
                    <li>✓ API access</li>

                </ul>

                <div class="card-actions mt-6">

                    @switch(auth()->user()->subscription)
                        @case('free')
                            <button class="btn btn-info w-full">
                                Upgrade
                            </button>
                            @break
                        @case('plus')
                            <button class="btn btn-info w-full">
                                Upgrade
                            </button>
                            @break
                        @case('pro')
                            <button class="btn btn-info w-full">
                                Upgrade
                            </button>
                            @break
                        @case('ultra')
                        <div>
                        <button
                            class="btn btn-outline w-full"
                            >
                            Renew
                        </button>
                        <p class="text-[12px] text-accent mt-2">Expiration: {{ auth()->user()->subscription_expiration->format('M j, Y \a\t g:i A') }}</p>
                        </div>
                        @break

                        @default

                    @endswitch

                </div>

            </div>

        </div>

    </div>



    {{-- Tier Progress --}}
    <div class="card bg-base-100 shadow-xl mt-12">

        <div class="card-body">

            <h2 class="card-title">
                Tier Progression
            </h2>

            <ul class="steps steps-vertical md:steps-horizontal w-full mt-6">

                <li class="step {{ in_array(auth()->user()->tier, ['bronze','silver','gold','platinum','diamond']) ? 'step-primary' : '' }}">
                    Bronze
                </li>

                <li class="step {{ in_array(auth()->user()->tier, ['silver','gold','platinum','diamond']) ? 'step-primary' : '' }}">
                    Silver
                </li>

                <li class="step {{ in_array(auth()->user()->tier, ['gold','platinum','diamond']) ? 'step-primary' : '' }}">
                    Gold
                </li>

                <li class="step {{ in_array(auth()->user()->tier, ['platinum','diamond']) ? 'step-primary' : '' }}">
                    Platinum
                </li>

                <li class="step {{ auth()->user()->tier == 'diamond' ? 'step-primary' : '' }}">
                    Diamond
                </li>

            </ul>

        </div>

    </div>

</div>

</x-base>
