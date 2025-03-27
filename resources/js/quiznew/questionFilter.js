export function getFilteredQuestions(questions, userAnswers, filter) {
    const selected = filter.selected;

    console.log("🔍 Filtering questions:");
    console.log("Selected filter:", selected);
    console.log("User answers:", userAnswers);

    if (!this.questions || this.questions.length === 0) return [];
    return questions.filter((q) => {
        const hasAnswer =
            Object.prototype.hasOwnProperty.call(userAnswers, q.id) &&
            userAnswers[q.id] !== null &&
            userAnswers[q.id] !== "";

        const isFlagged = q.isFlagged === true;

        console.log(
            `Question ID: ${q.id} | Text: ${q.question_text} | hasAnswer: ${hasAnswer}`
        );

        if (selected === "answered") return hasAnswer;
        if (selected === "unanswered") return !hasAnswer;
        if (selected === "flagged") return isFlagged;

        return true; // default: show all
    });
}
