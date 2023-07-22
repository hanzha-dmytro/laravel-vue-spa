<template>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Last comments</h5>
        </div>
        <div class="card-body d-flex flex-column h-100 py-0" style="min-height: 160px">

            <app-loader class="flex-fill" v-if="loading" />

            <div class="col-12 d-flex flex-fill align-items-center justify-content-center" v-else-if="!comments.length">
                <span class="h6">There aren't comments yet!</span>
            </div>

            <div class="d-flex align-items-start border-bottom py-3" v-for="comment in comments" :key="comment.id" v-else>
                <div class="flex-grow-1">
                    <small class="float-end text-navy">{{ comment.published_at | dateFormat }}</small>
                    <strong>{{ comment.name }}</strong> on the post <strong>{{ comment.post.name }}</strong><br>
                    <small class="text-muted">{{ comment.published_at | dateFromNow }}</small>
                    <div class="border text-sm text-muted p-2 mt-1">
                        {{ comment.content }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
import AppLoader from "@vue/components/backend/app/AppLoader.vue";

export default {
    components: {AppLoader},
    props: {
        comments: {
            type: Array,
            default: () => {},
        },
        loading: {
            type: Boolean,
            default: true,
        },
    },
}
</script>
