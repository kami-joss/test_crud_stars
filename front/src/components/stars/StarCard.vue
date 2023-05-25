<script setup>
const props = defineProps(['star'])
</script>

<template>
  <div class="p-2 border rounded-md">
    <div v-if="star.images?.length > 0">
      <img :src="'http://localhost:8000' + star.images[0]?.path" width="300" />
    </div>
    <h1 class="font-bold">{{ star.firstname }} {{ star.name }}</h1>
    <p>
      {{ star.description }}
    </p>
  </div>
</template>
