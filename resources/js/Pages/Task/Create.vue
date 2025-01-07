<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

import TaskUser from "@/Pages/Task/Partials/TaskUser.vue";
import Subtask from "@/Pages/Task/Partials/Subtask.vue";

import { useToast } from "vue-toastification";

const props = defineProps({
  errors: {
    type: Object,
  },
  task: {
    type: Array,
  },
  users: {
    type: Object,
  },
  tags: {
    type: Object,
  },
});
const isEdit = route().current().split(".").pop() === "edit";

const toast = useToast();
const form = useForm({
  title: props.task?.title ?? null,
  description: props.task?.description ?? null,

  // BE mentransformasikan dengan awalan "task" agar tidak bentrok dg relationship
  tags: props.task?.taskTags ?? [],
  users: props.task?.taskUsers ?? [],
  subtasks: props.task?.taskSubtasks ?? [],
});

function handleSubmit() {
  form[isEdit ? "put" : "post"](
    route(
      isEdit ? "tasks.update" : "tasks.store",
      isEdit ? props.task.id : undefined
    ),
    {
      onError: (errors) => {
        const errorMessages = Object.values(errors).flat().join("\n");
        toast.error(errorMessages, {
          timeout: 8000, // Allow time to read
        });
      },
    }
  );
}
</script>

<template>
  <Head :title="`${isEdit ? 'Edit' : 'Add'} Task`" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ isEdit ? "Edit" : "Add" }} Task
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
                  <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    required
                    autofocus
                    autocomplete="title"
                  />
                </div>

                <div>
                  <InputLabel for="description" value="Description" />
                  <textarea
                    id="description"
                    type="text"
                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1 block w-full"
                    v-model="form.description"
                    required
                    autofocus
                    autocomplete="description"
                  />
                </div>

                <div>
                  <InputLabel for="tags" value="Tags" />
                  <vSelect
                    :options="tags"
                    label="name"
                    v-model="form.tags"
                    multiple="true"
                    :reduce="(option) => option.id"
                  />
                </div>

                <div>
                  <TaskUser
                    :formUsers="form.users"
                    @update:formUsers="(value) => (form.users = value)"
                    :users="users"
                    :errors="form.errors"
                  />
                </div>
              </div>

              <div class="subtask-data">
                <Subtask
                  :subtasks="form.subtasks"
                  @update:subtasks="(value) => (form.subtasks = value)"
                  :tags="tags"
                />
              </div>
            </div>

            <div class="flex items-center gap-4">
              <PrimaryButton :disabled="form.processing">{{
                isEdit ? "Update" : "Save"
              }}</PrimaryButton>

              <Transition
                enter-active-class="transition ease-in-out"
                enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out"
                leave-to-class="opacity-0"
              >
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
