
<x-base>
    <div class="max-w-6xl mx-auto px-6 py-10">

    <div class="flex justify-center items-center mb-8 mr-[-20vw]">
        <div class="flex flex-col justify-center items-center">
            <h1 class="text-4xl font-bold">
                Available Surveys
            </h1>

            <p class="text-base-content/70 mt-2">
                Browse and complete surveys created by the community.
            </p>
        </div>

            <div class="pl-[20vw]">
                <a href="{{ route('show.survey_create') }}" class="btn btn-primary">
                    Create Survey
                </a>
            </div>



    </div>
    @if($surveys->count())

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($surveys as $survey)

                <div class="card bg-base-200 shadow-xl">

                    <div class="card-body">

                        <div class="flex justify-between items-start">

                            <h2 class="card-title">
                                {{ $survey->title }}
                            </h2>

                            <div class="badge badge-primary">
                                {{ ucfirst($survey->status) }}
                            </div>

                        </div>


                        <p class="text-base-content/70">
                            {{ Str::limit($survey->description, 120) }}
                        </p>


                        <div class="mt-4 text-sm">
                            <p>
                                Created by:
                                <span class="font-semibold">
                                    {{ $survey->user->name }}
                                </span>
                            </p>

                            <p>
                                Created:
                                {{ $survey->created_at->format('M d, Y') }}
                            </p>
                        </div>


                        <div class="card-actions justify-end mt-4">

                            <a
                                class="btn btn-primary"
                            >
                                View Survey
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


    @else

        <div class="alert">
            <span>No surveys available.</span>
        </div>

    @endif

</div>
</x-base>
