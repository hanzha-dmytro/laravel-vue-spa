<template>
    <div class="col-xxl-3 col-lg-6 mb-3">
        <div class="card list-item">
            <div class="row g-0">
                <div class="col-md d-flex flex-column flex-shrink-1 overflow-hidden">
                    <div class="card-body">
                        <span class="card-title">{{ role.name }} </span>
                        <ul class="list-unstyled m-0">
                            <li><strong>Slug: </strong><span class="text-muted">{{ role.slug }}</span></li>
                            <li><strong>Permissions: </strong><span class="text-muted">{{ role.permissions.length }}</span></li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Last updated {{ role.updated_at | dateFormat }}</small>
                    </div>
                </div>
                <div class="col-md-auto btn-group-card">
                    <router-link :to="{ name: 'admin.roles.edit',  params: { id: role.id } }" :class="['btn btn-primary col', { 'disabled': !$can(['roles:read', 'roles:update']) }]" >
                        <i class="fa-solid fa-pen"></i>
                    </router-link>
                    <button type="button" class="btn btn-danger col" :disabled="!$can('roles:delete')" @click="$emit('removeRole', role.id)">
                        <i class="fa-solid fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        role: {
            type: Object,
            default: () => {},
        },
    },
}
</script>
