@props(
    [
        'survey' => null,
        'responses' => null
    ]
)

<x-base>

<div class="min-h-screen bg-base-200 py-10">

    <div class="max-w-5xl mx-auto px-4">

        <div class="flex justify-between">
        <div class="mb-8">
            <h1 class="text-4xl font-bold">
                {{ $survey->title }} Responses
            </h1>

            <p class="text-base-content/70 mt-2">
                Total Responses: {{ $responses->count() }}
            </p>
        </div>

        <a href="{{ route('response.analysis', ['id' => $survey->id]) }}"><button class="btn btn-info">
        Analysis
        </button></a>

        </div>

        @if($responses->isEmpty())

            <div class="card bg-base-100 shadow">
                <div class="card-body text-center">

                    <h2 class="text-2xl font-semibold">
                        No responses yet
                    </h2>

                    <p>
                        Nobody has completed this survey.
                    </p>

                </div>
            </div>


        @else

            <div class="flex flex-col gap-6">

                @foreach($responses as $index => $response)

                    <div class="card bg-base-100 shadow-xl">

                        <div class="card-body">

                            <div class="flex justify-between">

                                <h2 class="card-title">
                                    Response #{{ $index + 1 }}
                                </h2>

                                <span class="text-sm text-base-content/60">
                                    {{ $response->created_at->format('M d, Y') }}
                                </span>

                                <span class="text-sm text-base-content/60">
                                   Time taken: {{ $response->duration }}s
                                </span>

                            </div>


                            <div class="divider"></div>


                            @php
                                $answers = $response['answers'];
                            @endphp


                            <div class="flex flex-col gap-4">

                                @php
                                    $i = 0;
                                @endphp
                                @foreach($survey->questions as $question)

                                    <div>

                                        <h3 class="font-bold">
                                            {{ $question->question }}
                                        </h3>


                                        <p class="text-base-content/70">
                                            {{ $answers[$i] ?? 'No answer' }}
                                        </p>

                                    </div>

                                @php
                                    $i++;
                                @endphp

                                @endforeach

                            </div>


                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</div>

</x-base>
