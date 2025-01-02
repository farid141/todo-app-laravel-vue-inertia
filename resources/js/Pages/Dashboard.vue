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

const props = defineProps({
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
            <div class="mx-auto max-w-full sm:px-6 lg:px-8 grid grid-cols-7 gap-4">
                <div class="col-span-5 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <PrimaryButton class="ms-4">
                            <Link :href="route('tasks.create')" class="text-left">
                            Add Task
                            </Link>
                        </PrimaryButton>
                        <table id="myTable" class="">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Tags</th>
                                    <th>Users</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(task, index) in tasks" :key="task.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ task.title }}</td>
                                    <td>
                                        <span v-for="(tag, tagIdx) in task.tagList" :key="tagIdx"
                                            class="rounded bg-green-400 text-white mx-0.5 px-0.5">
                                            {{ tag }} </span>
                                    </td>
                                    <td>{{ task.usersString }}</td>
                                    <td>{{ task.id }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tag Counts by Tasks (1 column) -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Tags by Tasks</h3>
                        <ul class="space-y-2">
                            <li v-for="(count, index) in tag_by_task" :key="tag" class="flex items-center">
                                <span class="text-gray-700 mr-2">{{ index + 1 }}</span>
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">
                                    {{ `${count.name}: ${count.tasks_count}` }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tag Counts by Subtasks (1 column) -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Tags by Subtasks</h3>
                        <ul class="space-y-2">
                            <li v-for="(count, index) in tag_by_subtask" :key="tag" class="flex items-center">
                                <span class="text-gray-700 mr-2">{{ index + 1 }}</span>
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-sm">
                                    {{ `${count.name}: ${count.subtasks_count}` }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
