<template>
    <div>
        <router-view name="navbar"></router-view>

        <div class="container">
            <router-view></router-view>
            <router-view name="chat"></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>

<style type="text/css">
    .container {
        margin: 0;
        padding: 0;
    }
</style>