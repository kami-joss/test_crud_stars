<script setup>
import axios from 'axios'
import { ref } from 'vue'
import Modal from '../Modal.vue'
import StarForm from './StarForm.vue'
import { formatObjectAsFormData } from '../../utils/request.utils'
import omitBy from 'lodash.omitby'

const props = defineProps({
  star: Object
})

const editModal = ref(false)
const deleteModal = ref(false)
const editStarForm = ref({
  name: props.star.name,
  firstname: props.star.firstname,
  description: props.star.description,
  images: props.star.images[0] ?? null
})
const isFetching = ref(false)

const emit = defineEmits(['setShowingStar', 'updated', 'deleted', 'imageDeleted'])

const updateStar = () => {
  let form = omitBy(editStarForm.value, (val) => val === '' || val === null)
  let formData = formatObjectAsFormData(form)
  formData.append('_method', 'PUT')
  if(form.images) {
    formData.append('images', form.images[0])
  }

  axios
    .post(`stars/${props.star.id}`, formData)
    .then((res) => {
      isFetching.value = false
      emit('updated', res.data)
      editModal.value = false
    })
    .catch(() => {
      isFetching.value = false
    })
}

const deleteStar = () => {
  isFetching.value = false
  axios
    .delete(`stars/${props.star.id}`)
    .then(() => {
      emit('deleted', props.star.id)
      isFetching.value = false
      deleteModal.value = false
    })
    .catch(() => {
      isFetching.value = false
      deleteModal.value = false
    })
}

const onDeleteImage = (event) => {
  emit('imageDeleted', event)
}
</script>

<template>
  <div
    class="border rounded-md hover:bg-slate-100 cursor-pointer flex justify-between items-center gap-2"
    @click="emit('setShowingStar', star.id)"
  >
    <div class="p-2">
      <h2>{{ star.firstname }} {{ star.name }}</h2>
    </div>

    <!-- Actions buttons -->
    <div class="grid grid-cols-2 gap-2 items-center">
      <div
        class="flex justify-center hover:bg-gray-300 hover:rounded-full duration-200 p-2"
        @click.stop="editModal = true"
      >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20">
          <g fill="currentColor">
            <path
              fill-rule="evenodd"
              d="M13.198 1.22L3.12 11.298a1 1 0 0 0-.282.555l-.705 4.594a1 1 0 0 0 1.14 1.14l4.595-.705a1 1 0 0 0 .555-.281L18.501 6.523a1 1 0 0 0 0-1.414l-3.89-3.89a1 1 0 0 0-1.413 0ZM4.317 15.404l.448-2.924l9.14-9.14l2.475 2.476l-9.14 9.14l-2.923.448Z"
              clip-rule="evenodd"
            />
            <path d="m11.442 5.247l1.06-1.061l3.242 3.24l-1.061 1.061l-3.241-3.24Z" />
          </g>
        </svg>
      </div>

      <div
        class="flex justify-center hover:bg-gray-300 hover:rounded-full duration-200 p-2"
        @click.stop="deleteModal = true"
      >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
          <path
            fill="currentColor"
            d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"
          />
        </svg>
      </div>
    </div>

    <!-- Modales -->
    <Modal v-if="editModal" :isShowing="editModal" :title="'Modifier une star'">
      <template #content>
        <StarForm :star="star" @on-change="editStarForm = $event" @onDeleteImage="onDeleteImage" />
      </template>
      <template #buttons>
        <button type="button" class="button font-bold text-white bg-primary" @click="updateStar">
          Valider
        </button>
        <button
          type="button"
          class="button font-bold text-white bg-gray-300"
          @click="editModal = false"
        >
          Fermer
        </button>
      </template>
    </Modal>

    <Modal v-if="deleteModal" :isShowing="deleteModal" :title="'Supprimer une star'">
      <template #content>
        <p>Attention ! Êtes-vous sûr de vouloir supprimer {{ star.firstname }} {{ star.name }} ?</p>
      </template>
      <template #buttons>
        <button
          type="button"
          class="button font-bold text-white bg-primary"
          :disabled="isFetching"
          @click.stop="deleteStar"
        >
          Valider
        </button>
        <button
          type="button"
          class="button font-bold text-white bg-gray-300"
          :disabled="isFetching"
          @click="deleteModal = false"
        >
          Annuler
        </button>
      </template>
    </Modal>
  </div>
</template>
