<template>
    <div class="col-xl-12 col-xxl-12 mb-3">
        <div class="card list-item">
            <span :class="['status-badge', badgeClass]"></span>
            <div class="row g-0">
                <div class="col-md-2 position-relative">
                    <img :src="category.image || images.logo" class="card-img rounded-start" :alt="category.name">
                </div>
                <div class="col-md d-flex flex-column flex-shrink-1">
                    <div class="card-body">
                        <span class="card-title">{{ category.name }}</span>
                        <p>{{ category.description?.slice(0, 300) }}</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Last updated {{ category.updated_at | dateFormat }}</small>
                    </div>
                </div>
                <div class="col-md-auto btn-group-card">
                    <button class="btn btn-primary col" :disabled="!$can('categories:update')" @click.prevent="$emit('editCategory', category.id)">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button type="button" class="btn btn-danger col" :disabled="!$can('categories:delete')" @click.prevent="$emit('removeCategory', $event, category.id)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import logo from '@images/backend/no-image.jpg';

export default {
    props: {
        category: {
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
            return this.category.is_visible ? 'bg-success' : 'bg-danger'
        }
    }
}
</script>
