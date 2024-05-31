import { createRouter, createWebHashHistory } from 'vue-router'
import ProductView from '@/views/ProductView.vue'
import UserView from '@/views/UserView.vue'
import KioskDisplay from '@/views/KioskDisplay.vue'

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
  },
  {
    path: '/kiosk',
    name: 'Kiosk Display',
    component: KioskDisplay
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router