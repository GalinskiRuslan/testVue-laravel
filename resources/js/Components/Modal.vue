<template>
    <div class="modal" v-if="isOpen">
        <div class="modal-content">
            <slot></slot>
        </div>
        <div class="overlay" @click="setClose"></div>
    </div>
</template>

<script setup>
const props = defineProps([
    'isOpen',
    'setClose'
])
</script>

<style>
.modal {
    position: absolute;
}

.modal-content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    z-index: 101;
}

.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 100;
    background-color: rgba(0, 0, 0, 0.5);
}
</style>
