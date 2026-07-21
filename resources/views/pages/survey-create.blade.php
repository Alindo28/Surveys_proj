<x-base>
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

                <div class="card bg-base-200 shadow-xl mb-6 question">

                    <div class="card-body">

                        <div class="flex justify-between">

                            <h2 class="card-title">
                                Question 1
                            </h2>

                            <button
                                type="button"
                                class="btn btn-error btn-sm remove-question"
                            >
                                Remove
                            </button>

                        </div>


                        <input
                            type="text"
                            name="questions[0][question]"
                            placeholder="Enter question"
                            class="input input-bordered w-full"
                        >


                        <select
                            name="questions[0][type]"
                            class="select select-bordered mt-4 question-type"
                        >
                            <option value="text">
                                Free Response
                            </option>

                            <option value="choice">
                                Multiple Choice
                            </option>
                        </select>


                        <label class="flex gap-2 mt-4">
                            <input
                                type="checkbox"
                                name="questions[0][required]"
                                class="checkbox"
                            >

                            Required
                        </label>


                        <!-- Options -->
                        <div class="options hidden mt-4">

                            <h3 class="font-bold">
                                Options
                            </h3>


                            <div class="option-list">

                            </div>


                            <button
                                type="button"
                                class="btn btn-secondary btn-sm add-option mt-3"
                            >
                                Add Option
                            </button>

                        </div>


                    </div>

                </div>

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
