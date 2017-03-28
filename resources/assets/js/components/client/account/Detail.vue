<template lang="html">
  <div class="panel panel-default">
    <div class="panel-body">
      <form>
        <div class="">
          <div class="form-group row">
            <label for="name" class="col-md-2 text-right">Name:</label>
            <div class="col-md-4">{{user.name}}</div>
          </div>
          <div class="form-group row">
            <label for="status" class="col-md-2 text-right">Email:</label>
            <div class="col-md-4">{{user.email}}</div>
          </div>
          <div class="form-group row">
            <label for="status" class="col-md-2 text-right">Password:</label>
            <div class="col-md-4"><a :href="changePasswordUrl" class="btn btn-primary">Change Password</a></div>
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
    user: {
      type: Object,
      required: true
    },
    editUrl: {
      type: String,
      required: true
    },
    redirectUrl: {
      type: String,
      required: true
    },
    changePasswordUrl: {
      type: String,
      required: true
    }
  }
}
</script>

<style lang="css">
  .tags{
    white-space: nowrap;
    background: #41b883;
    color: #fff;
    display: inline-block;
    padding: 2px 8px 2px 8px;
    margin: 2px;
    border-radius: 5px;
  }
</style>
