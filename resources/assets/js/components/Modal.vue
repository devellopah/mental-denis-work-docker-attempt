<template>
  <transition>

    <div :class="['modal fade ', showed ? 'center-block in' : '']" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{title}}</h4>
          </div>
          <div class="modal-body">
            {{text}}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-raised" @click="choice()">Следующее упражнение</button>
            <button type="button" class="btn btn-raised btn-danger" @click="close()">Попробовать ещё раз</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

  </transition>
</template>

<script>
export default {
  name: 'Modal',
  props: ['showed', 'text', 'title'],
  methods: {
    close(){
      this.$emit('close');
    },
    choice(){
      this.$emit('choice');
    }
  }
}
</script>
