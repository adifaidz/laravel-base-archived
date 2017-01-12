<template lang="html">
  <div class='input-group date' ref="datetimepicker">
    <input
      v-model="date"
      type='text'
      class="form-control"
      :placeholder="placeholder"ref="date_input" :name="inputName"/>
    <span class="input-group-addon">
        <span class="fa fa-calendar"></span>
    </span>
  </div>
</template>

<script>
export default {
  props:{
    placeholder: {
      type: String,
      required: false,
      default: "",
    },
    options: {
      type: Object,
      required: false,
      default: function(){
        return {
          useCurrent: false,
          format: 'DD/MM/YYYY',
        };
      },
    },
    inputName: {
      type: String,
      required: true,
    },
    value: {
      type: String,
      required: false,
      default: "",
    }
  },
  data: function(){
    return{
      date: this.value,
    };
  },
  mounted: function(){
    var datetimepicker = $('.input-group.date')
    datetimepicker.datetimepicker(this.options)

    var self = this;

    datetimepicker.on('dp.change',function(e){
      self.date = $(self.$refs.date_input).val();
    });
  },
  watch: {
    date: function (val, oldVal) {
      this.$emit('input', val)
    }
  }
}
</script>

<style lang="css">
</style>
