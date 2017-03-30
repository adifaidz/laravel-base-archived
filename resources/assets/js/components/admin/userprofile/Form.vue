<template lang="html">
  <form>
    <div class="form-group">
      <label for="first_name">First Name</label>
      <input v-model="userprofile.first_name" class="form-control" type="text" id="first_name" name="first_name" placeholder="First Name">
    </div>
    <div class="form-group">
      <label for="last_name">Last Name</label>
      <input v-model="userprofile.last_name" class="form-control" type="text" id="last_name" name="last_name" placeholder="Last Name">
    </div>
    <div class="form-group">
      <label for="ic">IC No</label>
      <input v-model="userprofile.ic" class="form-control" type="text" id="ic" name="ic" placeholder="IC No">
    </div>
    <div class="form-group">
      <label for="address">Address</label>
      <textarea v-model="userprofile.address" class="form-control" type="text" id="address" name="address" placeholder="Address"></textarea>
    </div>
    <div class="form-group">
      <label for="dob">Date of Birth</label>
      <datetimepicker v-model="userprofile.dob" input-name="dob" placeholder="Date of Birth"></datetimepicker>
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
    userprofile: {
      type: Object,
      required: false,
      default: function(){
        return {}
      }
    },
  },
  mounted: function(){
    var hiddenMethod = document.getElementsByName('_method')[0]

    if(hiddenMethod.value == "put"){this.$el.method = 'post'}
  }
}
</script>

<style lang="css">
</style>
