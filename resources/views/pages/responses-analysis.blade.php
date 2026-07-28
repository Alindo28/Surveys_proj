<x-base>

    <div class="min-h-screen bg-base-200 py-10">

        <div class="max-w-6xl mx-auto px-4">


            <h1 class="text-4xl font-bold">
                {{ $survey->title }} Analysis
            </h1>

            <p class="text-base-content/70 mt-2">
                Total Responses: {{ $responses->count() }}
            </p>


            <div class="divider"></div>


            <div class="flex flex-col gap-6">

                <div class="card">
                    <div class="card p-4 bg-base-100 shadow-m border-solid border-1">Average time to complete: {{ $avg_time }}</div>
                </div>

                @foreach($analysis as $question)

                    <div class="card bg-base-100 shadow-xl">

                        <div class="card-body">


                            <h2 class="card-title">
                                {{ $question['question'] }}
                            </h2>

                            @if (!$question['private'])
                            <p class="text-sm text-base-content/70">
                                Responses: {{ $question['total'] }}
                            </p>


                            @if($question['type'] === 'choice')


                                <div class="mt-4 flex flex-col gap-3">

                                    @foreach($question['results'] as $option => $percentage)

                                        <div>

                                            <div class="flex justify-between">

                                                <span>
                                                    {{ $option }}
                                                </span>

                                                <span>
                                                    {{ $percentage }}%
                                                </span>

                                            </div>


                                            <progress class="progress progress-primary w-full" value="{{ $percentage }}" max="100">
                                            </progress>


                                        </div>

                                    @endforeach

                                </div>


                            @else


                                <div class="mt-4">

                                    <h3 class="font-bold">
                                        Text Responses
                                    </h3>


                                    @foreach(array_reverse($question['answers']) as $answer)

                                        <div class="bg-base-200 rounded p-3 mt-2">
                                            {{ $answer }}
                                        </div>

                                    @endforeach


                                </div>


                            @endif
                        @else
                            <p>Hidden results</p>
                        @endif
                        </div>

                    </div>


                @endforeach


            </div>


        </div>

    </div>


</x-base>
