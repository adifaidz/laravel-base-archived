<template lang="html">
  <div>
    <div class="row" style="margin-bottom: 15px;">
      <div class="col-md-5" v-if="searchable">
        <div class="input-group">
          <input class="form-control" type="text" v-model="searchFor" value="" >
          <span class="input-group-btn">
            <button class="btn btn-default" type="button" @click="setFilter">Search</button>
          </span>
        </div>
      </div>
      <div :class="[{'col-md-2 col-md-offset-5': searchable}, {'col-md-12': !searchable}]">
        <slot name="table-top-right"></slot>
      </div>
    </div>
    <div class="row">
      <div :class="[{'vuetable-wrapper': true}, {'col-md-12': true}, loading]">
         <vuetable ref="vuetable"
            :api-url="apiUrl"
            :fields="columns"
            pagination-path=""
            :sort-order="sortOrder"
            :multi-sort="multiSort"
            :per-page="perPage"
            :append-params="moreParams"
            @vuetable:pagination-data="onPaginationData"
            @vuetable:loading="showLoader"
            @vuetable:loaded="hideLoader"
            @vuetable:cell-clicked="onCellClicked"
            @vuetable:cell-dblclicked="onCellDoubleClicked"
            row-class-callback="rowClassCB"
            :css="cssClasses"
          ></vuetable>

          <div class="vuetable-pagination">

            <vuetable-pagination-info ref="paginationInfo"
              :pagination-info-template="paginationInfoTemplate"
              paginationInfoNoDataTemplate="No record found"
              paginationInfoClass=""
            ></vuetable-pagination-info>

            <div class="pull-right">
              <component :is="paginationComponent" ref="pagination"
                :css="cssPaginationClasses"
                :icons="icons"
                @vuetable-pagination:change-page="onChangePage"
              ></component>
            </div>

          </div>

     </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    apiUrl: {
      type: String,
      required: true
    },
    columns: {
      type: Array,
      required: true
    },
    sortOrder: {
      type: Array,
      required: true
    },
    searchable: {
      type: Boolean,
      required: false,
      default: true
    }
  },
  data () {
    return {
      loading: '',
      searchFor: '',
      moreParams: {},
      multiSort: true,
      perPage: 10,
      paginationInfoTemplate: 'Showing record: {from} to {to} from {total} item(s)',
      paginationComponent: 'vuetable-pagination',
      cssClasses: {
        ascendingIcon: 'fa fa-chevron-up',
        descendingIcon: 'fa fa-chevron-down',
        loading: 'progress-bar',
        tableClass: 'table table-bordered table-hovered'
      },
      cssPaginationClasses: {
        activeClass: "active",
        disabledClass: "disabled",
        wrapperClass: 'pagination ',
        pageClass: 'btn btn-default btn-sm',
        linkClass: 'btn btn-default btn-sm'

      },
      icons: {
        first: "fa fa-backward",
        last: "fa fa-forward",
        next: "fa fa-caret-right large",
        prev: "fa fa-caret-left large",
      }
    }
  },
  methods: {
    showLoader: function() {
      this.loading = 'loading'
    },
    hideLoader: function() {
      this.loading = ''
    },
    setFilter: function() {
      this.moreParams = {
        'filter': this.searchFor
      }

      this.$nextTick(function() {
        this.$refs.vuetable.refresh()
      })
    },
    onLoadSuccess (response) {
      // set pagination data to pagination-info component
      this.$refs.paginationInfo.setPaginationData(response.data)

      let data = response.data.data
      if (this.searchFor !== '') {
        for (let n in data) {
          data[n].name = this.highlight(this.searchFor, data[n].name)
          data[n].email = this.highlight(this.searchFor, data[n].email)
        }
      }
    },
    onLoadError (response) {
      if (response.status == 400) {
        sweetAlert('Something\'s Wrong!', response.data.message, 'error')
      } else {
        sweetAlert('Oops', E_SERVER_ERROR, 'error')
      }
    },
    onPaginationData (tablePagination) {
      this.$refs.paginationInfo.setPaginationData(tablePagination)
      this.$refs.pagination.setPaginationData(tablePagination)
    },
    onChangePage (page) {
      this.$refs.vuetable.changePage(page)
    },
    resetFilter: function() {
      this.searchFor = ''
      this.setFilter()
    },
    rowClassCB: function(data, index) {
      return (index % 2) === 0 ? 'odd' : 'even'
    },
    onCellClicked (data, field, event) {
      if (field.name !== '__actions') {
      }
    },
    onCellDoubleClicked (data, field, event) {

    },
    registerEvents () {
      let self = this
      this.$on('vuetable:action', (action, data) => {
        self.onActions(action, data)
      })
      this.$on('vuetable:cell-clicked', (data, field, event) => {
        self.onCellClicked(data, field, event)
      })
      this.$on('vuetable:cell-dblclicked', (data, field, event) => {
        self.onCellDoubleClicked(data, field, event)
      })
      this.$on('vuetable:load-success', (response) => {
        self.onLoadSuccess(response)
      })
      this.$on('vuetable:load-error', (response) => {
        self.onLoadError(response)
      })
    }
  },
  watch: {
    'perPage' (val, oldVal) {
      this.$nextTick(function() {
        this.$refs.vuetable.refresh()
      })
    },
    'paginationComponent' (val, oldVal) {
      this.$nextTick(function() {ss
        this.$refs.pagination.setPaginationData(this.$refs.vuetable.tablePagination)
      })
    }
  },
  created () {
    this.registerEvents()
  },
}
</script>

<style lang="css">
</style>
