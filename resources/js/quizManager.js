import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('quizManager', () => ({
    questions: [],
    currentIndex: 0,
    currentTitle: "Select a question",
    currentOptions: [],
    userAnswers: {},
    timeLeft: "02:00",
    timeUp: false,
    timer: null,
    progress: 0,
    showPopup: false,
    showHelp: false,
    showContact: false,
    showCalculator: false,
    calcInput: '',
    calcButtons: ['7', '8', '9', '/', '4', '5', '6', '*', '1', '2', '3', '-', '0', 'C', '+', '='],
    strikethroughAnswers: {},
    showEndTestModal: false, // Controls the pop-up visibility
    isDarkMode: false,

    async init() {
        try {
            const response = await fetch('/api/questions');
            const data = await response.json();
            this.questions = data;

            if (this.questions.length > 0) {
                this.selectQuestion(0);
            }
            this.startTimer();
        } catch (error) {
            console.error("Error fetching questions:", error);
        }
        if (this.isDarkMode) {
            document.documentElement.classList.add('dark');
        }
    },

    toggleDarkMode() {
        this.isDarkMode = !this.isDarkMode;
        document.documentElement.classList.toggle('dark', this.isDarkMode);
        localStorage.setItem('darkMode', this.isDarkMode);
    },

    selectQuestion(index) {
        this.currentIndex = index;
        this.currentTitle = this.questions[index].question_text;
        this.currentOptions = this.questions[index].answers;
        this.updateProgress();
    },

    prevQuestion() {
        if (this.currentIndex > 0) {
            this.selectQuestion(this.currentIndex - 1);
        }
    },

    nextQuestion() {
        if (this.currentIndex < this.questions.length - 1) {
            this.selectQuestion(this.currentIndex + 1);
        }
    },

    startTimer() {
        let totalSeconds = 500;
        this.updateTimerDisplay(totalSeconds);

        this.timer = setInterval(() => {
            if (totalSeconds <= 0) {
                clearInterval(this.timer);
                this.timeUp = true;
                return;
            }
            totalSeconds--;
            this.updateTimerDisplay(totalSeconds);
        }, 1000);
    },

    updateTimerDisplay(totalSeconds) {
        let minutes = Math.floor(totalSeconds / 60);
        let seconds = totalSeconds % 60;
        this.timeLeft = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    },

    updateProgress() {
        this.progress = ((this.currentIndex + 1) / this.questions.length) * 100;
    },

    endQuiz() {
        this.showEndTestModal = true; // Show confirmation modal
    },

    confirmEndQuiz() {
        this.timeUp = true;
        clearInterval(this.timer);
        this.showEndTestModal = false; // Close modal after confirmation
    },

    calculate(btn) {
        if (btn === 'C') {
            this.calcInput = '';
        } else if (btn === '=') {
            try {
                this.calcInput = eval(this.calcInput);
            } catch (e) {
                this.calcInput = 'Error';
            }
        } else {
            this.calcInput += btn;
        }
    },

    selectAnswer(questionIndex, answerText, optionIndex) {
        if (!this.isStrikethrough(questionIndex, optionIndex)) {
            this.userAnswers[questionIndex] = answerText;
        }
    },

    toggleStrikeThrough(questionIndex, optionIndex) {
        if (!this.strikethroughAnswers[questionIndex]) {
            this.strikethroughAnswers[questionIndex] = {};
        }
        this.strikethroughAnswers[questionIndex][optionIndex] = !this.strikethroughAnswers[questionIndex][optionIndex];

        if (this.strikethroughAnswers[questionIndex][optionIndex] && 
            this.userAnswers[questionIndex] === this.questions[questionIndex].answers[optionIndex].answer_text) {
            this.userAnswers[questionIndex] = null;
        }
    },

    isStrikethrough(questionIndex, optionIndex) {
        return this.strikethroughAnswers[questionIndex] && this.strikethroughAnswers[questionIndex][optionIndex];
    },

    get visibleQuestions() {
        return this.questions.slice(this.currentIndex, this.currentIndex + 6);
    },
}));

Alpine.start();
