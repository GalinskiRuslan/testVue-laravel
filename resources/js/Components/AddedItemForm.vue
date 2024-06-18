<template>
    <div v-if="loading">Loading...</div>
    <div v-else-if="error">{{ error }}</div>
    <div v-else-if="data">
        <div class="shop-info">
            <div>
                <p>Выберете магазин</p>
                <select v-model="checkShop">
                    <option v-for="item in  data " :key="item.id" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div>
                <p>Или добавьте новый</p>
                <p class="error-text" v-if="addShopError">{{ addShopError }}</p>
                <input type="text" placeholder="название" v-model="inputShop" @input="setInputShop" />
                <button @click="addShop">Добавить</button>
            </div>
        </div>
        <div class="items">
            <div>
                <p>Выберете дату</p>
                <Datepicker v-model="date" />
            </div>
            <div>
                <p>Введите сумму</p>
                <input type="text" placeholder="Сумма" v-model="sum" @input="onInput" />
            </div>
            <div>
                <p>прикрепите документ</p>
                <input type="file" placeholder="Документ" accept="image/*, .pdf" @change="onFileChange" />
            </div>
            <button @click="addTransaction">Сохранить</button>
        </div>
    </div>

</template>

<script>

export default {
    data() {
        return {
            date: new Date(),
            data: null,
            loading: true,
            error: null,
            inputShop: '',
            addShopError: null,
            sum: '',
            checkShop: '',
            file: null,
        };
    },
    async mounted() {
        try {
            const response = await axios.get('/api/shops');
            this.data = response.data;
            this.loading = false;
        } catch (error) {
            this.error = error;
            this.loading = false;
        }
    },
    methods: {
        setInputShop(event) {
            this.inputShop = event.target.value
        },
        onInput(event) {
            this.sanitizedInput = this.sanitizeInput(event.target.value);
            this.sum = this.sanitizedInput;
        },
        sanitizeInput(input) {
            // Удаляем все символы, кроме цифр и запятых
            let sanitized = input.replace(/[^0-9.]/g, '');

            // Проверяем, есть ли больше одной запятой
            const parts = sanitized.split(',');
            if (parts.length > 2) {
                // Если больше одной запятой, удаляем все последующие запятые
                sanitized = parts[0] + ',' + parts.slice(1).join('').replace(/,/g, '');
            }

            return sanitized;
        },
        onFileChange(event) {
            this.file = event.target.files[0];
        },
        async addShop() {
            this.loading = true;
            try {
                await axios.post('/api/shops', {
                    name: this.inputShop
                })
                const response = await axios.get('/api/shops');
                this.data = response.data;
                this.loading = false;
            } catch (error) {
                this.addShopError = error.response?.data;
                this.loading = false;
            }
        },
        async addTransaction() {
            this.loading = true;
            try {
                const response = await axios.post('/api/transactions', {
                    data_time: this.date,
                    sum: this.sum,
                    shop_id: this.checkShop,
                    doc: this.file
                }, { headers: { 'Content-Type': 'multipart/form-data' }, });
                this.loading = false;
                this.error = response.data;
                const asd = await axios.get('/api/transactions');
            } catch (error) {
                this.addShopError = error.response?.data;
                this.loading = false;
            }
        },

    },

}
</script>

<style>
p {
    margin: 0;
}

.error-text {
    font-size: 12px;
    color: red;
    margin: 0;
    padding: 0;
}

.shop-info {
    display: flex;
    gap: 20px;
}

.items {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
</style>
