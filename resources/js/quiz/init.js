import axios from "axios";

export async function init() {
    try {
        const response = await axios.get("/api/questions");
        this.questions = response.data;
        if (this.questions.length > 0) {
            this.selectQuestion(0);
        }
        this.startTimer();
    } catch (error) {
        console.error("Error fetching questions:", error);
    }

    if (this.isDarkMode) {
        document.documentElement.classList.add("dark");
    }

    try {
        const answerRes = await axios.get("/api/user-answers");
        this.userAnswers = answerRes.data;
        this.updateProgress();
    } catch (error) {
        console.error("Error fetching user answers:", error);
    }
}