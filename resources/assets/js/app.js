require('./bootstrap');

 /** Vendor
  */
Vue.component('vuetable', require('vuetable-2/src/components/Vuetable.vue'))
Vue.component('vuetable-pagination', require('vuetable-2/src/components/VuetablePagination.vue'))
Vue.component('vuetable-pagination-info', require('vuetable-2/src/components/VuetablePaginationInfo.vue'))
import Multiselect  from 'vue-multiselect'
Vue.component('vue-select', Multiselect )

 /** Custom
  */

Vue.component('datetimepicker', require('./components/base/DateTimePicker.vue'))

Vue.component('base-table', require('./components/base/Table.vue'))
Vue.component('base-actions', require('./components/base/Action.vue'))
Vue.component('generic-table', require('./components/base/GenericTable.vue'))

Vue.component('admin-role-view', require('./components/admin/role/Detail.vue'))
Vue.component('admin-role-form', require('./components/admin/role/Form.vue'))

Vue.component('admin-permission-view', require('./components/admin/permission/Detail.vue'))
Vue.component('admin-permission-form', require('./components/admin/permission/Form.vue'))

Vue.component('admin-user-view', require('./components/admin/user/Detail.vue'))
Vue.component('admin-user-form', require('./components/admin/user/Form.vue'))

Vue.component('client-userprofile-view', require('./components/client/userprofile/Detail.vue'))
Vue.component('client-userprofile-form', require('./components/client/userprofile/Form.vue'))

Vue.component('admin-userprofile-view', require('./components/admin/userprofile/Detail.vue'))
Vue.component('admin-userprofile-form', require('./components/admin/userprofile/Form.vue'))

Object.defineProperty(Vue.prototype, '$eventbus', {
    get() {
        return this.$root.eventbus;
    }
})

const app = new Vue({
    el: '.app-content',
    data(){
      return{
        params: function(){
          if(params !== undefined)
            return params
          return []
        },
        eventbus: new Vue(),
      }
    },
    methods:{
      get: function(name){
        return params[name]
      }
    },
});
