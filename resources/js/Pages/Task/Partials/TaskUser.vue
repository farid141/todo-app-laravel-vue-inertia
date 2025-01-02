<script setup>

import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

const props = defineProps({
    taskUsers: {
        type: Array,
        required: true
    },
    users: {
        type: Object,
    },
    errors: {
        type: Object,
        default: () => ({})
    }
})

const emit = defineEmits(['update:taskUsers']);
function addUser() {
    const updatedUsers = [...props.taskUsers, {
        user: null,
        role: null
    }];
    emit('update:taskUsers', updatedUsers);
}

function removeUser(index) {
    const updatedUsers = [...props.taskUsers];
    updatedUsers.splice(index, 1);
    emit('update:taskUsers', updatedUsers);
}

function updateTaskUser(index, field, value) {
    const updatedUsers = [...props.taskUsers];
    updatedUsers[index][field] = value;
    emit('update:taskUsers', updatedUsers);
}

</script>

<template>
    <div class="mt-6">
        <div class="flex justify-between items-center mb-4">
            <InputLabel value="Assigned Users" />
            <PrimaryButton type="button" @click="addUser" class="px-3 py-1">
                Add User
            </PrimaryButton>
        </div>

        <div v-for="(taskUser, index) in taskUsers" :key="index" class="grid grid-cols-12 gap-4 mb-4 items-start">
            <div class="col-span-6">
                <vSelect :options="users" label="name" v-model="taskUser.user" :reduce="option => option.id" />
                <InputError :message="errors[`taskUsers.${index}.user`]" class="mt-1" />
            </div>

            <div class="col-span-4">
                <TextInput v-model="taskUser.role" label="name" class="mt-1" />
                <InputError :message="errors[`taskUsers.${index}.role`]" class="mt-1" />
            </div>

            <div class="col-span-2 flex items-center mt-1">
                <button type="button" @click="removeUser(index)" class="text-red-600 hover:text-red-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>
