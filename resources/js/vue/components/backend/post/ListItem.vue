<template>
    <div class="col-xl-6 mb-3">
        <div class="card list-item">
            <span :class="['status-badge', badgeClass]"></span>
            <div class="row g-0 position-relative">
                <div class="col-md-4">
                    <img :src="post.image || images.logo" class="card-img rounded-start" :alt="post.name">
                </div>
                <div class="col-md d-flex flex-column flex-shrink-1">
                    <div class="card-body">
                        <span class="card-title">{{ post.name }}</span>
                        <ul class="attributes">
                            <li v-if="post.category">
                                <strong>Category:</strong>
                                <span>{{ post.category?.name }}</span>
                            </li>
                            <li v-if="post.published_at">
                                <strong>Published:</strong>
                                <span>{{ post.published_at }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Last updated {{ post.updated_at | dateFormat }}</small>
                    </div>
                </div>
                <div class="col-md-auto btn-group-card">
                    <router-link :to="{ name: 'admin.posts.edit',  params: { id: post.id } }" :class="['btn btn-primary col', { 'disabled': !$can(['posts:read', 'posts:update']) }]">
                        <i class="fas fa-pen"></i>
                    </router-link>
                    <button type="button" class="btn btn-danger col" :disabled="!$can('posts:delete')" @click="$emit('removePost', $event, post.id)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import logo from '../../../../../images/backend/no-image.jpg';

export default {
    props: {
        post: {
            type: Object,
            default: () => {},
        },
    },
    data () {
        return {
            images: { logo }
        }
    },
    computed: {
        badgeClass() {
            return !this.post.is_visible ? 'bg-danger' : (new Date(this.post.published_at) <= new Date() ? 'bg-success' : 'bg-warning')
        }
    }
}
</script>
