<template>
    <div class="col-sm-12 mb-3">
        <div class="card list-item">
            <span :class="['status-badge', badgeClass]"></span>
            <div class="row g-0">
                <div class="col-md d-flex flex-column flex-shrink-1">
                    <div class="card-body">
                        <span class="card-title">{{ page.name }}</span>
                        <ul class="attributes">
                            <li v-if="page.slug">
                                <strong>Slug:</strong>
                                <span>{{ page.slug }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Last updated {{ page.updated_at | dateFormat }}</small>
                    </div>
                </div>
                <div class="col-md-auto btn-group-card">
                    <router-link :to="{ name: 'admin.pages.edit',  params: { id: page.id } }" :class="['btn btn-primary col', { 'disabled': !$can(['pages:read', 'pages:update']) }]">
                        <i class="fas fa-pen"></i>
                    </router-link>
                    <button type="button" class="btn btn-danger col" :disabled="!$can('pages:delete')" @click="$emit('removePage', $event, page.id)">
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
        page: {
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
            return !this.page.is_visible ? 'bg-danger' : 'bg-success'
        }
    }
}
</script>
