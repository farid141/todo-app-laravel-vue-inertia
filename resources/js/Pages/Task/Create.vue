<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import TaskUser from '@/Pages/Task/Partials/TaskUser.vue';
import Subtask from '@/Pages/Task/Partials/Subtask.vue';

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

const props = defineProps({
    users: {
        type: Object,
    },
    tags: {
        type: Object,
    },
})

const form = useForm({
    title: null,
    description: null,
    tags: [],
    taskUsers: [],
    subtasks: [],
});

function handleSubmit() {
    form.transform((data) => ({
        ...data,
        tags: data.tags.map(tag => tag.id)
    })).post(route('tasks.store'))
}

function updateTaskUsers(value) {
    form.taskUsers = value
}

function updateSubtasks(value) {
    form.subtasks = value
}

</script>

<template>

    <Head title="Add Task" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Add Task
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg sm:p-8">
                    <form @submit.prevent="handleSubmit" class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="task-data">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Task</h3>
                                <div>
                                    <InputLabel for="title" value="Title" />
                                    <TextInput id="title" type="text" class="mt-1 block w-full" v-model="form.title"
                                        required autofocus autocomplete="title" />
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>

                                <div>
                                    <InputLabel for="description" value="Description" />

                                    <TextInput id="description" type="text" class="mt-1 block w-full"
                                        v-model="form.description" required autofocus autocomplete="description" />
                                    <InputError class="mt-2" :message="form.errors.description" />
                                </div>

                                <div>
                                    <InputLabel for="tags" value="Tags" />
                                    <vSelect :options="tags" label="name" v-model="form.tags" multiple="true"
                                        :reduce="option => option.id" />
                                    <InputError class="mt-2" :message="form.errors.tags" />
                                </div>

                                <div>
                                    <TaskUser :taskUsers="form.taskUsers" @update:taskUsers="updateTaskUsers"
                                        :users="users" :errors="form.errors" />
                                </div>
                            </div>

                            <div class="subtask-data">
                                <Subtask :subtasks="form.subtasks" @update:subtasks="updateSubtasks" :tags="tags" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                                    Saved.
                                </p>
                            </Transition>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
