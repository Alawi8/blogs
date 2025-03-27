import axios from "axios";

export async function nextQuestion() {
    const currentQ = this.questions[this.currentIndex];
    const questionId = currentQ.id;
    const answerText = this.userAnswers[questionId];

    if (!answerText) {
        alert("Please select an answer before continuing.");
        return;
    }

    const selected = currentQ.answers.find(
        (ans) => ans.answer_text === answerText
    );

    if (!selected || !selected.id) {
        alert("Invalid or missing answer. Please try again.");
        return;
    }

    try {
        const response = await axios.post("/api/submit-answer", {
            question_id: questionId,
            answer_id: selected.id,
        });

        console.log("✅ Answer submitted:", response.data.message);
    } catch (error) {
        console.error("❌ Submission failed:", error);
        alert("Could not connect to the server.");
        return;
    }

    // ✅ confirme answer
    this.confirmedAnswers[questionId] = true;

    // move next question
    if (this.currentIndex < this.questions.length - 1) {
        this.selectQuestion(this.currentIndex + 1);
    } else {
        this.showEndTestModal = true;
    }
}
