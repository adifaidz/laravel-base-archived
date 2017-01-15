<template lang="html">
  <div class="btn-group" role="group" aria-label="...">
    <a @click="onShow(rowData)" class="btn btn-info"><i class="fa fa-info"></i>&nbsp;Detail</a>
    <a @click="onEdit(rowData)" class="btn btn-primary"><i class="fa fa-edit"></i>&nbsp;Edit</a>
    <a @click="onDelete(rowData)" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Delete</a>
  </div>
</template>

<script>
export default {
  props: {
    rowData: {
      type: Object,
      required: true
    }
  },
  methods: {
    onShow: function(data) {
      this.$eventbus.$emit('action_show', data)
    },
    onEdit: function(data) {
      this.$eventbus.$emit('action_edit', data)
    },
    onDelete: function(data) {
      data.vuetable = this.$parent
      this.$eventbus.$emit('action_delete', data)
    }
  }
}
</script>

<style lang="css">
</style>
