<template>
    <div class="pagination-wrapper" v-if="pageRange">
        <ul class="pagination">
            <li :class="['page-item', {'disabled': currentPage === 1}]">
                <span class="page-link" v-if="currentPage === 1">&laquo;</span>
                <a class="page-link" aria-label="Previous" :href="makeUrl(currentPage - 1)" @click.prevent="navigate(currentPage - 1)" v-else>&laquo;</a>
            </li>

            <li v-for="(page, key) in pageRange" :class="['page-item', {'active': page === currentPage}, {'disabled': (page === '...') }]" :key="key">
                <span class="page-link" v-if="page === currentPage || page === '...'">{{ page }}</span>
                <a class="page-link" :href="makeUrl(page)"  @click.prevent="navigate(page)" v-else>{{ page }}</a>
            </li>

            <li :class="['page-item', {'disabled': currentPage === lastPage}]">
                <span class="page-link" v-if="currentPage === 1">&raquo;</span>
                <a class="page-link" aria-label="Previous" :href="makeUrl(currentPage + 1)" @click.prevent="navigate(currentPage + 1)" v-else>&raquo;</a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        route: {
            type: String,
            required: true,
        },
        data: {
            type: Object,
            default: () => {},
        },
        filter: {
            type: Object,
            default: () => {},
        },
        links: {
            type: Number,
            default: () => 2,
        }
    },
    computed: {
        isApiResource () {
            return !!this.data.meta;
        },
        currentPage () {
            return this.isApiResource ? this.data.meta.current_page : this.data.current_page;
        },
        lastPage () {
            return this.isApiResource ? this.data.meta.last_page : this.data.last_page;
        },
        from () {
            return this.isApiResource ? this.data.meta.from : this.data.from;
        },
        to () {
            return this.isApiResource ? this.data.meta.to : this.data.to;
        },
        total () {
            return this.isApiResource ? this.data.meta.total : this.data.total;
        },
        perPage () {
            return this.isApiResource ? this.data.meta.per_page : this.data.per_page;
        },
        pageRange () {
            let pages = [],
                delta = this.links * 2;

            if(!this.currentPage)
                return false

            if (this.currentPage <= 1 + Math.floor(delta / 2)) {
                pages = Array.from({
                    length: Math.min(1 + delta + 1, this.lastPage) - 1 + 1
                }, (_, i) => 1 + i);
            } else if (this.currentPage >= this.lastPage - Math.round(delta / 2)) {
                pages = Array.from({
                    length: this.lastPage - Math.max(1, this.lastPage - delta - 1) + 1
                }, (_, i) => Math.max(1, this.lastPage - delta - 1) + i);
            } else {
                pages = Array.from({
                    length: Math.min(Math.round( this.currentPage + delta / 2), this.lastPage) - Math.round( this.currentPage - delta / 2) + 1
                }, (_, i) => Math.round( this.currentPage - delta / 2) + i);
            }

            if (pages[0] !== 1) {
                pages = (pages.length + 1 !== this.lastPage && pages[0] - 1 > 1 ? [1, '...'] : [1]).concat(pages)
            }

            if (pages[pages.length - 1] !== this.lastPage) {
                pages =  pages.concat(pages[pages.length - 1] + 1 !== this.lastPage ? ['...', this.lastPage] : [this.lastPage])
            }

            return pages
        },
    },
    methods: {
        navigate(page) {
            this.$emit('navigate', page)
        },
        makeUrl(page) {
            const url = new URL(location.href);
            url.searchParams.delete('page')

            if(page !== 1) {
                url.searchParams.set('page', page);
            }

            return url.toString();
        }
    }
}
</script>
