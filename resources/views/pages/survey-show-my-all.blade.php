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

                                <div class="dropdown dropdown-end">

                                    <button tabindex="0" class="btn btn-sm
                                        @if($survey->status === 'active')
                                            btn-success
                                        @elseif($survey->status === 'closed')
                                            btn-error bg-red-300 border-red-300
                                        @elseif($survey->status === 'archived')
                                            btn-neutral
                                        @else
                                            btn-warning
                                        @endif
                                    ">
                                        {{ ucfirst($survey->status) }}

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>

                                    </button>


                                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-40">

                                        <li>
                                            <form action="{{ route('survey.edit.status', ['id' => $survey->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" name="status" value="draft">
                                                    Draft
                                                </button>
                                            </form>
                                        </li>

                                        <li>
                                            <form action="{{ route('survey.edit.status', ['id' => $survey->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" name="status" value="active">
                                                    Active
                                                </button>
                                            </form>
                                        </li>

                                        <li>
                                            <form action="{{ route('survey.edit.status', ['id' => $survey->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" name="status" value="closed">
                                                    Closed
                                                </button>
                                            </form>
                                        </li>

                                        <li>
                                            <form action="{{ route('survey.edit.status', ['id' => $survey->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" name="status" value="archived">
                                                    Archived
                                                </button>
                                            </form>
                                        </li>

                                    </ul>

                                </div>

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
                                <span>{{ $survey->responses_count ?? 0 }}</span>
                            </div>

                            <div class="card-actions justify-end mt-6">

                                <a href={{ route('survey.view',['id'=>$survey->id]) }} class="btn btn-sm btn-outline">
                                    View
                                </a>

                                <a href="{{ route('survey.edit.show', ['id' => $survey->id]) }}" class="btn btn-sm btn-primary">
                                    Edit
                                </a>

                                <button class="btn btn-sm bg-red-600 text-red-100">
                                    Delete
                                </button>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</div>

</x-base>
