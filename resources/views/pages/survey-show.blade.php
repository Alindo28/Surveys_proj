@props(
    ['survey' => null,
    'surveyQuestions' => []]
)
<x-base>
    <div class="min-h-screen bg-base-200 py-10">

    <div class="max-w-3xl mx-auto">

        <!-- Survey Card -->
        <div class="card bg-base-100 shadow-xl">

            <div class="card-body">

                <!-- Title -->
                <h1 class="text-3xl font-bold">
                    {{ $survey->title }}
                </h1>

                <p class="text-gray-500 mt-2">
                    {{ $survey->description }}
                </p>


                <form action="{{ route('response.create', ['id'=>$survey->id]) }}" method="POST" class="mt-8 space-y-8">

                    <!-- Questions -->
                    @foreach ($surveyQuestions as $surveyQuestion)
                        @if ($surveyQuestion['type'] == 'text')
                            <div>
                                <div class="flex justify-between items-center gap-1">
                                <label class="font-bold text-lg">
                                    {{ $surveyQuestion['question'] }}
                                </label>
                                @if ($surveyQuestion['required'])
                                    <p class="text-[12px] text-gray-600">(required)</p>
                                @endif

                                </div>

                                <textarea
                                    {{ $surveyQuestion['required'] ? 'required' : '' }}
                                    name="answers[{{ $surveyQuestion['id'] }}]"
                                    class="textarea textarea-bordered w-full mt-3"
                                    placeholder="Write your answer"
                                ></textarea>
                            </div>

                        @elseif ($surveyQuestion['type'] == 'choice')

                            <div>
                                <div class="flex justify-between items-center gap-1">
                                <label class="font-bold text-lg">
                                    {{ $surveyQuestion['question'] }}
                                </label>
                                @if ($surveyQuestion['required'])
                                    <p class="text-[12px] text-gray-600">(required)</p>
                                @endif

                                </div>

                                <div class="mt-3 space-y-2">
                                    @foreach (explode('|',$surveyQuestion['options']) as $option)
                                        <label class="flex gap-2 items-center">
                                            <input
                                                {{ $surveyQuestion['required'] ? 'required' : '' }}
                                                type="radio"
                                                name="answers[{{ $surveyQuestion['id'] }}]"
                                                class="radio"
                                                value="{{ $option }}"
                                            >
                                            {{ $option }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                        @elseif($surveyQuestion['type'] == 'select')
                            <div>
                                <div class="flex justify-between items-center gap-1">
                                <label class="font-bold text-lg">
                                    {{ $surveyQuestion['question'] }}
                                </label>
                                @if ($surveyQuestion['required'])
                                    <p class="text-[12px] text-gray-600">(required)</p>
                                @endif

                                </div>

                                <div class="mt-3 space-y-2">
                                    @foreach (explode('|',$surveyQuestion['options']) as $option)
                                        <label class="flex gap-2 items-center">
                                            <input
                                                {{ $surveyQuestion['required'] ? 'required' : '' }}
                                                type="checkbox"
                                                name="answers[{{ $surveyQuestion['id'] }}]"
                                                class="checkbox"
                                                value="{{ $option }}"
                                            >
                                            {{ $option }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            @elseif($surveyQuestion['type'] == 'slider')
                            @php
                                [$min, $max] = explode('|', $surveyQuestion['options']);
                            @endphp

                            <div>
                                <div class="flex items-center gap-1 mb-2">
                                    <label class="font-bold text-lg">
                                        {{ $surveyQuestion['question'] }}
                                    </label>

                                    @if ($surveyQuestion['required'])
                                        <span class="text-xs text-gray-500">(required)</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-4">
                                    <span>{{ $min }}</span>

                                    <input
                                        id="slider-{{ $surveyQuestion->id }}"
                                        type="range"
                                        name="answers[{{ $surveyQuestion->id }}]"
                                        min="{{ $min }}"
                                        max="{{ $max }}"
                                        value="{{ $min }}"
                                        class="range range-primary flex-1"
                                        oninput="document.getElementById('slider-value-{{ $surveyQuestion->id }}').textContent = this.value"
                                    >

                                    <span>{{ $max }}</span>
                                </div>

                                <p class="mt-2 text-center font-semibold">
                                    Value:
                                    <span id="slider-value-{{ $surveyQuestion->id }}">{{ $min }}</span>
                                </p>
                            </div>
                        @endif
                    @endforeach



                    <button {{ $survey->user_id == auth()->id() || $survey->alreadyResponded() || $survey['status'] == 'closed'
                     ? 'disabled' : '' }} class="btn btn-primary w-full">

                    @if ($survey->alreadyResponded())
                        Already Responded
                    @elseif ($survey['status'] == 'closed')
                        Submission closed
                    @else
                        Submit
                    @endif

                    </button>
                </form>

                    @if ($survey->alreadyResponded())
                        <a href="{{ route('response.analysis',['id'=>$survey->id]) }}">
                            <button class="btn btn-info">
                                Analysis
                            </button></a>


                    @endif

            </div>

        </div>

    </div>

</div>

@include('components.errortext')
</x-base>
