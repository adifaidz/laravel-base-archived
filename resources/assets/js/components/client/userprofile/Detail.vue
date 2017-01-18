<template lang="html">
  <div class="panel panel-default">
    <div class="panel-body">
      <form>
        <div class="">
          <div class="form-group row">
            <label for="name" class="col-md-2 text-right">First Name:</label>
            <div class="col-md-4">{{userprofile.first_name}}</div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-md-2 text-right">Last Name:</label>
            <div class="col-md-4">{{userprofile.last_name}}</div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-md-2 text-right">IC No:</label>
            <div class="col-md-4">{{userprofile.ic}}</div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-md-2 text-right">Address:</label>
            <div class="col-md-4">{{userprofile.address}}</div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-md-2 text-right">Date of Birth:</label>
            <div class="col-md-4">{{userprofile.dob}}</div>
          </div>
        </div>
      </form>
    </div>
    <div class="panel-footer text-right">
      <a :href="editUrl" class="btn btn-primary">Edit</a>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    userprofile: {
      type: Object,
      required: true
    },
    editUrl: {
      type: String,
      required: true
    },
  }
}
</script>

<style lang="css">
</style>
