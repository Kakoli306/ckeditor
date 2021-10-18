import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
import home from './components/pages/home'
import tags from './components/pages/tags'
// import newRoutePage from './components/pages/newRoutePage'

const routes = [
    {
        path: '/',
        component: home,
    },
    {
        path: '/tags',
        component: tags,
    },
   
]

    export default new Router({
        mode: 'history',
        routes
    })
