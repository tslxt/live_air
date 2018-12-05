<template>
    <div>
        <Header/>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import Header from './Header';

    export default {
        name: 'app',
        components: {
            Header
        }
    }
</script>

<style type="text/css">
    .container {
        margin: 0;
        padding: 0;
    }
</style>