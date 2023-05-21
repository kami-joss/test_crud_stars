<script setup>
import StarCover from './StarCover.vue'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const stars = ref(null)

const fetchStars = async () => {
  const res = await axios.get('/stars')
  stars.value = res.data
}

const emit = defineEmits(['setShowingStar'])

const setShowingStar = (starId) => {
  const starShowing = stars.value.find((star) => star.id === starId)
  emit('setShowingStar', starShowing)
}

onMounted(() => {
  fetchStars()
})
</script>

<template>
  <div class="grid grid-cols-1 gap-2 p-2 border rounded-md max-h-[48rem]">
    <StarCover
      v-for="star in stars"
      v-bind:key="star.id"
      :star="star"
      @set-showing-star="setShowingStar"
    />
  </div>
</template>
