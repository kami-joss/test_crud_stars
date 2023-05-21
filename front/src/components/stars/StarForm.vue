<script setup>
import { reactive, watch } from 'vue'

const props = defineProps({
  star: Object
})

const form = reactive({
  name: props.star?.name ?? '',
  firstname: props.star?.firstname ?? '',
  description: props.star?.description ?? '',
  image: null
})

const errors = reactive({
  name: null,
  firstname: null,
  description: null,
  image: null
})

const emit = defineEmits(['onChange'])

watch(form, async (val) => {
  emit('onChange', val)
})
</script>

<template>
  <div>
    <form class="flex flex-col gap-2">
      <input
        class="input-text"
        :class="{
          'border-error': errors.name
        }"
        placeholder="Nom*"
        @change="form.name = $event.target.value"
        @focus="errors.name = null"
        @blur="
          form.name === '' ? (errors.name = 'Ce champs est obligatoire') : (errors.name = null)
        "
      />
      <span v-if="errors.name" class="text-error"> Ce champs est requis </span>
      <input
        class="input-text"
        :class="{
          'border-error': errors.firstname
        }"
        placeholder="Prénom*"
        @change="form.firstname = $event.target.value"
        @focus="errors.firstname = null"
        @blur="
          form.firstname === ''
            ? (errors.firstname = 'Ce champs est obligatoire')
            : (errors.firstname = null)
        "
      />
      <span v-if="errors.firstname" class="text-error"> Ce champs est requis </span>
      <textarea
        class="input-textarea resize-none h-32"
        placeholder="Description"
        @change="form.description = $event.target.value"
      />
    </form>
  </div>
</template>
