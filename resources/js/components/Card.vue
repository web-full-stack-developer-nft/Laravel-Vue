<template>
  <div class="card">
    <div v-if="title" class="text-4xl my-3 text-gray-900">
      {{ title }}
    </div>

    <div class="card-body">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',

  props: {
    title: { type: String, default: null }
  }
}
</script>
