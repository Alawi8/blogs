import axios from "axios";

export async function endQuiz() {
    this.timeUp = true;
    clearInterval(this.timer);
    try {
        const response = await axios.get("/api/final-result");
        this.finalResult = response.data;
    } catch (error) {
        console.error("Failed to load result:", error);
        this.finalResult = { correct: 0, total: 0, score: 0 };
    }
    this.resultLoaded = true;
}

export function confirmEndQuiz() {
    this.timeUp = true;
    clearInterval(this.timer);
    this.showEndTestModal = false;
}