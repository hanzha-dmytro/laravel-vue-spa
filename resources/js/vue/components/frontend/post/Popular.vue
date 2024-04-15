<template>
    <div class="mb-5 last-in-category">
        <h5 class="title-with-underscore" v-if="!!title">
            <span>{{ title }}</span>
        </h5>

        <ol class="list-featured">
            <!-- foreach -->
            <li v-for="(post, index) in posts" :key="post.id">
				<div>
                    <a href="#" class="text-dark">
                        <h6 class="font-weight-bold">
                            {{ post.name }}
                        </h6>
                    </a>
                    <p class="text-muted">
                        {{ post.author.name }} in {{ post.category.name }}
                    </p>
				</div>
            </li>
            <!-- foreach -->
        </ol>

    </div>
</template>

<script>
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
    }
</script>

