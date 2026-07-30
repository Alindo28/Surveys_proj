@props([
    'context' => null
])
<x-base>

<div class="min-h-screen bg-base-200 py-12">

    <article class="max-w-5xl mx-auto bg-base-100 shadow-2xl rounded-xl overflow-hidden">

        <!-- Header -->
        <header class="px-12 pt-12 pb-8 border-b border-base-300">

            <div class="text-sm uppercase tracking-widest text-primary font-semibold">
                Survey Context
            </div>

            <h1 class="text-5xl font-bold leading-tight mt-3">
                {{ $context->title }}
            </h1>

            <p class="mt-5 text-lg text-base-content/70 leading-relaxed">
                {{ $context->preview }}
            </p>

            <div class="mt-8 flex gap-6 text-sm text-base-content/60">

                <span>
                    {{ $context->created_at->format('F j, Y') }}
                </span>

                <span>
                    {{ $context->user->full_name }}
                </span>

            </div>

        </header>



        <!-- Article Body -->
        <div class="px-12 py-10 space-y-10">

            @foreach($context->blocks as $block)

                @if($block->type === 'text')

                    <div class="prose prose-lg max-w-none">

                        {!! nl2br(e($block->value)) !!}

                    </div>

                @elseif($block->type === 'image')

                    <figure class="space-y-3">

                        <img
                            src="{{$block->value }}"
                            class="w-full rounded-lg shadow-md"
                        >

                        @if($block->caption)

                            <figcaption class="text-center text-sm text-base-content/60 italic">
                                {{ $block->caption }}
                            </figcaption>

                        @endif

                    </figure>

                @endif

            @endforeach

        </div>



        <!-- Footer -->
        <footer class="border-t border-base-300 px-12 py-8">

            <div class="flex justify-between items-center">

                <div>

                    <p class="font-semibold">
                        Ready to participate?
                    </p>

                    <p class="text-sm text-base-content/60">
                        Choose one of the surveys below.
                    </p>

                </div>

            </div>

        </footer>

    </article>



    <!-- Surveys -->
    <div class="max-w-5xl mx-auto mt-10">

        <h2 class="text-3xl font-bold mb-6">
            Surveys
        </h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($context->surveys as $survey)
                @if ($survey['status'] == 'draft' || $survey['status'] == 'archived')
                    @continue
                @endif

                <div class="card bg-base-100 shadow-lg">

                    <div class="card-body">

                        <div class="flex justify-between">

                            <h3 class="card-title">
                                {{ $survey->title }}
                            </h3>

                            <div class="badge
                                @if($survey->status === 'active')
                                    badge-success
                                @elseif($survey->status === 'draft')
                                    badge-warning
                                @elseif($survey->status === 'closed')
                                    badge-error
                                @else
                                    badge-neutral
                                @endif">
                                {{ ucfirst($survey->status) }}
                            </div>

                        </div>

                        <p class="text-sm text-base-content/70">
                            {{ Str::limit($survey->description, 120) }}
                        </p>

                        <div class="mt-4 text-sm space-y-1">

                            <div class="flex justify-between">
                                <span>Questions</span>
                                <span>{{ $survey->questions->count() }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span>Responses</span>
                                <span>{{ $survey->responses->count() }}</span>
                            </div>

                        </div>

                        <div class="card-actions justify-end mt-5">

                            <a
                                href="{{ route('survey.view', ['id'=>$survey->id]) }}"
                                class="btn btn-primary btn-sm">
                                Open Survey
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>

</x-base>
