<template>
    <div class="container">
        <div class="head-buttons">
            <input type="text" placeholder="поиск" class="search-input" />
        </div>
        <table>
            <tr>
                <th>Магазин</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Документ</th>
                <th>Действие</th>
            </tr>

        </table>
    </div>
</template>
<script setup>
import axios from 'axios';
import { ref } from "vue";
const response = ref();
const getValue = async () => {
    try {
        response.value = (await axios.get('/api/test')).data;
    } catch (error) {

        console.log(error);
    }
}
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
</style>
