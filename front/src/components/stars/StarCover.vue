<script setup>
const props = defineProps({
  star: Object
})

const emit = defineEmits(['setShowingStar'])
</script>

<template>
  <div
    class="p-2 border rounded-md hover:bg-slate-100 cursor-pointer flex justify-between gap-2"
    @click="emit('setShowingStar', star.id)"
  >
    <h2>{{ star.firstname }} {{ star.name }}</h2>
    <div class="grid grid-cols-2">
      <div class="flex justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 20 20">
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
      <div class="flex justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
          <path
            fill="currentColor"
            d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"
          />
        </svg>
      </div>
    </div>
  </div>
</template>