<template>
  <div class="UserView">
    <UserList /> <!-- This line includes the UserList component -->
  </div>
</template>

<script>
// @ is an alias to /src
import UserList from '@/components/UserList.vue'

export default {
  name: 'UserView',
  components: {
    UserList  // Ensure this matches the import
  }
}
</script>