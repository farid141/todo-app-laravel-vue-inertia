<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

const props = defineProps({
  formUsers: {
    type: Array,
    required: true,
  },
  users: {
    type: Object,
  },
  errors: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(["update:formUsers"]);
function addUser() {
  const updatedUsers = [
    ...props.formUsers,
    {
      user: null,
      role: null,
    },
  ];
  emit("update:formUsers", updatedUsers);
}

function removeUser(index) {
  const updatedUsers = [...props.formUsers];
  updatedUsers.splice(index, 1);
  emit("update:formUsers", updatedUsers);
}

function updateTaskUser(index, field, value) {
  const updatedUsers = [...props.formUsers];
  updatedUsers[index][field] = value;
  emit("update:formUsers", updatedUsers);
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

    <div
      v-for="(formUser, index) in formUsers"
      :key="index"
      class="grid grid-cols-12 gap-4 mb-4 items-center"
    >
      <div class="col-span-6">
        <vSelect
          :options="users"
          label="name"
          v-model="formUser.user"
          :reduce="(option) => option.id"
        />
        <InputError :message="errors[`formUsers.${index}.user`]" class="mt-1" />
      </div>

      <div class="col-span-4">
        <TextInput v-model="formUser.role" label="name" class="mt-1" />
        <InputError :message="errors[`formUsers.${index}.role`]" class="mt-1" />
      </div>

      <div class="col-span-2 flex items-center mt-1 justify-center text-xl">
        <button
          type="button"
          @click="removeUser(index)"
          class="text-red-600 hover:text-red-800"
        >
          <BIconTrash />
        </button>
      </div>
    </div>
  </div>
</template>
