<script setup>
import StarCover from './StarCover.vue'
import { ref, onMounted } from 'vue'
import axios from 'axios'
import omitBy from 'lodash.omitby'
import StarForm from './StarForm.vue'
import Modal from '../Modal.vue'

const emit = defineEmits(['setShowingStar', 'editStar'])

const stars = ref(null)

const fetchStars = async () => {
  const res = await axios.get('/stars')
  stars.value = res.data
  emit('setShowingStar', stars.value[0] ?? null)
}


const setShowingStar = (starId) => {
  const starShowing = stars.value.find((star) => star.id === starId)
  emit('setShowingStar', starShowing)
}

const updateElementFromStarsList = (event) => {
  const index = stars.value.indexOf(stars.value.find((star) => star.id === event.id))
  stars.value[index] = event
}

const deleteElementFromStarsList = (event) => {
  const index = stars.value.indexOf(stars.value.find((star) => star.id === event))
  stars.value.splice(index, 1)
}

const createModal = ref(false)
const createStarForm = ref(null)
const createNewStar = () => {
  const form = omitBy(createStarForm.value, (val) => val === '' || val === null)
  axios
    .post('/stars', form)
    .then((res) => {
      stars.value.push(res.data)
      createModal.value = false
    })
    .catch((err) => {
      console.error(err)
    })
}

onMounted(() => {
  fetchStars()
})
</script>

<template>
  <div class="border rounded-md p-2">
    <div class="w-full">
      <header class="mb-2">
        <div>
          <button
            type="button"
            class="bg-blue-500 font-bold text-white button w-full"
            @click="createModal = true"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <path
                fill="white"
                d="M18 10h-4V6a2 2 0 0 0-4 0l.071 4H6a2 2 0 0 0 0 4l4.071-.071L10 18a2 2 0 0 0 4 0v-4.071L18 14a2 2 0 0 0 0-4z"
              />
            </svg>
            Ajouter une star
          </button>
        </div>
      </header>
    </div>

    <div class="grid grid-cols-1 gap-2 max-h-[48rem]">
      <StarCover
        v-for="star in stars"
        v-bind:key="star.id"
        :star="star"
        @set-showing-star="setShowingStar"
        @updated="updateElementFromStarsList"
        @deleted="deleteElementFromStarsList"
      />
    </div>

    <Modal v-if="createModal" :isShowing="createModal" :title="'Ajouter une star'">
      <template #content>
        <StarForm @on-change="createStarForm = $event" />
      </template>
      <template #buttons>
        <button type="button" class="button font-bold text-white bg-primary" @click="createNewStar">
          Valider
        </button>
        <button
          type="button"
          class="button font-bold text-white bg-gray-300"
          @click="createModal = false"
        >
          Annuler
        </button>
      </template>
    </Modal>
  </div>
</template>
