let questionsDiv = document.getElementById('questions');
let addQBut = document.getElementById('add-question');

let ind = 0

addQBut.addEventListener('click', () => {

let cInd = ind;
let questionHtml = `
                    <div class="card-body">

                        <div class="flex justify-between">

                            <h2 class="card-title">
                                Question ${cInd+1}
                            </h2>

                            <button
                                id=remove-${cInd}
                                type="button"
                                class="btn btn-error btn-sm remove-question"
                            >
                                Remove
                            </button>

                        </div>


                        <input
                            type="text"
                            name="questions[${cInd}][question]"
                            placeholder="Enter question"
                            class="input input-bordered w-full"
                        >


                        <select
                            id="type-selection-${cInd}"
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


                        <div class="flex gap-2 mt-4">
                            <input
                                type="checkbox"
                                name="questions[${cInd}][required]"
                                class="checkbox"
                            >

                            <span>Required</span>
                        </div>

                        <!-- field -->
                        <div id="field-${cInd}" class="options mt-4">

                            <h3 class="font-bold">
                                Answer
                            </h3>

                            <textarea
                                readonly
                                class="input text-center input-bordered w-full pt-2 pb-4 min-h-[20px] resize-none"
                            >User Answer</textarea>

                        </div>

                        <!-- Options -->
                        <div id="options-${cInd}" class="options hidden mt-4">

                            <h3 class="font-bold">
                                Options
                            </h3>


                            <div id="option-list-${cInd}" class="option-list">

                            </div>


                            <button
                                id="add-options-${cInd}"
                                type="button"
                                class="btn btn-secondary btn-sm add-option mt-3"
                            >
                                Add Option
                            </button>

                        </div>


                    </div>
`

let element = document.createElement('div');
element.className = "card bg-base-200 shadow-xl mb-6 question";
element.innerHTML = questionHtml;
questionsDiv.appendChild(element);

document.getElementById(`remove-${cInd}`).addEventListener('click', ()=>{
    questionsDiv.removeChild(element);
    fixTitleCards();
})

document.getElementById(`type-selection-${cInd}`).addEventListener('change', (e)=>{
    document.getElementById(`field-${cInd}`).classList.toggle('hidden');
    document.getElementById(`options-${cInd}`).classList.toggle('hidden');
})

let optionInd = 0;
document.getElementById(`add-options-${cInd}`).addEventListener('click', () => {

    let oId = optionInd;
    optionInd++;

    let newOption = document.createElement('div')
    newOption.className = "flex gap-2 mb-2 option";
    newOption.innerHTML = `
                                    <input
                                        type="text"
                                        value="Option"
                                        name="questions[${cInd}][options][]"
                                        class="input input-bordered w-full"
                                    >

                                    <button
                                        id="remove-option-${cInd}-${oId}"
                                        type="button"
                                        class="remove-option cursor-pointer"
                                    >

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-red-500 font-bold">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>

                                    </button>
                                `

    document.getElementById(`option-list-${cInd}`).appendChild(newOption);

    document.getElementById(`remove-option-${cInd}-${oId}`).addEventListener('click', () => {
        document.getElementById(`option-list-${cInd}`).removeChild(newOption)
    })
})

ind += 1;
})

function fixTitleCards(){
    let i = 1;
    Array.from(questionsDiv.getElementsByClassName("card-title")).forEach((element) => {
        element.innerHTML = `
            Question ${i}
        `
    })
}
