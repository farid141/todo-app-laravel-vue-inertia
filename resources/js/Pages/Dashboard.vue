<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import { onMounted } from 'vue';
import DataTable from 'datatables.net-dt';
import 'datatables.net-dt/css/dataTables.dataTables.css';
import $ from 'jquery';

onMounted(() => {
    let table = new DataTable('#myTable');
});

defineProps({
    tasks: {
        type: Object,
    },
    tag_by_task: {
        type: Object,
    },
    tag_by_subtask: {
        type: Object,
    },
})
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 flex gap-4">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Link :href="route('tasks.create')">
                        <PrimaryButton class="ms-4">
                            Add Task
                        </PrimaryButton>
                        </Link>
                        <table id="myTable" class="">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Tags</th>
                                    <th>Users</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="task in tasks" :key="task.id">
                                    <td>{{ task.title }}</td>
                                    <td>{{ task.tags }}</td>
                                    <td>{{ task.title }}</td>
                                    <td>{{ task.id }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg w-max flex flex-col">
                    <div class="p-6 text-gray-900">
                        asd
                    </div>
                    <div class="p-6 text-gray-900">
                        asd
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
