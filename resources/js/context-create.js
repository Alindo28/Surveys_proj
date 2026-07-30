import { addImageBlock, addTextBlock } from "./context-util";

let add_text_but = document.getElementById('add-text');
let add_image_but = document.getElementById('add-image');


add_text_but.addEventListener('click', ()=>{
    addTextBlock();
})

add_image_but.addEventListener('click', ()=>{
    addImageBlock();
})

