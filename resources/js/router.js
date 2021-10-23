import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
import home from './components/pages/home'
import tags from './admin/pages/tags'
import category from './admin/pages/category'

// import newRoutePage from './components/pages/newRoutePage'

const routes = [
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
   
]

    export default new Router({
        mode: 'history',
        routes
    })
