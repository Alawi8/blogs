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

export default function () {
    return {
        redirectTo(path) {
            window.location.href = path;
        },

        replaceWith(path) {
            window.location.replace(path);
        },

        goBack() {
            window.history.back();
        },

        goForward() {
            window.history.forward();
        }
    };
}
