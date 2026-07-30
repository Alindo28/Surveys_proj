let questionsDiv = document.getElementById('questions');

let ind = 0;

export function getInd() {
    return ind;
}

export function setInd(value) {
    ind = value;
}

function fixTitleCards(){
    let i = 1;
    Array.from(questionsDiv.getElementsByClassName("card-title")).forEach((element) => {
        element.innerHTML = `
            Question ${i}
        `
    })
}

function addOption(data , val='option'){
    let oId = data['optionInd'];
    data['optionInd']++;

    let newOption = document.createElement('div')
    newOption.className = "flex gap-2 mb-2 option";
    newOption.innerHTML = `
                                    <input
                                        type="text"
                                        value="${val}"
                                        name="questions[${data['cInd']}][options][]"
                                        class="input input-bordered w-full"
                                    >

                                    <button
                                        id="remove-option-${data['cInd']}-${oId}"
                                        type="button"
                                        class="remove-option cursor-pointer"
                                    >

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-red-500 font-bold">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>

                                    </button>
                                `

    document.getElementById(`option-list-${data.cInd}`).appendChild(newOption);

    document.getElementById(`remove-option-${data.cInd}-${oId}`).addEventListener('click', () => {
        document.getElementById(`option-list-${data.cInd}`).removeChild(newOption)
    })
}


export function newQuestion(question = null){

let cInd = getInd();
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
                            value="${question!=null ? question['question'] : ''}"
                            class="input input-bordered w-full"
                        >


                        <select
                            id="type-selection-${cInd}"
                            name="questions[${cInd}][type]"
                            class="select select-bordered mt-4 question-type"
                        >
                            <option ${question!=null && question['type'] === 'text' ? 'selected' : ''} value="text">
                                Free Response
                            </option>

                            <option ${question!=null && question['type'] === 'choice' ? 'selected' : ''} value="choice">
                                Multiple Choice
                            </option>

                            <option ${question!=null && question['type'] === 'select' ? 'selected' : ''} value="select">
                                Selection
                            </option>

                            <option ${question!=null && question['type'] === 'slider' ? 'selected' : ''} value="slider">
                                Slider
                            </option>
                        </select>


                        <div class="flex gap-2 mt-4">
                            <input
                                type="checkbox"
                                name="questions[${cInd}][required]"
                                class="checkbox"
                                ${question!=null && question['required'] ? 'checked' : ''}
                            >

                            <span>Required</span>

                            <input
                                type="checkbox"
                                name="questions[${cInd}][private]"
                                class="checkbox"
                                ${question!=null && question['private'] ? 'checked' : ''}
                            >

                            <span>Private</span>
                        </div>

                        <!-- field -->
                        <div id="field-${cInd}" class="options mt-4">

                            <h3 class="font-bold">
                                Answer
                            </h3>

                            <textarea
                                readonly
                                class="input text-center input-bordered w-full pt-2 pb-4 min-h-[20px] resize-none"
                            >Answer</textarea>

                        </div>

                        <!-- Options -->
                        <div id="options-${cInd}" class="hidden mt-4">

                            <h3 class="font-bold">
                                Choice Options
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

                        <!-- Slider -->
                        <div id="slider-${cInd}" class="options hidden mt-4">
                        <h3 class="font-bold">
                            Slider Range
                        </h3>
                        <div class="flex justify-center items-center">

                            <div class="flex items-center gap-1">
                            <label>Left: </label>
                            <input
                            name="questions[${cInd}][range][]"
                            type="number"
                            class="input validator"
                            required
                            placeholder="Starting number"
                            min="0"
                            max="1000"
                            value=1
                            />
                            <p class="validator-hint">Must be between be 0 to 1000</p>
                            </div>

                            <div class="flex items-center gap-1">
                            <label>Right: </label>
                            <input
                            name="questions[${cInd}][range][]"
                            type="number"
                            class="input validator"
                            required
                            placeholder="Ending number"
                            min="0"
                            max="1000"
                            value=10
                            />
                            <p class="validator-hint">Must be between be 0 to 1000</p>
                            </div>

                        </div>

                        </div>
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
    toggleVisibility(e.target.value);
})

function toggleVisibility(val){
    if(val == 'text'){
        document.getElementById(`field-${cInd}`).classList.remove('hidden');
        document.getElementById(`options-${cInd}`).classList.add('hidden');
        document.getElementById(`slider-${cInd}`).classList.add('hidden');
    }
    if(val == 'choice' || val == 'select'){
        document.getElementById(`field-${cInd}`).classList.add('hidden');
        document.getElementById(`options-${cInd}`).classList.remove('hidden');
        document.getElementById(`slider-${cInd}`).classList.add('hidden');
    }
    if(val == 'slider'){
        document.getElementById(`field-${cInd}`).classList.add('hidden');
        document.getElementById(`options-${cInd}`).classList.add('hidden');
        document.getElementById(`slider-${cInd}`).classList.remove('hidden');
    }
}

let optionsData = {
    'cInd' : cInd,
    'optionInd' : 0
}
// document.getElementById(`add-options-${cInd}`).addEventListener('click', () => {

//     let oId = optionInd;
//     optionInd++;

//     let newOption = document.createElement('div')
//     newOption.className = "flex gap-2 mb-2 option";
//     newOption.innerHTML = `
//                                     <input
//                                         type="text"
//                                         value="Option"
//                                         name="questions[${cInd}][options][]"
//                                         class="input input-bordered w-full"
//                                     >

//                                     <button
//                                         id="remove-option-${cInd}-${oId}"
//                                         type="button"
//                                         class="remove-option cursor-pointer"
//                                     >

//                                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-red-500 font-bold">
//                                     <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
//                                     </svg>

//                                     </button>
//                                 `

//     document.getElementById(`option-list-${cInd}`).appendChild(newOption);

//     document.getElementById(`remove-option-${cInd}-${oId}`).addEventListener('click', () => {
//         document.getElementById(`option-list-${cInd}`).removeChild(newOption)
//     })
// })



document.getElementById(`add-options-${cInd}`).addEventListener('click', () => {

    addOption(optionsData)
})

console.log(question);
if(question!=null && (question['type']==='choice' || question['type']==='select'))
question['options'].split('|').forEach((option)=>{
    addOption(optionsData, option);
})

if(question)toggleVisibility(question['type']);

setInd(getInd() + 1);

}
