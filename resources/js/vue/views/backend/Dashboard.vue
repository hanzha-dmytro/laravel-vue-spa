<template>
    <main class="content">
        <div class="container-fluid p-0 h-100">
            <div class="row mb-2">
                <div class="col-auto d-block">
                    <h1 class="h4">Dashboard</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-xl-6 col-xxl-5 d-flex mb-4">
                    <div class="w-100">
                        <div class="row">
                            <div class="col-sm-6">
                                <status-card :value="cards.categories" label="Categories" icon="fa-solid fa-rectangle-list" class="mb-2" />
                                <status-card :value="cards.posts" label="Posts" icon="far fa-newspaper" class="mb-2"  />
                            </div>
                            <div class="col-sm-6">
                                <status-card :value="cards.comments" label="Comments" icon="fas fa-comments align-middle" class="mb-2"  />
                                <status-card :value="cards.pages" label="Pages" icon="fas fa-file-alt" class="mb-2"  />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-xl-6 col-xxl-7">
                    <line-chart title="Visitors" :datasets="visitors.datasets" :labels="visitors.labels"></line-chart>
                </div>

                <div class="col-sm-12 col-xl-12 flex-fill">
                    <comments :comments="comments" :loading="loading" />
                </div>

            </div>
        </div>
    </main>
</template>

<script>
    import StatusCard from '@vue/components/backend/dashboard/StatusCard.vue'
    import LineChart from "@vue/components/backend/dashboard/LineChart.vue";
    import Comments from "@vue/components/backend/dashboard/Comments.vue";

    export default {
        data: () => ({
            cards: {},
            visitors: {
                datasets: [
                    {
                        label: "Visitors ",
                        fill: true,
                        tension: 0.4,
                        backgroundColor: '#89b1ea',
                        borderColor: '#3B7DDD',
                        data: []
                    }
                ],
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            comments: [],
            loading: true,
        }),
        mounted() {
            this.getStatistic()
        },
        methods: {
            getStatistic() {
                this.loading = true
                this.errors = {}

                axios.get('/api/dashboard', {
                    params: {...this.$props}
                }).then((response) => {
                    this.cards = response.data.cards
                    this.visitors.datasets[0].data = this.prepareData(response.data.visitors)
                    this.comments = response.data.comments

                    this.loading = false
                }).catch(error => {
                    this.errors = error.response.status === 422 ? error.response.data.errors : {}
                });
            },
            prepareData(data) {
                return this.visitors.labels.map((item, index) => {
                    return data.find((element) => element.month === item)?.value ?? 0;
                });
            },
        },
        components: { StatusCard, LineChart, Comments }
    }
</script>
