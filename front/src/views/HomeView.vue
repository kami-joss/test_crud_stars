<script setup>
import StarsList from '../components/stars/StarsList.vue'
import StarCard from '../components/stars/StarCard.vue'
import { ref } from 'vue'
import Modal from '../components/Modal.vue'

const showingStar = ref(null)
</script>

<template>
  <main>
    <div class="grid grid-cols-12 w-full gap-2">
      <StarCard v-if="showingStar" :star="showingStar" class="hidden sm:block col-span-8" />
      <StarsList @set-showing-star="showingStar = $event" class="sm:col-span-3 col-span-12" />
    </div>

    <Modal :is-showing="showingStar ? true : false" class="h-screen sm:hidden">
      <template #content>
        <StarCard v-if="showingStar" :star="showingStar" class="sm:hidden col-span-8" />
      </template>
      <template #buttons>
        <button class="button bg-primary text-white font-bold" @click="showingStar = null"> Fermer </button>
      </template>
    </Modal>
  </main>
</template>
