import { newQuestion } from "./utils";

let questionsDiv = document.getElementById('questions');

function createQuestion(question){
    console.log(question['options']);
    filler(question);
}

let filler = (question) => {

    newQuestion(question);

};



window.createQuestion = createQuestion;
