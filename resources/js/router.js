import { createRouter, createWebHistory } from 'vue-router'
import MerchantList from './components/MerchantList.vue'
import MerchantNotes from './components/MerchantNotes.vue'

const routes = [
    {
        path: '/',
        name: 'merchants',
        component: MerchantList
    },
    {
        path: '/merchants/:id/notes',
        name: 'merchant-notes',
        component: MerchantNotes,
        props: true
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router