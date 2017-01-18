<template lang="html">
  <form>
    <div class="form-group">
      <label for="name">Name</label>
      <input v-model="permission.name" class="form-control" type="text" id="name" name="name">
    </div>
    <div class="form-group">
      <label for="status">Display Name</label>
      <input v-model="permission.display_name" class="form-control" type="text" id="display_name" name="display_name">
    </div>
    <div class="form-group">
      <label for="type">Description</label>
      <input v-model="permission.description" class="form-control" type="text" id="description" name="description">
    </div>
    <div class="form-group">
      <slot></slot>
      <input class="btn btn-primary" type="submit" name="submit" value="Save">
    </div>
  </form>
</template>

<script>
export default {
  props:{
    permission: {
      type: Object,
      required: false,
      default: function(){
        return {}
      }
    }
  },
  mounted: function(){
    var hiddenMethod = document.getElementsByName('_method')[0]

    if(hiddenMethod.value == "put"){this.$el.method = 'post'}
  }
}
</script>

<style lang="css">
</style>
