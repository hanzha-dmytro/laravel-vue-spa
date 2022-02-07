<template>
    <footer class="footer">
        <div class="container-fluid">
            <div class="row text-muted">
                <div class="col-6 text-start">
                    <p class="mb-0">
                        <router-link :to="{ name: 'admin.dashboard' }" class="text-muted"><strong>Vuester Blog</strong> ©</router-link>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {

    }
</script>
