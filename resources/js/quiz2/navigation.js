export function selectQuestion(index) {
    const question = this.questions[index];
    this.currentIndex = index;
    this.currentTitle = question.question_text;
    this.currentOptions = question.answers;
}



export function prevQuestion() {
    if (this.currentIndex > 0) {
        this.selectQuestion(this.currentIndex - 1);
    }
}