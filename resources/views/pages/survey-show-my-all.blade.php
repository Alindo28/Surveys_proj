<x-base>

    <div class="min-h-screen bg-base-200 py-10">

        <div class="max-w-6xl mx-auto px-4">


            <div class="flex justify-between items-center mb-8">

                <div>
                    <h1 class="text-4xl font-bold">
                        My Survey Contexts
                    </h1>

                    <p class="text-base-content/70 mt-2">
                        Manage your survey groups and surveys.
                    </p>
                </div>


                <a href="{{ route('survey.create.context.show') }}" class="btn btn-primary">

                    + Create Context

                </a>

            </div>



            @if($contexts->isEmpty())

                <div class="card bg-base-100 shadow-md">

                    <div class="card-body text-center">

                        <h2 class="text-2xl font-semibold">
                            No contexts yet
                        </h2>

                        <p class="text-base-content/70">
                            Create a context before adding surveys.
                        </p>

                    </div>

                </div>


            @else


                <div class="flex flex-col gap-8">


                    @foreach($contexts as $context)


                        <div class="card bg-base-100 shadow-xl">


                            <div class="card-body">


                                <div class="flex justify-center items-center gap-5">


                                    <div class="flex-8">

                                        <h2 class="text-2xl font-bold">
                                            {{ $context->title }}
                                        </h2>

                                        <p class="text-sm text-base-content/70">
                                            {{ $context->preview }}
                                        </p>

                                    </div>

                                    <div class="flex-0.5"></div>

                                    <div class="flex flex-5 gap-2">


                                        <a href="{{ route('survey.create.show', ['context_id' => $context->id]) }}"
                                            class="btn btn-m btn-primary mr-5">

                                            + Add Survey

                                        </a>


                                        <a href="{{ route('context.show', ['id' => $context->id]) }}"
                                            class="btn btn-m btn-outline">

                                            View

                                        </a>

                                            <a href="{{ route('context.edit.show', ['id' => $context->id]) }}"
                                            class="btn btn-accent btn-m">

                                            Edit

                                        </a>

                                        <form action="{{ route('context.delete', ['id' => $context->id]) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn bg-red-700/90 text-gray-100 btn-m">
                                                Delete
                                            </button>

                                        </form>



                                    </div>


                                </div>



                                <div class="divider"></div>



                                <h3 class="font-bold text-lg">
                                    Surveys
                                </h3>



                                @if($context->surveys->isEmpty())


                                    <div class="text-center text-base-content/60 py-4">

                                        No surveys in this context yet.

                                    </div>


                                @else



                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mt-3">


                                        @foreach($context->surveys as $survey)

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
                                                        <span>Total Questions:</span>
                                                        <span>{{ $survey->questions->count() }}</span>
                                                    </div>

                                                    <div class="flex justify-between text-sm">
                                                        <span>Total Responses:</span>
                                                        <span>{{ $survey->responses->count() }}</span>
                                                    </div>

                                                    <div class="card-actions flex flex-col justify-between items-center">

                                                        <div class="flex gap-3">

                                                            <form action="{{ route('survey.edit.status', ['id' => $survey->id]) }}"
                                                                method="POST" class="flex flex-1 justify-center items-center">

                                                                @csrf
                                                                @method('PATCH')

                                                                <div class="join">

                                                                    <div>

                                                                        <label class="input join-item max-w-20 py-3">

                                                                            <select name="status"
                                                                                class="select border-l-0 border-r-0 rounded-none cursor-pointer bg-none align-left p-0">
                                                                                <option value="draft" {{ $survey->status === 'draft' ? 'selected' : '' }}>
                                                                                    Draft
                                                                                </option>

                                                                                <option value="active" {{ $survey->status === 'active' ? 'selected' : '' }}>
                                                                                    Active
                                                                                </option>

                                                                                <option value="closed" {{ $survey->status === 'closed' ? 'selected' : '' }}>
                                                                                    Closed
                                                                                </option>

                                                                                <option value="archived" {{ $survey->status === 'archived' ? 'selected' : '' }}>
                                                                                    Archived
                                                                                </option>

                                                                            </select>

                                                                        </label>

                                                                    </div>

                                                                    <button class="btn btn-soft btn-neutral join-item">
                                                                        Save
                                                                    </button>

                                                                </div>

                                                            </form>

                                                            <a href="{{ route('response.view', ['id' => $survey->id]) }}">
                                                                <button class="btn btn-warning">
                                                                    Responses
                                                                </button>
                                                            </a>

                                                        </div>

                                                        <div class="flex max-w-40 gap-5 justify-center">

                                                            <a href="{{ route('survey.view', ['id' => $survey->id]) }}"
                                                                class="btn btn-sm btn-outline">
                                                                View
                                                            </a>

                                                            <a href="{{ route('survey.edit.show', ['id' => $survey->id]) }}"
                                                                class="btn btn-sm btn-primary">
                                                                Edit
                                                            </a>

                                                            <form action="{{ route('survey.delete', ['id' => $survey->id]) }}"
                                                                method="POST">

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



                    @endforeach


                </div>


            @endif


        </div>

    </div>


</x-base>
