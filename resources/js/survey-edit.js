import { newQuestion } from "./servey-utils";

let questionsDiv = document.getElementById('questions');

function createQuestion(question){
    console.log(question);
    filler(question);
}

let filler = (question) => {

    newQuestion(question);

};



window.createQuestion = createQuestion;
