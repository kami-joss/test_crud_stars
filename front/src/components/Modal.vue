<script setup>
const props = defineProps({
  isShowing: Boolean,
  title: String
})

</script>

<template>
  <div
    v-if="isShowing"
    class="relative z-10"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
        <div
          class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
        >
          <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <div v-if="title" class="p-2 my-2 w-full text-gray-600">
              <span class="font-bold text-xl"> {{ title }}</span>
            </div>
            <slot name="content" />
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
            <slot name="buttons" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
