<template>
    <div class="col-sm-12 mb-3">
        <div class="card list-item">
            <span :class="['status-badge', badgeClass]"></span>
            <div class="row g-0">
                <div class="col-md d-flex flex-column flex-shrink-1">
                    <div class="card-body position-relative">
                        <span class="card-title d-inline-block">{{ comment.name }}</span>
                        <span class="card-subtitle float-end">{{ comment.post.name }}</span>
                        <p class="card-text">{{ comment.content }}</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Published: {{ comment.published_at | dateFormat }}</small>
                    </div>
                </div>
                <div class="col-md-auto btn-group-card">
                    <button type="button" :class="['btn col', statusButtonClass]" :disabled="!$can('comments:update')" @click="$emit('changeStatus', $event, comment)">
                        <i :class="['far', statusButtonIcon]"></i>
                    </button>
                    <button class="btn btn-primary col" :disabled="!$can('comments:update')" @click.prevent="$emit('editComment',$event, comment.id)">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button type="button" class="btn btn-danger col" :disabled="!$can('comments:delete')" @click.prevent="$emit('removeComment', $event, comment.id)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        comment: {
            type: Object,
            default: () => {},
        },
    },
    computed: {
        badgeClass() {
            return this.comment.is_visible ? 'bg-success' : 'bg-danger'
        },
        statusButtonClass() {
            return this.comment.is_visible ? 'btn-warning' : 'btn-success'
        },
        statusButtonIcon() {
            return this.comment.is_visible ? 'fa-thumbs-down' : 'fa-thumbs-up'
        },
    }
}
</script>
