<template>
    <div>
        <label class="form-label" v-if="label">{{ label }}</label>
        <div class="file-uploader">
            <input multiple type="file" :id="'file-upload-'+uid" :class="[{ 'is-invalid': errors.length }]" :disabled="disabled" hidden @change="inputChanged($event.target.files)">
            <label class="drop-place" :for="'file-upload-'+uid" ref="file_uploader">
                <i class="fa-solid fa-file-upload"></i>
                <span>drop file or browse</span>
            </label>
            <ul class="files-list" v-if="files.length">
                <li class="files-list-item" v-for="(file, index) in files" :key="index">
                    <span class="file-name">{{ file.name }}</span>
                    <span class="file-size">{{ toHumanSize(file.size) }}</span>
                    <i class="fa-solid fa-trash" @click.prevent="removeFile(index)"></i>
                </li>
            </ul>
            <span class="invalid-feedback fw-bold" role="alert">{{ errors ? errors[0] : '' }}</span>
        </div>
    </div>
</template>

<script>
    import toHumanSize from "../../../helpers/to-human-size";
    import addEventsListener from "../../../helpers/add-events-listener";

    export default {
        props: {
            value: {
                type: String,
                default: null,
            },
            label: {
                type: String,
                default: null,
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            limit: {
                type: Number,
                default: null,
            },
            errors: {
                type: Array,
                default: () => [],
            },
        },
        data () {
            return {
                files: []
            }
        },
        mounted() {
            this.initEvents()
        },
        methods: {
            inputChanged(files) {
                this.addFiles(Array.from(files))
                this.$emit('change', this.files)
            },
            addFiles(files = []) {
                for (let file of files) {
                    if(!this.files.some((item) => item.name === file.name )) {
                        this.files.push(file)
                    }
                }
            },
            removeFile(key) {
                this.files.splice(key , 1)
            },
            initEvents() {
                // Disable defaults events
                addEventsListener(this.$refs.file_uploader, ['dragenter', 'dragover', 'dragleave', 'drop'], (event) => {
                    event.preventDefault()
                    event.stopPropagation()
                })

                addEventsListener(this.$refs.file_uploader, ['dragenter', 'dragover'], (event) => {
                    event.currentTarget.classList.add('is-dragover')
                })

                addEventsListener(this.$refs.file_uploader, ['dragleave', 'dragend', 'drop'], (event) => {
                    event.currentTarget.classList.remove('is-dragover')
                })

                this.$refs.file_uploader.addEventListener('drop', (event) => this.addFiles(Array.from(event.dataTransfer.files)))
            },
            toHumanSize(bites) {
                return toHumanSize(bites)
            }
        },
        computed: {
            uid: function () {
                return this._uid;
            }
        }
    }
</script>

<style scoped lang="scss">
    .file-uploader  {
        display: flex;
        flex-direction: column;
        position: relative;

        .drop-place {
            display: flex;
            position: relative;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
            min-height: 140px;
            background: #e6ebf4;
            text-align: center;
            font-size: 14px;
            color: #90a0bc;
            border: 2px dashed #92a7bf;
            border-radius: 5px;
            cursor: pointer;
            opacity: 0.8;
            transition: all .2s ease;

            &:hover {
                opacity: 1 !important;
            }

            &.is-dragover {
                border: 2px dashed #898b8c;
                background: #f5f7fa;
                opacity: 1;
            }

            i {
                font-size: 36px;
                font-style: normal;
            }
        }

        input {
            &:disabled {
                &~.drop-place {
                    opacity: 0.4;
                    pointer-events: none;
                }
            }
        }

        .files-list {
            display: block;
            padding-left: 0;
            margin: 10px 0 0;
            list-style: none;

            .files-list-item {
                display: flex;
                flex-wrap: nowrap;
                align-items: center;
                padding: 5px;
                border: 1px solid #92a7bf;
                border-radius: 5px;
                margin-bottom: 5px;

                .file-name {
                    overflow: hidden;
                    flex-grow: 1;
                    text-overflow: ellipsis;
                    vertical-align: top;
                    white-space: nowrap;
                }

                .file-size {
                    white-space: nowrap;
                    margin-left: 10px;
                }

                i {
                    margin-left: 10px;
                    color: #cf2017;
                    cursor: pointer;
                }
            }
        }
    }
</style>
