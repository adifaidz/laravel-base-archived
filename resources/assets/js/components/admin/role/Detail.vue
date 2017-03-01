<template lang="html">
  <div class="panel panel-default">
    <div class="panel-body">
      <form>
        <div class="">
          <div class="form-group row">
            <label for="name" class="col-md-2 text-right">Name:</label>
            <div class="col-md-4">{{role.name}}</div>
          </div>
          <div class="form-group row">
            <label for="status" class="col-md-2 text-right">Display Name:</label>
            <div class="col-md-4">{{role.display_name}}</div>
          </div>
          <div class="form-group row">
            <label for="type" class="col-md-2 text-right">Description:</label>
            <div class="col-md-4">{{role.description}}</div>
          </div>
          <div class="form-group row">
            <label for="type" class="col-md-2 text-right">Permission:</label>
            <div class="col-md-4">
              <div class="tags" v-for="permission in role.permissions">
                {{permission.display_name}}
              </div>
            </div>
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
    role: {
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
      axios.delete(this.deleteUrl).then(
        (response) => {
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
