let add_text_but = document.getElementById('add-text');
let add_image_but = document.getElementById('add-image');
let block_container = document.getElementById('context-container');

let ind = 0;

add_text_but.addEventListener('click', ()=>{
    let tblock = document.createElement('div');
    tblock.className += "card bg-base-200";

    tblock.innerHTML = `
                        <div class="card-body">


                            <div class="flex justify-between items-center">

                                <h3 class="font-bold">
                                    Text Block
                                </h3>


                                <button
                                    id="remove-block"
                                    type="button"
                                    class="btn btn-error btn-xs">
                                    Remove
                                </button>

                            </div>

                            <input name="context[${ind}][type]" hidden value="text" />
                            <textarea
                                name="context[${ind}][value]"
                                class="textarea textarea-bordered w-full mt-3"
                                placeholder="Write your text here..."
                            ></textarea>


                        </div>

    `;

    block_container.appendChild(tblock);
    tblock.querySelector('#remove-block').addEventListener('click', ()=>{
        tblock.remove();
    });

    ind++;
})

add_image_but.addEventListener('click', ()=>{
    let iblock = document.createElement('div');
    iblock.className += "card bg-base-200";
    iblock.innerHTML = `

                        <div class="card-body">


                            <div class="flex justify-between items-center">

                                <h3 class="font-bold">
                                    Image Block
                                </h3>


                                <button
                                    id="remove-block"
                                    type="button"
                                    class="btn btn-error btn-xs">
                                    Remove
                                </button>

                            </div>

                            <input name="context[${ind}][type]" hidden value="image" />
                            <input
                                type="file"
                                name="context[${ind}][value]"
                                class="file-input file-input-bordered w-full mt-3"
                            >


                            <img
                                class="hidden mt-4 rounded-lg max-h-64"
                                alt="Preview"
                            >


                        </div>

    `;

    block_container.appendChild(iblock);
    iblock.querySelector("#remove-block").addEventListener('click', ()=>{
        iblock.remove();
    });


    ind++;
})

