export function updateProgress() {
    const answeredCount = this.questions.filter((q) =>
        this.userAnswers[q.id] !== null && this.userAnswers[q.id] !== undefined
    ).length;
    this.progress = (answeredCount / this.questions.length) * 100;
}

export function toggleDarkMode() {
    this.isDarkMode = !this.isDarkMode;
    document.documentElement.classList.toggle("dark", this.isDarkMode);
    localStorage.setItem("darkMode", this.isDarkMode);
}

export function selectAnswer(questionIndex, answerText, optionIndex) {
    if (!this.isStrikethrough(questionIndex, optionIndex)) {
        const questionId = this.questions[questionIndex].id;
        this.userAnswers[questionId] = answerText;
        this.updateProgress();
    }
}


export function toggleStrikeThrough(questionIndex, optionIndex) {
    if (!this.strikethroughAnswers[questionIndex]) {
        this.strikethroughAnswers[questionIndex] = {};
    }
    this.strikethroughAnswers[questionIndex][optionIndex] =
        !this.strikethroughAnswers[questionIndex][optionIndex];
    if (
        this.strikethroughAnswers[questionIndex][optionIndex] &&
        this.userAnswers[questionIndex] ===
        this.questions[questionIndex].answers[optionIndex].answer_text
    ) {
        this.userAnswers[questionIndex] = null;
    }
}

export function isStrikethrough(questionIndex, optionIndex) {
    return (
        this.strikethroughAnswers[questionIndex] &&
        this.strikethroughAnswers[questionIndex][optionIndex]
    );
}

export function getVisibleQuestions() {
    return this.questions.slice(this.currentIndex, this.currentIndex + 6);
}