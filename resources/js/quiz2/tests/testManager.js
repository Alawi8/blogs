import axios from "axios";

export default function testManagerFactory(initialTests = []) {
    return {
        tests: initialTests,
        newTestTitle: '',

        async createTest() {
            if (!this.newTestTitle.trim()) {
                alert("Title is required");
                return;
            }

            try {
                const response = await axios.post('api/tests', {
                    title: this.newTestTitle
                }, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    }
                });

                this.tests.push(response.data.test);
                this.newTestTitle = '';
            } catch (error) {
                console.error("❌ Error adding test:", error);
                alert("Failed to create test.");
            }
        }
    };
}
