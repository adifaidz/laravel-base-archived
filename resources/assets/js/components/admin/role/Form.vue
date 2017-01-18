<template lang="html">
  <form @submit="onSubmit">
    <div class="form-group">
      <label for="name">Name</label>
      <input v-model="role.name" class="form-control" type="text" id="name" name="name" placeholder="Name">
    </div>
    <div class="form-group">
      <label for="status">Display Name</label>
      <input v-model="role.display_name" class="form-control" type="text" id="display_name" name="display_name" placeholder="Display name">
    </div>
    <div class="form-group">
      <label for="type">Description</label>
      <input v-model="role.description" class="form-control" type="text" id="description" name="description" placeholder="Description">
    </div>
    <div class="form-group">
      <label for="permission">Role</label>
      <vue-select
        v-model="role.permissions"
        :options="permissions"
        :multiple="true"
        :close-on-select="false"
        :clear-on-select="false"
        :hide-selected="true"
        placeholder="Assign a permission"
        label="display_name"
        track-by="id"
        >
      </vue-select>
    </div>
    <div class="form-group">
      <slot></slot>
      <input type="hidden" id="permissions" name="permissions">
      <input class="btn btn-primary" type="submit" name="submit" value="Save">
    </div>
  </form>
</template>

<script>
export default {
  props:{
    role: {
      type: Object,
      required: false,
      default: function(){
        return {}
      }
    },
    permissions: {
      type: Array,
      required: true,
    }
  },
  mounted: function(){
    var hiddenMethod = document.getElementsByName('_method')[0]

    if(hiddenMethod.value == "put"){this.$el.method = 'post'}
  },
  methods: {
    onSubmit: function(e){
      console.log("IN");
      $('#permissions').val("[" + _.map(this.role.permissions, _.property('id')) + "]");
    }
  }
}
</script>

<style lang="css">
</style>
