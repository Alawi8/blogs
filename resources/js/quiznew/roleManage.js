import axios from 'axios';

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

export default function roleManager() {
    return {
        users: [],
        roles: [],
        successMessage: '',

        // Fetch users and roles
        async fetchData() {
            try {
                const res = await axios.get('/users/roles', {
                    headers: { 'Accept': 'application/json' }
                });

                this.users = res.data.users.map(user => ({
                    ...user,
                    selectedRoles: user.roles.map(role => role.name),
                }));
                this.roles = res.data.roles;
            } catch (err) {
                alert('Failed to load data.');
            }
        },

        // Update selected roles for a user
        async updateRoles(user) {
            try {
                await axios.post(`/users/${user.id}/roles`, {
                    roles: user.selectedRoles
                });

                this.successMessage = 'Roles updated successfully.';
                setTimeout(() => this.successMessage = '', 3000);
            } catch (err) {
                alert('Failed to update roles.');
            }
        }
    }
}
