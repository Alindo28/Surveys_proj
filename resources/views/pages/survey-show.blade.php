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
                                <label class="font-bold text-lg">
                                    {{ $surveyQuestion['question'] }}
                                </label>

                                <textarea
                                    name="answers[{{ $surveyQuestion['id'] }}]"
                                    class="textarea textarea-bordered w-full mt-3"
                                    placeholder="Write your answer"
                                ></textarea>
                            </div>

                        @else

                            <div>
                                <label class="font-bold text-lg">
                                    {{ $surveyQuestion['question'] }}
                                </label>

                                <div class="mt-3 space-y-2">
                                    @foreach (explode('|',$surveyQuestion['options']) as $option)
                                        <label class="flex gap-2 items-center">
                                            <input
                                                required
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

                        @endif
                    @endforeach



                    <button {{ $survey->user_id == auth()->id() || $survey->alreadyResponded()
                     ? 'disabled' : '' }} class="btn btn-primary w-full">

                    {{ $survey->alreadyResponded() ?
                    'Already Responded'
                    :'Submit Survey'}}

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
</x-base>
