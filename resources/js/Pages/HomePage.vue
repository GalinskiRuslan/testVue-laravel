<template>
    <div class="container">
        <div class="head-buttons">
            <input type="text" placeholder="поиск" class="search-input" />
            <div><a>all</a><a>USD</a><a>EUR</a><a>РУБ</a></div>
        </div>
        <table>
            <tr class="table-header">
                <th>ID</th>
                <th>Магазин</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Документ</th>
                <th>Действие</th>
            </tr>
            <tr v-for="item in  response " :key="item.id">
                <th>{{ item.id }}</th>
                <th>{{ item.shop_name }}</th>
                <th>{{ item.data_time }}</th>
                <th>{{ item.sum }}</th>
                <th><a :href="item.doc">{{ item.doc }}</a></th>
                <th><button class="edit-btn"><img alt="Edit" src="/public/free-icon-edit-button-6324826.png"
                            style="width: 40px;" /></button><button @click="onDelete(item.id)" class="edit-btn"><img
                            alt="Edit" src="/public/free-icon-delete-button-5676047.png"
                            style="width: 40px;" /></button></th>

            </tr>
        </table>
        <button @click="setIsOpen" class="btn-add">Добавить</button>
        <Modal :is-open="isOpen.isOpen" :set-close="setClose">
            <AddedItemForm></AddedItemForm>
        </Modal>
    </div>
</template>
<script setup>
import axios from 'axios';
import { computed, onMounted, reactive, ref } from "vue";
import Modal from '../Components/Modal.vue';
import AddedItemForm from '../Components/AddedItemForm.vue';
const response = ref();

onMounted(async () => {
    try {
        const asd = await axios.get('/api/transactions');
        response.value = asd.data
    } catch (error) {
        console.log(error);
    }
})

const onDelete = async (id) => {
    try {
        await axios.delete('/api/transactions/?id=' + id);
        const asd = await axios.get('/api/transactions');
        response.value = asd.data
        await axios.get('/api/transactions');
    } catch (error) {
        console.log(error);
    }
}
const setIsOpen = () => {
    isOpen.isOpen = !isOpen.isOpen
}
const setClose = () => {
    isOpen.isOpen = false
}
const isOpen = reactive({ isOpen: false })
</script>
<style scoped>
.container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
}

.search-input {
    width: 100%;
    max-width: 280px;
    border: 2px solid #ccc;
    padding: 10px;
    text-align: center;

}

.btn-add {
    max-width: 230px;
    width: 100%;
    margin-left: auto;
    margin-top: 60px;
    border: none;
    padding: 20px;
    border-radius: 20px;
    background-color: #1eee1e;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
}

.edit-btn {
    background: transparent;
    border: none;
    cursor: pointer;
}
</style>
