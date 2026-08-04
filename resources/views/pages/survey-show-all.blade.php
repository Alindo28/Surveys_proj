@props(['contexts' => collect()])

<x-base>

<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-6">

        <div>
            <h1 class="text-4xl font-bold">
                Available Surveys
            </h1>

            <p class="text-base-content/60 mt-2">
                Browse surveys grouped by context.
            </p>
        </div>

        <a href="{{ route('survey.create.context.show') }}"
           class="btn btn-primary">
            + Create Survey
        </a>

    </div>


    <form method="GET" action="{{ route('survey.home') }}" class="mb-6">

        <label class="input">
        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g
            stroke-linejoin="round"
            stroke-linecap="round"
            stroke-width="2.5"
            fill="none"
            stroke="currentColor"
            >
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
            </g>
        </svg>
        <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search surveys..."
                class="input input-bordered w-full"
            >
        </label>

        <select
            name="sort"
            onchange="this.form.submit()"
            class="select select-bordered select-sm max-w-25"
        >
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                Newest
            </option>

            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                Oldest
            </option>

            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                Name
            </option>

        </select>
    </form>


    @if($contexts->count())

        {{-- Context Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">


            @foreach($contexts as $context)

                <div class="card bg-base-100 shadow-lg hover:shadow-xl transition duration-300">


                    <div class="card-body">


                        {{-- Context Title --}}
                        <div>

                            <h2 class="text-2xl font-bold">
                                {{ $context->title }}
                            </h2>

                            <p class="text-sm text-base-content/60 mt-2 line-clamp-3">
                                {{ $context->preview }}
                            </p>

                            <div class="flex justify-between my-3">

                                {{-- Show first few tags --}}
                                @php
                                    $tags = $context->tags;
                                @endphp

                                <div class="flex flex-wrap gap-1 justify-start">

                                    @foreach($tags->take(3) as $tag)

                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-base-200 text-xs text-base-content/60">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-3 h-3"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M7 7h.01M3 3h7l11 11-7 7L3 10V3z"/>
                                            </svg>

                                            {{ Str::limit($tag->name, 12) }}

                                        </span>

                                    @endforeach


                                    @if($tags->count() > 3)

                                        <button class="text-xs text-base-content/50 hover:text-base-content">
                                            +{{ $tags->count() - 3 }} more
                                        </button>

                                    @endif

                                </div>

                                <a href="{{ route('context.show', ['id' => $context->id]) }}"><button class="btn whitespace-nowrap btn-info bg-gray-300/30">Read Context ></button></a>
                            </div>

                        </div>



                        {{-- Context Preview --}}
                        <div class="bg-base-200 rounded-xl p-4">

                            <div class="flex justify-between items-center">

                                <span class="text-sm font-medium">
                                    Available Surveys:
                                </span>

                                <span class="badge badge-primary w-7 h-7 rounded-full bg-gray-500/60 text-gray-100 border-none">
                                    {{ $context->surveys
                                        ->whereNotIn('status',['draft','archived'])
                                        ->count()
                                    }}
                                </span>

                            </div>


                            <p class="text-xs text-base-content/60 mt-2">
                                Explore surveys related to this category.
                            </p>

                        </div>



                        {{-- Surveys Preview --}}
                        <div class="mt-5 space-y-3">


                            @forelse(
                                $context->surveys
                                ->whereNotIn('status',['draft','archived'])
                                ->take(3)
                                as $survey
                            )


                                <div class="flex items-center justify-between
                                            bg-base-200 rounded-lg px-3 py-2">


                                    <div class="flex flex-col gap-y-1">
                                    <span class="font-medium text-sm truncate">
                                        {{ $survey->title }}
                                    </span>
                                    <span class="text-[10px]">Total questions: {{ $survey->questions->count() }}</span>
                                    <span class="text-[10px]">Estimated time: {{ $survey->responses->count() > 0 ? gmdate('H:i:s', round($survey->responses->sum('duration') / $survey->responses->count(), 2))  : 'not available'}}</span>
                                    </div>


                                    <a href="{{ route('survey.view',['id'=>$survey->id]) }}"
                                       class="btn btn-xs btn-primary">

                                        View

                                    </a>


                                </div>


                            @empty

                                <p class="text-sm text-base-content/50">
                                    No active surveys.
                                </p>

                            @endforelse


                        </div>



                        {{-- Footer --}}
                        @if($context->surveys->whereNotIn('status',['draft','archived'])->count() > 3)

                            <div class="mt-4">

                                <a href="{{ route('context.show', ['id' => $context->id]) }}"
                                   class="text-primary text-sm font-semibold">
                                    View all surveys →
                                </a>

                            </div>

                        @endif


                    </div>


                </div>


            @endforeach


        </div>


    @else


        <div class="hero bg-base-200 rounded-xl py-16">

            <div class="hero-content text-center">

                <div>

                    <h2 class="text-2xl font-bold">
                        No survey contexts available
                    </h2>

                    <p class="text-base-content/70 mt-3">
                        Create a context and start adding surveys.
                    </p>

                    <a href="{{ route('survey.create.context.show') }}"
                       class="btn btn-primary mt-6">
                        Create Context
                    </a>

                </div>

            </div>

        </div>


    @endif

    <div class="mt-5">
        {{ $contexts->links() }}
    </div>

</div>
</x-base>
