@props(
    ['surveyQuestion' => null,
    'Rigs' => [],
    'survey' => null
    ]
)
<x-base>
    <div class="min-h-screen bg-base-200">

    <div class="max-w-3xl mx-auto pt-5">
        <a href="{{ route('response.analysis', ['id' => $survey->id]) }}"><button class="btn btn-info mb-5">
        Back To Analysis
        </button></a>
        <div class="card bg-base-100 shadow-xl mb-7 p-4">

        <label for="toggle" class="cursor-pointer flex items-center gap-3">
            <span class="text-sm font-medium">
                Enable dummy value:
            </span>

            <input
                id = "toggle"
                type="checkbox"
                class="toggle toggle-primary"
                {{ count($Rigs) > 0 && $Rigs->first()['enable'] ? 'checked' : '' }}
            >
        </label>

        {{-- Collapse --}}
        <div class="mt-4">

            <h3 class="font-bold mb-3">
                Text Responses
            </h3>

            <div class="collapse collapse-arrow bg-base-200">

            <input type="checkbox">

            <div class="collapse-title font-medium">
                View entered dummies
            </div>

            <div class="collapse-content">
                <div class="flex flex-col gap-2 mt-2">
                    @foreach($Rigs as $rig)
                        <div class="bg-base-100 rounded p-3 flex justify-between items-center">
                            <p>Value: {{ is_array($rig['value']) ? implode(', ', $rig['value']) : $rig['value']}}</p>
                            <p>Units: {{ $rig['units'] }}</p>

                            <form action="{{ route('rig.delete', ['id' => $rig->id]) }}" method="post">
                                @csrf
                                @method('delete')

                            <button class="btn bg-red-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>


        </div>

        </div>
        <!-- Survey Card -->
        <div class="card bg-base-100 shadow-xl">

            <div class="card-body">

                <form action="{{ route('rig.create', ['id' => $surveyQuestion->id]) }}" method="POST" class="space-y-8">
                    <fieldset class="fieldset p-0">
                    <label class="label" for="units">Number of entry:</label>
                    <input
                    name="units"
                    type="number"
                    class="input validator"
                    required
                    placeholder="type the amount of input"
                    min="1"
                    max="100"
                    title="Must be between be 1 to 10"
                    value="1"
                    />
                    </fieldset>

                    <input hidden name="enable" type="checkbox" {{ count($Rigs) > 0 && $Rigs->first()['enable'] ? 'checked' : '' }}>

                    <p class="validator-hint">Must be between be 1 to 100</p>

                    <!-- Questions -->
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
                                    name="answers"
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
                                    @foreach ($surveyQuestion['options'] as $option)
                                        <label class="flex gap-2 items-center">
                                            <input
                                                {{ $surveyQuestion['required'] ? 'required' : '' }}
                                                type="radio"
                                                name="answers"
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
                                    @foreach ($surveyQuestion['options'] as $option)
                                        <label class="flex gap-2 items-center">
                                            <input
                                                {{-- {{ $surveyQuestion['required'] ? 'required' : '' }} --}}
                                                type="checkbox"
                                                name="answers[]"
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
                                $min = $surveyQuestion['options']['start'];
                                $max = $surveyQuestion['options']['end'];
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
                                    <span>{{ $surveyQuestion['type'] }}</span>

                                    <input
                                        id="slider-{{ $surveyQuestion->id }}"
                                        type="range"
                                        name="answers"
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



                    <div class="px-50">
                    <button class="btn btn-primary w-full">
                    Add
                    </button>
                    </div>


                </form>
            </div>
            </div>

        </div>

    </div>

</div>

@include('components.errortext')

<br>
</x-base>

<script>
    let qid = @js($surveyQuestion->id);
    const checkbox = document.getElementById('toggle');
checkbox.addEventListener('change', () => {
    console.log("dkoemfro");
fetch(`/rig/enter/${qid}`, {
    method: 'PATCH',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        toggle: checkbox.checked
    })
})
.then(response => response.text())
.then(data => {
    @if (count($Rigs) > 0)
        window.location.reload();
    @endif

});

});
</script>
