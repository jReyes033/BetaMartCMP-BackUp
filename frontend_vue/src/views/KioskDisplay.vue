<template>
    <div class="KioskView">
      <KioskDisplay />
    </div>
  </template>
  
  <script>
  import KioskDisplay from '@/components/KioskDisplay.vue'
  
  export default {
    name: 'KioskView',
    components: {
      KioskDisplay
    }
  }
  </script>
  