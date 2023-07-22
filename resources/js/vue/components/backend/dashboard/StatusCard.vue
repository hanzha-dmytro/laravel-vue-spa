<template>
    <div class="card stats-card">
        <div class="card-body">
            <div class="row">
                <div class="col mt-0">
                    <span class="card-title">{{ label }}</span>
                </div>
                <div class="col-auto ">
                    <div class="stat-icon">
                        <i :class="['align-middle', icon ]"></i>
                    </div>
                </div>
            </div>
            <span class="stat-value">{{ value }}</span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: Number,
            default: 0,
        },
        label: {
            type: String,
            default: '',
        },
        icon: {
            type: String,
            default: '',
        },
    },
}
</script>
