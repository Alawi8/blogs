export function updateTimerDisplay(totalSeconds) {
    let minutes = Math.floor(totalSeconds / 60);
    let seconds = totalSeconds % 60;
    this.timeLeft = `${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`;
}

export function startTimer() {
    // ✅ Clear any existing timer first
    if (this.timer) {
        clearInterval(this.timer);
        this.timer = null;
    }

    const secondsPerQuestion = 36;
    this.totalSeconds = this.questions.length * secondsPerQuestion;

    this.updateTimerDisplay(this.totalSeconds);

    this.timer = setInterval(() => {
        this.totalSeconds--;

        if (this.totalSeconds <= 0) {
            clearInterval(this.timer);
            this.timer = null;
            this.timeUp = true;
            this.endQuiz();
        } else {
            this.updateTimerDisplay(this.totalSeconds);
        }
    }, 1000);
}

