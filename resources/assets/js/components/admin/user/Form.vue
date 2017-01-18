<template lang="html">
  <form @submit="onSubmit">
    <div class="form-group">
      <label for="name">Name</label>
      <input v-model="user.name" class="form-control" type="text" id="name" name="name" placeholder="Name">
    </div>
    <div class="form-group">
      <label for="status">Email</label>
      <input v-model="user.email" class="form-control" type="text" id="email" name="email" placeholder="Email">
    </div>
    <div class="form-group">
      <label for="role">Role</label>
      <vue-select
        v-model="user.roles"
        :options="roles"
        :multiple="true"
        :close-on-select="false"
        :clear-on-select="false"
        :hide-selected="true"
        placeholder="Assign a role"
        label="display_name"
        track-by="id"
        >
      </vue-select>
    </div>
    <div class="form-group">
      <slot></slot>
      <input type="hidden" id="roles" name="roles">
      <input class="btn btn-primary" type="submit" name="submit" value="Save">
    </div>
  </form>
</template>

<script>
export default {
  props:{
    user: {
      type: Object,
      required: false,
      default: function(){
        return {}
      }
    },
    roles: {
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
      $('#roles').val("[" + _.map(this.user.roles, _.property('id')) + "]");
    }
  }
}
</script>

<style lang="css">
</style>
