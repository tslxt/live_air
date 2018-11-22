<template>
    <div>
        <h1>方田直播课</h1>

        <p>
            <router-link :to="{ name: 'home' }">主页</router-link> |
            <router-link :to="{ name: 'live' }">直播</router-link>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>