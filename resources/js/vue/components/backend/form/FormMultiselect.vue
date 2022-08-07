<template>
    <div>
        <label class="form-label" v-if="label">{{ label }}</label>
        <div :class="['multiselect', { 'opened': isOpen }, { 'is-invalid': errors.length }, {'disabled': disabled }]" :tabindex="searchable ? -1 : 1" @focus="activate()" @blur="deactivate()" @keyup.esc="deactivate()" ref="wrapper">
            <div class="select">
                <div class="wrap" v-if="isTagsVisible">
                    <span class="tag" v-for="(option, index) in selected" :key="index">
                        <span>{{ option.name }}</span>
                        <i class="close" @mousedown.prevent="removeOption(option.value)"/>
                    </span>
                </div>
                <span class="single" v-if="isSingleVisible">{{ text }}</span>
                <span class="select-placeholder" v-if="isPlaceholderVisible">{{ placeholder }}</span>
                <input v-model="search" type="text" :placeholder="searchText" v-if="searchable" tabindex="0" ref="search" @focus="activate()" @blur="deactivate()">
            </div>
            <div class="content-wrapper">
                <ul class="content">
                    <li class="element" v-for="(option, index) in filtered" :key="index">
                        <span :class="['option', { selected: isSelected(option.value) }]" @mousedown.prevent="toggleOption(option.value)">
                            {{ option.name }}
                        </span>
                    </li>
                    <li v-if="!filtered.length">
                        <span class="option">No elements found</span>
                    </li>
                </ul>
            </div>
        </div>
        <span class="invalid-feedback fw-bold" role="alert">{{ errors ? errors[0] : '' }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: [Number, String, Array],
                default: null,
            },
            options: {
                type: Array,
                required: true,
            },
            type: {
                type: String,
                default: 'single',
                validator: (value) => ['single', 'multiple', 'taggable'].includes(value),
            },
            searchable: {
                type: Boolean,
                default: false,
            },
            label: {
                type: String,
                default: null,
            },
            placeholder: {
                type: String,
                default: 'Select an option'
            },
            searchText: {
                type: String,
                default: 'Type to search'
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            errors: {
                type: Array,
                default: () => [],
            }
        },
        data () {
            return {
                isOpen: false,
                search: '',
            }
        },
        methods: {
            activate() {
                this.isOpen = true
                if (this.searchable) {
                    this.$nextTick(() => this.$refs.search.focus())
                } else {
                    this.$refs.wrapper.focus()
                }
            },
            deactivate() {
                this.isOpen = false
                if (this.searchable) {
                    this.$refs.search && this.$refs.search.blur()
                } else {
                    this.$refs.wrapper.blur()
                }

                // Clear the search field
                this.search = ''
            },
            isSelected(value) {
                return this.values.includes(value)
            },
            toggleOption(value) {
                // Remove value if it exists or add it if missing.
                this.values.includes(value) ? this.removeOption(value) : this.selectOption(value)
                this.deactivate()
            },
            selectOption(value) {
                const selected = this.values.concat(value)
                this.$emit('input', this.isMultiple ? selected : value)
            },
            removeOption(value) {
                const selected = this.values.filter((item) => item !== value)
                this.$emit('input',   this.isMultiple ? selected : '')
            },
        },
        computed: {
            values() {
                return [].concat(this.value)
            },
            filtered() {
               return this.options.filter((option) => option.name.toLowerCase().includes(this.search.toLowerCase()))
            },
            selected() {
                return this.values.reduce((array, value) => {
                    const option = this.options.find(option => option.value == value)
                    return option ? array.concat(option) : array
                }, [])
            },
            text() {
                return this.isMultiple ? this.selected.length + ' options selected' : this.selected[0]?.name
            },
            isMultiple() {
                return ['multiple', 'taggable'].includes(this.type)
            },
            isSingleVisible() {
                return this.selected.length && ((!this.isOpen || (!this.searchable && this.type !=='multiple')) && this.type !== 'taggable')
            },
            isTagsVisible() {
                return this.selected.length && ((this.type === 'multiple' && this.isOpen) || this.type === 'taggable')
            },
            isPlaceholderVisible() {
                return !this.selected.length && (!this.searchable || !this.isOpen)
            }
        },
    }
</script>
