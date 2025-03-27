<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles Management') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6 bg-white rounded-lg shadow"
         x-data="roleManager()" x-init="fetchData()">

        <!-- Success message alert -->
        <template x-if="successMessage">
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded" x-text="successMessage"></div>
        </template>

        <!-- Loading text -->
        <template x-if="!users.length">
            <p>Loading users...</p>
        </template>

        <!-- Users table -->
        <table class="w-full text-left border" x-show="users.length">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 border">Name</th>
                    <th class="p-3 border">Email</th>
                    <th class="p-3 border">Roles</th>
                    <th class="p-3 border">Action</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="user in users" :key="user.id">
                    <tr class="border-t">
                        <td class="p-3 border" x-text="user.name"></td>
                        <td class="p-3 border" x-text="user.email"></td>
                        <td class="p-3 border">
                            <select x-model="user.selectedRoles" multiple class="border rounded p-1 w-full">
                                <template x-for="role in roles" :key="role.name">
                                    <option :value="role.name" x-text="role.name"></option>
                                </template>
                            </select>
                        </td>
                        <td class="p-3 border">
                            <button @click="updateRoles(user)" class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">
                                Save
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>


</x-app-layout>
