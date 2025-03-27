import Alpine from "alpinejs";
import state from "./state";
import { init } from "./init";
import { selectQuestion, prevQuestion } from "./navigation";
import { nextQuestion } from "./submission";
import { updateTimerDisplay , startTimer } from "./timer";
import { endQuiz, confirmEndQuiz } from "./result";
import { calculate } from "./calculator";
import { clearAnswersAndRestart , goToHome } from './resultPanel';
import roleManager from './roleManage.js';
// import testManagerFactory from "./tests/testManager.js";
window.roleManager = roleManager;

import {
    updateProgress,
    toggleDarkMode,
    selectAnswer,
    toggleStrikeThrough,
    isStrikethrough,
    getVisibleQuestions
} from "./helpers";

import { getFilteredQuestions } from "./questionFilter";

// ✅ استدعاء بيانات السيرفر من window
const testsFromServer = window.testsFromServer || [];

export default Alpine.data("quizManager", () => {
    return {
        ...state,
        ...testManagerFactory(testsFromServer),

        init() {
            console.log("✅ Loaded tests:", this.tests);
        },

        selectQuestion,
        startTimer,
        prevQuestion,
        selectAnswer,
        nextQuestion,
        updateTimerDisplay,
        endQuiz,
        confirmEndQuiz,
        calculate,
        updateProgress,
        toggleDarkMode,
        toggleStrikeThrough,
        isStrikethrough,
        clearAnswersAndRestart,
        goToHome,

        get visibleQuestions() {
            return getFilteredQuestions(this.questions, this.userAnswers, this.filter);
        },

        watch: {
            'filter.selected': function () {
                this.currentIndex = 0;
                const firstVisible = this.visibleQuestions[0];
                if (firstVisible) {
                    const indexInAll = this.questions.findIndex(q => q.id === firstVisible.id);
                    if (indexInAll !== -1) {
                        this.selectQuestion(indexInAll);
                    }
                }
            }
        },

        selectQuestionById(id) {
            const index = this.questions.findIndex(q => q.id === id);
            if (index !== -1) {
                this.selectQuestion(index);
            } else {
                console.warn("❌ Question not found for ID:", id);
            }
        },
    };
});
