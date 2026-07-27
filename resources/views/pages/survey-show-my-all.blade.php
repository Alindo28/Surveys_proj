<x-base>

<div class="min-h-screen bg-base-200 py-10">

    <div class="max-w-6xl mx-auto px-4">

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold">
                    My Surveys
                </h1>

                <p class="text-base-content/70 mt-2">
                    Manage all of your surveys in one place.
                </p>
            </div>

            <a href="{{ route('survey.create') }}" class="btn btn-primary">
                + Create Survey
            </a>
        </div>

        @if($surveys->isEmpty())

            <div class="card bg-base-100 shadow-md">
                <div class="card-body text-center">

                    <h2 class="text-2xl font-semibold">
                        No surveys yet
                    </h2>

                    <p class="text-base-content/70">
                        Create your first survey to start collecting responses.
                    </p>

                    <div class="card-actions justify-center mt-4">
                        <a href="{{ route('survey.create') }}" class="btn btn-primary">
                            Create Survey
                        </a>
                    </div>

                </div>
            </div>

        @else

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach($surveys as $survey)

                    <div class="card bg-base-100 shadow-xl">

                        <div class="card-body">

                            <div class="flex justify-between items-start">

                                <h2 class="card-title">
                                    {{ $survey->title }}
                                </h2>


                            </div>

                            <p class="text-sm text-base-content/70">
                                {{ $survey->description }}
                            </p>

                            <div class="divider my-2"></div>

                            <div class="flex justify-between text-sm">
                                <span>Total Questions: </span>
                                <span>{{ $survey->questions->count() }}</span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span>Total Responses: </span>
                                <span>{{ $survey->responses->count() ?? 0 }}</span>
                            </div>

                            <div class="card-actions flex flex-col justify-between items-center">
                                <div class="flex gap-3">
                                    <form action="{{ route('survey.edit.status', ['id' => $survey->id]) }}" method="POST" class="flex flex-1 justify-center items-center">
                                        @csrf
                                        @method('PATCH')
                                        <div class="join">
                                        <div>
                                            <label class="input join-item max-w-20 py-3">
                                        <select
                                            id="type-selection-${cInd}"
                                            name="status"
                                            class="select border-l-0 border-r-0 rounded-none question-type cursor-pointer bg-none align-left p-0"
                                        >
                                            <option class="text-left" {{ $survey->status === 'draft' ? 'selected' : ''}} value="draft">
                                                Draft
                                            </option>

                                            <option class="text-left" {{ $survey->status === 'active' ? 'selected' : ''}} value="active">
                                                Active
                                            </option>

                                            <option class="text-left" {{ $survey->status === 'closed' ? 'selected' : ''}} value="closed">
                                                Closed
                                            </option>

                                            <option class="text-left" {{ $survey->status === 'archived' ? 'selected' : ''}} value="archived">
                                                Archived
                                            </option>
                                        </select>
                                            </label>
                                            <div class="validator-hint hidden">Enter valid email address</div>
                                        </div>
                                        <button class="max-w-15 btn btn-soft btn-neutral join-item">Save</button>
                                        </div>

                                    </form>

                                    <a href="{{ route('response.view', ['id'=>$survey->id]) }}">
                                    <button class="btn btn-warning flex-1">
                                        Responses
                                    </button> </a>
                                </div>


                                <div class="flex max-w-40 gap-5 justify-center">
                                <a href={{ route('survey.view',['id'=>$survey->id]) }} class="btn btn-sm btn-outline">
                                    View
                                </a>

                                <a href="{{ route('survey.edit.show', ['id' => $survey->id]) }}" class="btn btn-sm btn-primary">
                                    Edit
                                </a>

                                <form action="{{ route('survey.delete', ['id' => $survey->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm bg-red-600 text-red-100">
                                        Delete
                                    </button>
                                </form>
                                </div>



                            </div>


                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</div>
@include('components.errortext')
</x-base>
