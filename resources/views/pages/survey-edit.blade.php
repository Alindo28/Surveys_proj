@props(['survey' => null])
<x-base :additionalResource="['resources/js/servey-create.js', 'resources/js/survey-edit.js']">
        <div class="max-w-4xl mx-auto py-10 px-6">

        <h1 class="text-4xl font-bold mb-8">
            Edit Survey
        </h1>

        <form action="{{ route('survey.edit', ['id' => $survey->id]) }}" method="POST">

            @csrf
            @method('PUT')

            <!-- Survey Information -->
            <div class="card bg-base-200 shadow-xl mb-8">
                <div class="card-body">

                    <h2 class="card-title">
                        Survey Details
                    </h2>

                    <input
                        type="text"
                        name="title"
                        placeholder="Survey title"
                        class="input input-bordered w-full"
                        value="{{ $survey->title }}"
                    >

                    <textarea
                        name="description"
                        placeholder="Survey description"
                        class="textarea textarea-bordered w-full mt-4"
                    >{{ $survey->description }}</textarea>

                </div>
            </div>



            <!-- Questions -->
            <div id="questions">
                <script>
                    questions = @json($survey->questions);
                    window.onload = ()=>{
                        for(let i=0; i < questions.length; i++){
                            createQuestion(questions[i]);
                        }
                    }
                </script>
            </div>


            <button
                type="button"
                id="add-question"
                class="btn btn-outline mb-6"
            >
                + Add Question
            </button>


            <button class="btn btn-primary w-full">
                Save Survey
            </button>


        </form>

    </div>
@include('components.errortext')
</x-base>
