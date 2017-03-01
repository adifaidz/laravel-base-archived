<template lang="html">
  <div ref="main">
    <base-table ref="table"
      :api-url = "apiUrl"
      :columns="columns"
      :sortOrder="sortOrder"
    >
    <div slot="table-top-right" class="btn-group pull-right" role="group" aria-label="...">
      <a :href="createUrl" class="btn btn-primary">Create</a>
    </div>
    </base-table>
  </div>
</template>

<script>
export default {
  props: {
    apiUrl: {
      type: String,
      required: true
    },
    createUrl: {
      type: String,
      required: true
    },
    showUrl: {
      type: String,
      required: true
    },
    editUrl: {
      type: String,
      required: true
    },
    deleteUrl: {
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
    }
  },
  methods: {
    registerEvents : function() {
      var self = this

      this.$eventbus.$on('action_show', function(data){
        window.location.href = self.showUrl + '/' + data.id
      })

      this.$eventbus.$on('action_edit', function(data){
        window.location.href = self.editUrl + '/' + data.id
      })

      this.$eventbus.$on('action_delete', function(data){
        axios.delete(self.deleteUrl + '/' + data.id).then(
          (response) => {
            if(self.redirectUrl !== undefined)
              window.location.href = self.redirectUrl

            data.vuetable.refresh();
          },
          (response) => {

          }
        )
      })
    }
  },
  created(){
    this.registerEvents()
  }
}
</script>

<style lang="css">
</style>
