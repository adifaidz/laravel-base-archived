<template lang="html">
  <div class="panel panel-default">
    <div class="panel-body">
      <form>
        <div class="">
          <div class="form-group row">
            <label for="name" class="col-md-2 text-right">Name:</label>
            <div class="col-md-4">{{permission.name}}</div>
          </div>
          <div class="form-group row">
            <label for="status" class="col-md-2 text-right">Display Name:</label>
            <div class="col-md-4">{{permission.display_name}}</div>
          </div>
          <div class="form-group row">
            <label for="type" class="col-md-2 text-right">Description:</label>
            <div class="col-md-4">{{permission.description}}</div>
          </div>
        </div>
      </form>
    </div>
    <div class="panel-footer text-right">
      <a :href="editUrl" class="btn btn-primary">Edit</a>
      <button type="button" class="btn btn-danger" @click="deleteData">Delete</button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    permission: {
      type: Object,
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
    redirectUrl: {
      type: String,
      required: true
    }
  },
  methods: {
    deleteData: function(){
      this.$http.delete(this.deleteUrl).then(
        (response) => {
          console.log(response);
          window.location.href = this.redirectUrl
        },
        (response) => {
          console.log(response);
        }
      )
    }
  }
}
</script>

<style lang="css">
</style>
