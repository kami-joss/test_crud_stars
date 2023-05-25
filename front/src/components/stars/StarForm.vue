<script setup>
import { reactive, watch } from 'vue'
import axios from 'axios';

const props = defineProps({
  star: Object
})

const form = reactive({
  name: props.star?.name ?? '',
  firstname: props.star?.firstname ?? '',
  description: props.star?.description ?? '',
  images: props.star?.images ?? []
})

const errors = reactive({
  name: null,
  firstname: null,
  description: null,
  images: null
})

const emit = defineEmits(['onChange', 'onDeleteImage']);

const deleteImage = () => {
  axios.delete(`/images/${props.star.images[0].id}`)
  .then(() => {
    form.images = []
    emit('onDeleteImage', props.star.id)
  })
  .catch((err) => {
    console.log(err)
  })
}

watch(form, (val) => {
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
        :value="form.name"
        @input="form.name = $event.target.value"
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
        :value="form.firstname"
        @input="form.firstname = $event.target.value"
        @focus="errors.firstname = null"
        @blur="
          form.firstname === ''
            ? (errors.firstname = 'Ce champs est obligatoire')
            : (errors.firstname = null)
        "
      />
      <span v-if="errors.firstname" class="text-error"> Ce champs est requis </span>

      <input v-if="!form.images || form.images.length === 0" type="file" @change="form.images[0] = $event.target.files[0]" />
      <div v-else>
        <img :src="'http://localhost:8000' + form.images[0]?.path" width="300" />
        <button type="button" class="button bg-red-500 text-white my-2" @click="deleteImage"> Supprimer </button>
      </div>

      <textarea
        class="input-textarea resize-none h-32"
        placeholder="Description"
        :value="form.description"
        @input="form.description = $event.target.value"
      />
    </form>
  </div>
</template>
