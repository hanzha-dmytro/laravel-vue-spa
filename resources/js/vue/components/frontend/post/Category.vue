<template>
    <div class="mb-5 last-in-category">

        <h5 class="title-with-underscore" v-if="!!title">
            <span>{{ title }}</span>
        </h5>

        <!-- foreach -->
        <div class="mb-3 d-flex justify-content-between" v-for="(post, index) in posts" :key="post.id">
            <div class="pr-3">
                <a class="text-dark" href="#">
                    <h2 class="mb-1 h4 font-weight-bold">{{ post.name }}</h2>
                </a>
                <p>
                    {{ post.description }}
                </p>
                <div class="card-text text-muted small">
                    {{ post.author.name }} in {{ post.category.name }}
                </div>
                <small class="text-muted">{{ post.published_at | dateFormat }} · {{ post.published_at | dateFromNow }}</small>
            </div>
            <img height="120" :src="post.image || images.noImage" :alt="post.name">
        </div>
        <!-- foreach -->

    </div>
</template>

<script>
    import noImage from "@images/backend/no-image.jpg"

    export default {
        props: {
            title: {
                type: String,
                default: null,
            },
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

