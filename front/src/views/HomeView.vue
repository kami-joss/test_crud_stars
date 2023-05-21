<script setup>
import StarsList from '../components/stars/StarsList.vue'
import StarCard from '../components/stars/StarCard.vue'
import Modal from '../components/Modal.vue'
import { ref } from 'vue'
import StarForm from '../components/stars/StarForm.vue'
import axios from 'axios'
import omitBy from 'lodash.omitby'

const showingStar = ref(null)
const createModal = ref(false)

const createStarForm = ref(null)
const createNewStar = () => {
  const form = omitBy(createStarForm.value, (val) => val === '' || val === null)
  axios
    .post('/stars', form)
    .then((res) => {
      console.log(res)
    })
    .catch((err) => {
      console.log(err)
    })
}
</script>

<template>
  <main>
    <header class="mb-2">
      <div>
        <button
          type="button"
          class="bg-blue-500 font-bold text-white button"
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

    <Modal v-if="createModal" :isShowing="createModal" :title="'Ajouter une star'">
      <template #content>
        <StarForm @on-change="createStarForm = $event" />
      </template>
      <template #buttons>
        <button type="button" class="button font-bold text-white bg-primary" @click="createNewStar">Valider</button>
        <button type="button" class="button font-bold text-white bg-gray-300" @click="createModal = false">Annuler</button>
      </template>
    </Modal>

    <div class="grid grid-cols-12 w-full gap-2">
      <StarCard v-if="showingStar" :star="showingStar" class="col-span-8" />
      <StarsList @set-showing-star="showingStar = $event" class="col-span-3" />
    </div>
  </main>
</template>
