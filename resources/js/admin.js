import AppSidebar from './admin/components/AppSidebar'

import { openSidebar, closeSidebar, toggleSidebar } from './admin/directives/Sidebar'

const Vue = window.Vue

Vue.directive('toggle-sidebar', toggleSidebar)
Vue.directive('open-sidebar', openSidebar)
Vue.directive('close-sidebar', closeSidebar)

Vue.component('AppSidebar', AppSidebar)

new Vue({
  el: '#app'
})
