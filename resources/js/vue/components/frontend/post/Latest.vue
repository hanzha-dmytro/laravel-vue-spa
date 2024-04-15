<template>
    <div class=" mb-5 box-shadow h-xl-300 last-news">

        <!-- foreach -->
        <div :class="['news-item']" v-for="(post, index) in posts" :key="post.id">
            <img :src="post.image || images.noImage" :alt="post.name">
            <div class="news-item-info">
                <a class="news-item-info-title" href="#">{{ post.name }}</a>
                <div class="news-item-info-description" v-if="index === 0">
                    {{ post.description }}
                </div>
                <div class="card-text text-muted small">
                    {{ post.author.name }} in {{ post.category.name }}
                </div>
                <small class="text-muted">{{ post.published_at | dateFormat }} · {{ post.published_at | dateFromNow }}</small>
            </div>
        </div>
        <!-- foreach -->

    </div>

</template>

<script>
    import noImage from "@images/backend/no-image.jpg"

    export default {
        props: {
            posts: {
                type: Array,
                default: () => [],
            },
        },
        data () {
            return {
                images: { noImage }
            }
        },
    }
</script>

