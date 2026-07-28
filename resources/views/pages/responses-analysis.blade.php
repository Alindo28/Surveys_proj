<x-base>

<div class="min-h-screen bg-base-200 py-10">

    <div class="max-w-6xl mx-auto px-4">

        <div class="mb-8">

            <h1 class="text-4xl font-bold">
                {{ $survey->title }} Analysis
            </h1>


        </div>


        <div class="card bg-base-100 shadow-md border border-base-300 mb-8">

            <div class="card-body">

                <h2 class="font-bold text-lg">
                    Survey Overview
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">

                    <div class="stat bg-base-200 rounded-lg">

                        <div class="stat-title">
                            Total Responses
                        </div>

                        <div class="stat-value text-primary">
                            {{ $responses->count() }}
                        </div>

                    </div>


                    <div class="stat bg-base-200 rounded-lg">

                        <div class="stat-title">
                            Average Completion Time
                        </div>

                        <div class="stat-value text-lg">
                            {{ $avg_time }}
                        </div>

                    </div>

                </div>

            </div>

        </div>



        <div class="flex flex-col gap-6">


            @foreach($analysis as $question)


                <div class="card bg-base-100 shadow-xl">

                    <div class="card-body">


                        <div class="flex justify-between items-start gap-4">


                            <h2 class="card-title">
                                {{ $question['question'] }}
                            </h2>


                            @if(isset($question['type']))

                                <div class="badge badge-outline">
                                    {{ ucfirst($question['type']) }}
                                </div>

                            @endif


                        </div>



                        @if($question['private'])


                            <div class="text-center py-8 text-base-content/60">

                                <p class="font-semibold">
                                    Results Hidden
                                </p>

                                <p class="text-sm">
                                    Results of this question is marked as private.
                                </p>

                            </div>


                        @else



                            <p class="text-sm text-base-content/70">
                                Responses: {{ $question['total'] }}
                            </p>



                            @if($question['total'] == 0)


                                <div class="text-center py-6 text-base-content/60">
                                    No responses yet.
                                </div>



                            @elseif($question['type'] === 'choice' || $question['type'] === 'select')



                                <div class="mt-4 flex flex-col gap-4">


                                    @foreach($question['results'] as $option => $percentage)


                                        <div>


                                            <div class="flex justify-between mb-1">

                                                <span>
                                                    {{ $option }}
                                                </span>

                                                <span>
                                                    {{ $percentage }}%
                                                </span>

                                            </div>


                                            <progress
                                                class="progress progress-primary w-full"
                                                value="{{ $percentage }}"
                                                max="100">
                                            </progress>


                                        </div>


                                    @endforeach


                                </div>




                            @elseif($question['type'] === 'text')



                                <div class="mt-4">


                                    <h3 class="font-bold mb-3">
                                        Text Responses
                                    </h3>



                                    <div class="collapse collapse-arrow bg-base-200">

                                    <input type="checkbox">

                                    <div class="collapse-title font-medium">
                                        View Responses ({{ count($question['answers']) }})
                                    </div>

                                    <div class="collapse-content">

                                        <div class="flex flex-col gap-2 mt-2">

                                            @foreach(array_reverse($question['answers']) as $answer)

                                                <div class="bg-base-100 rounded p-3">
                                                    {{ $answer }}
                                                </div>

                                            @endforeach

                                        </div>

                                    </div>

                                </div>


                                </div>




                            @elseif($question['type'] === 'slider')

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">


                                    <div class="stat bg-base-200 rounded-lg">

                                        <div class="stat-title">
                                            Average
                                        </div>

                                        <div class="stat-value text-primary">
                                            {{ round(array_sum($question['answers'])/count($question['answers']), 2) }}
                                        </div>

                                    </div>



                                    <div class="stat bg-base-200 rounded-lg">

                                        <div class="stat-title">
                                            Minimum
                                        </div>

                                        <div class="stat-value">
                                            {{ min($question['answers']) }}
                                        </div>

                                    </div>



                                    <div class="stat bg-base-200 rounded-lg">

                                        <div class="stat-title">
                                            Maximum
                                        </div>

                                        <div class="stat-value">
                                            {{ max($question['answers']) }}
                                        </div>

                                    </div>



                                    <div class="stat bg-base-200 rounded-lg">

                                        <div class="stat-title">
                                            Range
                                        </div>
                                        <div class="stat-value text-lg">

                                            {{ explode('|',$question['options'])[0] }}
                                            -
                                            {{ explode('|',$question['options'])[1] }}

                                        </div>

                                    </div>


                                </div>




                                <div class="mt-6">


                                    <h3 class="font-bold mb-3">
                                        Distribution
                                    </h3>


                                    @php
                                        $distribution = array_count_values($question['answers']);
                                        ksort($distribution);
                                    @endphp
                                    @foreach($distribution as $value => $count)

                                        @php

                                            $percentage = $question['total'] > 0
                                                ? round(($count / $question['total']) * 100, 1)
                                                : 0;

                                        @endphp



                                        <div class="mb-3">


                                            <div class="flex justify-between text-sm">

                                                <span>
                                                    {{ $value }}
                                                </span>


                                                <span>
                                                    {{ $percentage }}%
                                                </span>

                                            </div>


                                            <progress
                                                class="progress progress-primary w-full"
                                                value="{{ $percentage }}"
                                                max="100">
                                            </progress>


                                        </div>


                                    @endforeach


                                </div>



                            @endif


                        @endif


                    </div>

                </div>


            @endforeach


        </div>


    </div>


</div>


</x-base>
