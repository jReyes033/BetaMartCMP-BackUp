<template>
    <div class="ProductView">
      <ProductList /> <!-- This line includes the ProductList component -->
    </div>
  </template>
  
  <script>
  // @ is an alias to /src
  import ProductList from '@/components/ProductList.vue'
  
  export default {
    name: 'ProductView',
    components: {
      ProductList
    }
  }
  </script>
  