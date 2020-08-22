import { VLazyImagePlugin } from 'v-lazy-image'


import Sticky from 'vue-sticky-directive'
import { openSidebar, closeSidebar, toggleSidebar } from './directives/Sidebar'
import DeleteConfirm from './directives/delete-confirm'


import StarRating from 'vue-star-rating'
import AvatarChooser from './components/avatar-chooser'
import HeroChooser from './components/HeroChooser'
import AppSidebar from './components/AppSidebar'
import AppAlert from './components/AppAlert'
import CategoryAutocomplete from './components/CategoryAutocomplete'
import VideoOrder from './components/VideoOrder'
import AppEditorjs from './components/AppEditorjs'


Vue.use(VLazyImagePlugin)


Vue.directive('Sticky', Sticky)
Vue.directive('toggle-sidebar', toggleSidebar)
Vue.directive('open-sidebar', openSidebar)
Vue.directive('close-sidebar', closeSidebar)
Vue.directive('delete-confirm', DeleteConfirm)


Vue.component('StarRating', StarRating)
Vue.component('AvatarChooser', AvatarChooser)
Vue.component('HeroChooser', HeroChooser)
Vue.component('AppSidebar', AppSidebar)
Vue.component('AppAlert', AppAlert)
Vue.component('CategoryAutocomplete', CategoryAutocomplete)
Vue.component('VideoOrder', VideoOrder)
Vue.component('AppEditorjs', AppEditorjs)


new Vue({
  el: '#app'
})
