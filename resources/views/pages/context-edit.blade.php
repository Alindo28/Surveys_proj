@props(['context' => null, 'availableTags' => null, 'selectedTags'])
<x-base :additionalResource="['resources/js/context-edit.js', 'resources/js/context-create.js']">

<div class="min-h-screen bg-base-200 py-10">

    <div class="max-w-5xl mx-auto px-4">


        <div class="mb-8">

            <h1 class="text-4xl font-bold">
                Survey Context
            </h1>

            <p class="text-base-content/70 mt-2">
                Edit information, images, and instructions before your survey questions.
            </p>

        </div>



        <form
            action="{{ route('context.edit', ['id' => $context->id]) }}"
            method="POST"
            enctype="multipart/form-data"
            class="flex flex-col gap-6"
        >

            @method('put')
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
                            value="{{ $context->title }}"
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
                        >{{ $context->preview }}</textarea>


                    </div>

                                            <div class="form-control mt-6">

                            <label class="label">
                                <span class="label-text font-semibold">
                                    Tags
                                </span>
                            </label>


                            {{-- Selected tags --}}
                            <div id="selected-tags" class="flex flex-wrap gap-2 mb-3">
                            </div>


                            <button type="button" id="add-tag-btn" class="btn btn-sm btn-outline w-fit">
                                + Add Tag
                            </button>


                            {{-- Hidden tag selector --}}
                            <div id="tag-picker" class="hidden mt-4 p-4 bg-base-200 rounded-lg">

                                <input id="tag-search" type="text" placeholder="Search tags..."
                                    class="input input-bordered w-full">


                                <div id="available-tags" class="mt-3 max-h-48 overflow-y-auto space-y-1">
                                </div>

                            </div>

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

                    <script>
                        blocks = @json($context->blocks);
                        window.onload = ()=>{
                            for(i = 0; i < blocks.length; i++){
                                if(blocks[i].type === 'text'){
                                    addTextBlock(blocks[i]);
                                }
                                else if(blocks[i].type === 'image'){
                                    addImageBlock(blocks[i]);
                                }
                            }
                        }
                    </script>

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

    <script>
        window.availableTags = @json($availableTags);
        window.selectedTags = @json($selectedTags);
    </script>

</x-base>
