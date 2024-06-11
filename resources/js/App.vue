<template>
    <router-view v-slot="{ Component, route }">
        <div :key="route.name">
            <Component :is="Component" />
        </div>
    </router-view>

</template>
<style scoped>
h1 {
    color: red;
}
</style>

