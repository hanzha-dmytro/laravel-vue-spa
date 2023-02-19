<template>
    <div class="col-xxl-4 col-lg-6 mb-3">
        <div class="card list-item">
            <span :class="['status-badge', badgeClass]"></span>
            <div class="row g-0">
                <div class="col-md-4 position-relative">
                    <img :src="user.avatar || images.avatar" class="card-img rounded-start" :alt="user.name">
                </div>
                <div class="col-md d-flex flex-column flex-shrink-1 overflow-hidden">
                    <div class="card-body">
                        <span class="card-title">{{ user.name }}</span>
                        <ul class="attributes">
                            <li v-if="user.role">
                                <strong>Role:</strong>
                                <span>{{ user.role?.name }}</span>
                            </li>
                            <li v-if="user.email">
                                <strong>Email:</strong>
                                <span>{{ user.email }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Last updated {{ user.updated_at | dateFormat }}</small>
                    </div>
                </div>
                <div class="col-md-auto btn-group-card">
                    <router-link :to="{ name: 'admin.users.edit',  params: { id: user.id } }" :class="['btn btn-primary col', { 'disabled': !$can(['users:read', 'users:update']) }]" >
                        <i class="fa-solid fa-pen"></i>
                    </router-link>
                    <button type="button" class="btn btn-danger col" :disabled="!$can('users:delete')" @click="$emit('removeUser', $event, user.id)">
                        <i class="fa-solid fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import avatar from '@images/backend/user-default-image.jpg'

export default {
    props: {
        user: {
            type: Object,
            default: () => {},
        },
    },
    data () {
        return {
            images: { avatar },
        }
    },
    computed: {
        badgeClass() {
            return this.user.is_active ? 'bg-success' : 'bg-danger'
        }
    }
}
</script>
