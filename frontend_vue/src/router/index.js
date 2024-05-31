import { createRouter, createWebHashHistory } from 'vue-router'
import ProductView from '@/views/ProductView.vue'
import UserView from '@/views/UserView.vue'

const routes = [
  {
    path: '/products',
    name: 'Product List',
    component: ProductView
  },
  {
    path: '/user',
    name: 'User List',
    component: UserView
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router