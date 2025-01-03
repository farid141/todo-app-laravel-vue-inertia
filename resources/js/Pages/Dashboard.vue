<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import { onMounted } from 'vue';
import DataTable from 'datatables.net-dt';
import 'datatables.net-dt/css/dataTables.dataTables.css';
import $ from 'jquery';
import { BIconPencilSquare, BIconTrash } from 'bootstrap-icons-vue'
import { useToast } from "vue-toastification";

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
    subtask_by_user: {
        type: Object,
    },
})

const toast = useToast();
const { flash } = usePage().props;

if (flash.success)
    toast.success(flash.success);

const destroy = (id) => {
    if (confirm('Are you sure you want to delete this task?')) {
        router.delete(route('tasks.destroy', id), {
            onSuccess: () => {
                toast.success('Task deleted successfully')
            }
        })
    }
}

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
                                    <td class="flex items-start gap-2 justify-center">
                                        <span>
                                            <Link :href="route('tasks.edit', task.id)">
                                            <BIconPencilSquare />
                                            </Link>
                                        </span>
                                        <span>
                                            <form @submit.prevent="destroy">
                                                <button type="button" @click="destroy(task.id)">
                                                    <BIconTrash />
                                                </button>
                                            </form>
                                        </span>
                                    </td>
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

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg col-span-6">
                    <div class="border rounded-lg mt-3">
                        <!-- Table Header -->
                        <div class="bg-gray-50 px-4 py-3 grid grid-cols-12 gap-4 border-b">
                            <div class="col-span-1 font-medium text-gray-700">#</div>
                            <div class="col-span-3 font-medium text-gray-700">Name</div>
                            <div class="col-span-8 font-medium text-gray-700">Subtasks</div>
                        </div>

                        <!-- Subtask List -->
                        <div v-for="(user, index) in subtask_by_user" :key="index"
                            class="px-4 py-3 grid grid-cols-12 gap-4 border-b items-center">
                            <div class="col-span-1">{{ index + 1 }}</div>
                            <div class="col-span-3">
                                {{ user.name }}
                            </div>
                            <div class="col-span-8">
                                <pre>{{ user.subtasks }}</pre>
                                <p v-for="(subtask, subtaskId) in user.subtasks" :key="subtaskId">
                                    {{ subtask.title }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
