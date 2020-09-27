<template>
  <transition name="modal" appear>
    <div class="modal modal-overlay" @click.self="closeModal()">
        <div class="modal-window">
            <div class="modal-header">
                <h4 class="modal-title" id="modal"><slot name="title"></slot></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="close" @click="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <slot name="body"> </slot>
            </div>
            <footer class="modal-footer">
                <slot name="footer"> </slot>
            </footer>
        </div>
    </div>
  </transition>
</template>

<style lang="stylus" scoped>
.modal {
  &.modal-overlay {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    z-index: 30;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
  }

    &-window {
        margin-left: auto;
        margin-right: auto;
        background: #fff;
        border-radius: 4px;
        width: auto;
        height: auto;
        overflow: hidden;
    }

    &-title {
        text-align: center;
    }

    &-body slot{
        margin: auto;
    }

    &-footer {
    }

  &-content {
    padding: 10px 20px;
  }

  &-footer {
    background: #ccc;
    padding: 10px;
    text-align: right;
  }
}

// オーバーレイのトランジション
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.4s;

  // オーバーレイに包含されているモーダルウィンドウのトランジション
  .modal-window {
    transition: opacity 0.4s, transform 0.4s;
  }
}

// ディレイを付けるとモーダルウィンドウが消えた後にオーバーレイが消える
.modal-leave-active {
  transition: opacity 0.6s ease 0.2s;
}

.modal-enter, .modal-leave-to {
  opacity: 0;

  .modal-window {
    opacity: 0;
    transform: translateY(-20px);
  }
}
</style>


<script>
    export default {
        methods: {
            closeModal() {
                this.$emit('close-event');
            }
        }
    }
</script>
