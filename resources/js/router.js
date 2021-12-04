import Vue from 'vue'
import Router from 'vue-router'
import usecom from './vuex/usecom'

Vue.use(Router)
import home from './components/pages/home'
import tags from './admin/pages/tags'
import category from './admin/pages/category'
import adminusers from './admin/pages/adminusers'

// import newRoutePage from './components/pages/newRoutePage'

const routes = [
    {
        path: '/testvuex',
        component: usecom,
       
    },
    {
        path: '/',
        component: home,
       
    },
    {
        path: '/tags',
        component: tags,
        name: 'tags'
    },

    {
        path: '/category',
        component: category,
        name: 'category'
    },
    {
        path: '/adminusers',
        component: adminusers,
        name: 'adminusers'
    },
   
]

    export default new Router({
        mode: 'history',
        routes
    })
