<x-base :additionalResource="['resources/js/servey-create.js']">
        <div class="max-w-4xl mx-auto py-10 px-6">

        <h1 class="text-4xl font-bold mb-8">
            Create Survey
        </h1>


        <form action="#" method="POST">

            @csrf

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
                    >

                    <textarea
                        name="description"
                        placeholder="Survey description"
                        class="textarea textarea-bordered w-full mt-4"
                    ></textarea>

                </div>
            </div>



            <!-- Questions -->
            <div id="questions">



            </div>


            <button
                type="button"
                id="add-question"
                class="btn btn-outline mb-6"
            >
                + Add Question
            </button>


            <button class="btn btn-primary w-full">
                Create Survey
            </button>


        </form>

    </div>
</x-base>
