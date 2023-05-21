<script setup>
    const props = defineProps(['star'])
</script>

<template>
  <div class="p-2 border rounded-md">
    <h1>
        {{ star.name }}
    </h1>
  </div>
</template>
