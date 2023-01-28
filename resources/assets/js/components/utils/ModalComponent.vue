<template>
    <transition name="v-modal-fade">
        <div class="v-modal-backdrop" role="dialog">
            <div class="v-modal" :class="size" ref="v-modal">
                <header class="v-modal-header">
                    <slot name="header">
                        <h4>This is the default tile!</h4>
                        <button type="button" class="btn btn-sm btn-danger" @click="close" aria-label="Close modal">
                            X
                        </button>
                    </slot>
                </header>

                <section class="v-modal-body">
                    <slot name="body">
                        Modal Body
                    </slot>
                </section>

                <footer class="v-modal-footer">
                    <slot name="footer">
                        <button type="button" class="btn btn-danger" @click="close" aria-label="Close v-modal">Close</button>
                    </slot>
                </footer>
            </div>
        </div>
    </transition>
</template>

<style lang="scss" scoped>
    .v-modal-backdrop {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.3);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10;
    }

    .v-modal {
        background: #ffffff;
        box-shadow: 2px 2px 20px 1px;
        overflow-x: auto;
        display: flex;
        flex-direction: column;
        width: 35%;
        max-height: 80%;
    }

    .v-modal-md {
        width: 60% !important;
    }

    .v-modal-lg {
        width: 80% !important;
    }

    .v-modal-header,
    .v-modal-footer {
        padding: 15px;
        display: flex;
    }

    .v-modal-header {
        border-bottom: 1px solid #eeeeee;
        justify-content: space-between;
    }

    .v-modal-footer {
        border-top: 1px solid #eeeeee;
        justify-content: flex-end;
    }

    .v-modal-body {
        position: relative;
        overflow-y: scroll;
        padding: 20px 10px;
    }

    .v-modal-fade-enter,
    .v-modal-fade-leave-active {
        opacity: 0;
    }

    .v-modal-fade-enter-active,
    .v-modal-fade-leave-active {
        transition: opacity 0.5s ease;
    }

    @media only screen and (max-width: 992px) {           
        .v-modal, .v-modal-md {
            width: 80% !important;
        }
    }
</style>
<script>
    export default {
        props: {
            size: String,
        },
        methods: {
            close(event) {
                this.$emit('close');
            },
        }
    }
</script>
