<template>
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2">
                <div class="col-auto d-block">
                    <h1 class="h4">Dashboard</h1>
                </div>
            </div>

            <div class="row flex-fill">
                <div class="col-xl-6 col-xxl-5 d-flex">
                    <div class="w-100">
                        <div class="row">
                            <div class="col-sm-6">
                                <status-card :value="222" label="Categories" icon="fa-solid fa-rectangle-list" class="mb-2" />
                                <status-card :value="343" label="Posts" icon="far fa-newspaper" class="mb-2"  />
                            </div>
                            <div class="col-sm-6">
                                <status-card :value="26622" label="Comments" icon="fas fa-comments align-middle" class="mb-2"  />
                                <status-card :value="77" label="Pages" icon="fas fa-file-alt" class="mb-2"  />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-xxl-7">
                    <line-chart title="Visitors" :data="statistic" :labels="months"></line-chart>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import StatusCard from '@vue/components/backend/dashboard/StatusCard.vue'
    import LineChart from "@vue/components/backend/dashboard/LineChart.vue";

    export default {
        data: () => ({
            statistic: [],
            months: [],
        }),
        components: { StatusCard, LineChart }
    }
</script>
