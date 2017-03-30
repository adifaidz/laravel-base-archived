window.toastr = require('toastr')
require('eonasdan-bootstrap-datetimepicker')
require('admin-lte')
require('admin-lte/plugins/iCheck/icheck.js')

/** Vendor Components
 */
Vue.component('vuetable', require('vuetable-2/src/components/Vuetable.vue'))
Vue.component('vuetable-pagination', require('vuetable-2/src/components/VuetablePagination.vue'))
Vue.component('vuetable-pagination-info', require('vuetable-2/src/components/VuetablePaginationInfo.vue'))
import Multiselect  from 'vue-multiselect'
Vue.component('vue-select', Multiselect )

/** Base Components
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

Vue.component('client-account-view', require('./components/client/account/Detail.vue'))
Vue.component('client-account-form', require('./components/client/account/Form.vue'))

Vue.component('admin-account-view', require('./components/admin/account/Detail.vue'))
Vue.component('admin-account-form', require('./components/admin/account/Form.vue'))

Object.defineProperty(Vue.prototype, '$eventbus', {
   get() {
       return this.$root.eventbus
   }
})

// Vue.prototype.$http = axios;
