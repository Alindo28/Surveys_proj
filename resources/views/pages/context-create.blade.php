<x-base :additionalResource="['resources/js/context-create.js']">

<div class="min-h-screen bg-base-200 py-10">

    <div class="max-w-5xl mx-auto px-4">


        <div class="mb-8">

            <h1 class="text-4xl font-bold">
                Survey Context
            </h1>

            <p class="text-base-content/70 mt-2">
                Add information, images, and instructions before your survey questions.
            </p>

        </div>



        <form
            action="{{ route('survey.create.context') }}"
            method="POST"
            enctype="multipart/form-data"
            class="flex flex-col gap-6"
        >

            @csrf



            <!-- Context Details -->

            <div class="card bg-base-100 shadow-xl">

                <div class="card-body gap-4">


                    <h2 class="card-title">
                        Create Context
                    </h2>



                    <div class="form-control">

                        <label class="label">

                            <span class="label-text font-semibold">
                                Title
                            </span>

                        </label>


                        <input
                            name="title"
                            type="text"
                            placeholder="Enter context title"
                            class="input input-bordered w-full"
                        />

                    </div>




                    <div class="form-control">

                        <label class="label">

                            <span class="label-text font-semibold">
                                Description
                            </span>

                        </label>


                        <textarea
                            name="preview"
                            placeholder="Briefly describe this survey context..."
                            class="textarea textarea-bordered w-full min-h-32"
                        ></textarea>


                    </div>


                </div>

            </div>





            <!-- Content Blocks -->


            <div class="card bg-base-100 shadow-xl">

                <div class="card-body">


                    <div class="flex justify-between items-center">

                        <h2 class="card-title">
                            Content Blocks
                        </h2>


                    </div>




                    <div
                        id="context-container"
                        class="flex flex-col gap-5 mt-6"
                    >

                    </div>





                    <div class="divider"></div>




                    <div class="flex justify-between">


                        <div class="flex gap-2">


                            <button
                                id="add-text"
                                type="button"
                                class="btn btn-primary btn-sm"
                            >
                                + Text
                            </button>



                            <button
                                id="add-image"
                                type="button"
                                class="btn btn-secondary btn-sm"
                            >
                                + Image
                            </button>


                        </div>




                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Save Context
                        </button>


                    </div>



                </div>

            </div>


        </form>



    </div>

</div>


</x-base>
