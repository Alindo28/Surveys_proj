<x-base>
    <div class="hero min-h-screen bg-base-200">
    <div class="hero-content text-center">
        <div class="max-w-3xl">

            <h1 class="text-5xl font-bold">
                Create Surveys. Collect Feedback. Make Better Decisions.
            </h1>

            <p class="py-6 text-lg">
                Build custom surveys, share them with others, and collect valuable
                responses with an easy-to-use survey platform.
            </p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('survey.create.show') }}" class="btn btn-primary">
                    Create a Survey
                </a>

                <a href="{{ route('survey.home') }}" class="btn btn-outline">
                    Take a Survey
                </a>
            </div>

        </div>
    </div>
</div>


</x-base>
