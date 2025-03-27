export function calculate(btn) {
    if (btn === "C") {
        this.calcInput = "";
    } else if (btn === "=") {
        try {
            this.calcInput = eval(this.calcInput);
        } catch (e) {
            this.calcInput = "Error";
        }
    } else {
        this.calcInput += btn;
    }
}