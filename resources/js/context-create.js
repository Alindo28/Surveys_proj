import { addImageBlock, addTextBlock } from "./context-util";

let add_text_but = document.getElementById('add-text');
let add_image_but = document.getElementById('add-image');


add_text_but.addEventListener('click', ()=>{
    addTextBlock();
})

add_image_but.addEventListener('click', ()=>{
    addImageBlock();
})


const addBtn = document.getElementById('add-tag-btn');
const picker = document.getElementById('tag-picker');
const search = document.getElementById('tag-search');
const availableContainer = document.getElementById('available-tags');
const selectedContainer = document.getElementById('selected-tags');

const availableTags = window.availableTags;
let selectedTags = (window.selectedTags ?? []).map(tag => tag.id);
console.log(availableTags)
console.log(selectedTags)
renderTags();
renderSelected();


// Open picker
addBtn.addEventListener('click', () => {
    picker.classList.toggle('hidden');
    renderTags();
});


// Search
search.addEventListener('input', () => {
    renderTags();
});


// Render available tags
function renderTags(){

    availableContainer.innerHTML = "";


    const filtered = availableTags.filter(tag =>
        tag.name.toLowerCase()
        .includes(search.value.toLowerCase())
    );


    filtered.forEach(tag => {

        const button = document.createElement('button');

        button.type = "button";

        button.className =
            "w-full text-left px-3 py-2 rounded hover:bg-base-300 flex justify-between";


        button.innerHTML = `
            <span>${tag.name}</span>
            ${selectedTags.includes(tag.id) ? "✓" : ""}
        `;


        button.onclick = () => {

            if(selectedTags.includes(tag.id)){

                selectedTags =
                    selectedTags.filter(id => id !== tag.id);

            }
            else{

                selectedTags.push(tag.id);

            }


            renderTags();
            renderSelected();

        };


        availableContainer.appendChild(button);

    });

}


// Render selected tags
function renderSelected(){

    selectedContainer.innerHTML = "";


    selectedTags.forEach(id => {

        const tag = availableTags.find(t => t.id === id);


        const badge = document.createElement('div');

        badge.className =
            "badge badge-ghost gap-2";


        badge.innerHTML = `
            ${tag.name}
            <button type="button">✕</button>
        `;


        badge.querySelector('button').onclick = () => {

            selectedTags =
                selectedTags.filter(tagId => tagId !== id);

            renderSelected();
            renderTags();

        };


        selectedContainer.appendChild(badge);


        // Add hidden input
        const input = document.createElement('input');

        input.type = "hidden";
        input.name = "tags[]";
        input.value = id;

        selectedContainer.appendChild(input);

    });

}
