<script setup>
import StarsList from '../components/stars/StarsList.vue'
import StarCard from '../components/stars/StarCard.vue'
import { ref } from 'vue'

const showingStar = ref(null)
</script>

<template>
  <main>
    <div class="grid grid-cols-12 w-full gap-2">
      <StarCard v-if="showingStar" :star="showingStar" class="col-span-8" />
      <StarsList @set-showing-star="showingStar = $event" class="col-span-3" />
    </div>
  </main>
</template>
