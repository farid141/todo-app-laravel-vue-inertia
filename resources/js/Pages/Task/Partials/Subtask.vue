<script setup>
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

const props = defineProps({
    subtasks: {
        type: Array,
        required: true
    },
    tags: {
        type: Array,
        required: true
    }
})

const emit = defineEmits(['update:subtasks'])

const addSubtask = () => {
    const updatedSubtasks = [...props.subtasks, {
        title: '',
        tags: []
    }]
    emit('update:subtasks', updatedSubtasks)
}

const removeSubtask = (index) => {
    const updatedSubtasks = props.subtasks.filter((_, i) => i !== index)
    emit('update:subtasks', updatedSubtasks)
}

const updateSubtask = (index, field, value) => {
    const updatedSubtasks = [...props.subtasks]
    updatedSubtasks[index] = {
        ...updatedSubtasks[index],
        [field]: value
    }
    emit('update:subtasks', updatedSubtasks)
}

</script>

<template>
    <div class="subtask-data">
        <div class="flex justify-between">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Subtask</h3>
            <!-- Add Subtask Button -->
            <button @click="addSubtask" type="button"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Add Subtask
            </button>
        </div>
        <!-- Subtask Table -->
        <div class="border rounded-lg">
            <!-- Table Header -->
            <div class="bg-gray-50 px-4 py-3 grid grid-cols-12 gap-4 border-b">
                <div class="col-span-5 font-medium text-gray-700">Title</div>
                <div class="col-span-5 font-medium text-gray-700">Tag</div>
                <div class="col-span-2 font-medium text-gray-700">Action</div>
            </div>

            <!-- Subtask List -->
            <div v-for="(subtask, index) in subtasks" :key="index" class="px-4 py-3 grid grid-cols-12 gap-4 border-b">
                <div class="col-span-5">
                    <TextInput type="text" class="block w-full" v-model="subtask.title"
                        :placeholder="'Subtask ' + (index + 1) + ' title'" />
                </div>
                <div class="col-span-5">
                    <vSelect :options="tags" label="name" v-model="subtask.tags" multiple="true"
                        :reduce="option => option.id" />
                </div>
                <div class="col-span-2">
                    <button @click="removeSubtask(index)" type="button"
                        class="inline-flex items-center px-3 py-2 border border-red-300 rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Remove
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
