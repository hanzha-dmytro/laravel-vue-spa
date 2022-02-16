<template>
    <div class="image-wrapper">
        <div class="image-container">
            <input type="file" :id="'file-upload-'+uid" accept=".jpg, .jpeg, .png, .webp" hidden :disabled="disabled" :class="[{'is-invalid': errors.length }]" @change="onFileChange"/>
            <label :for="'file-upload-'+uid">
                <img :src="image" :width="width" :height="height" :style="{ 'opacity': image ? 1 : 0 }" />
                <span class="image-uploader" :style="{ 'opacity': image ? 0 : 0.8 }">
                    <i class="fa-regular fa-image"></i>
                    <span>Upload image</span>
                </span>
            </label>
            <span class="invalid-feedback fw-bold" role="alert">{{ errors ? errors[0] : '' }}</span>
        </div>

        <div ref="modal" class="modal fade" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Edit image</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="preview-container">
                            <img ref="image" :src="preview"/>
                        </div>
                        <div class="control text-center mt-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" title="Move" @click.prevent="setDragMode('move')">
                                    <span class="fa fa-arrows-alt"></span>
                                </button>
                                <button type="button" class="btn btn-primary" title="Crop" @click.prevent="setDragMode('crop')">
                                    <span class="fa fa-crop-alt"></span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" title="Zoom In" @click.prevent="zoomImage(0.1)">
                                    <span class="fa fa-search-plus"></span>
                                </button>
                                <button type="button" class="btn btn-primary" title="Zoom Out" @click.prevent="zoomImage(-0.1)">
                                    <span class="fa fa-search-minus"></span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" title="Rotate Left" @click.prevent="rotateImage(-45)">
                                    <span class="fa fa-undo-alt"></span>
                                </button>
                                <button type="button" class="btn btn-primary" title="Rotate Right" @click.prevent="rotateImage(45)">
                                    <span class="fa fa-redo-alt"></span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" title="Flip Horizontal" @click.prevent="scaleXImage()">
                                    <span class="fa fa-arrows-alt-h"></span>
                                </button>
                                <button type="button" class="btn btn-primary" title="Flip Vertical" @click.prevent="scaleYImage()">
                                    <span class="fa fa-arrows-alt-v"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-success" @click.prevent="onSaveImage">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Cropper from 'cropperjs'
import { isNumber } from "lodash";

export default {
    props: {
        value: {
            type: [String],
            default: null,
        },
        width: {
            type: Number,
            required: true,
        },
        height: {
            type: Number,
            required: true,
        },
        fileType: {
            type: String,
            default: 'image/png',
        },
        fillColor: {
            type: String,
            default: 'transparent',
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        errors: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            image: this.value,
            preview: null,
            modal: null,
            cropper: null
        }
    },
    mounted() {
        this.initModal()
    },
    methods: {
        initModal() {
            this.$refs.modal.addEventListener('shown.bs.modal', this.onModalShown)
            this.$refs.modal.addEventListener('hidden.bs.modal', this.onModalHidden)
            this.modal = new bootstrap.Modal(this.$refs.modal)
        },
        onModalShown() {
            this.cropper = new Cropper(this.$refs.image, {
                aspectRatio: this.aspectRatio,
                autoCrop: true,
                scalable: true,
                rotatable: true,
                responsive: true,
                background: true,
                dragMode: 'move',
            })
        },
        onModalHidden() {
            this.cropper.destroy()
        },
        onFileChange(event) {
            if(event.target.files.length) {
                // Render image preview
                this.preview = URL.createObjectURL(event.target.files[0])
                event.target.value = null

                // Show modal form
                this.modal.show()
            }
        },
        onSaveImage(event) {
            const button = event.currentTarget

            // Disable submit button and disable cropper
            button.disabled = true
            this.cropper.disable()

            const canvasSettings = {
                'fillColor': this.fillColor,
                'width' : this.width,
                'height' : this.height
            }

            this.cropper.getCroppedCanvas(canvasSettings).toBlob((blob) => {
                // Enable submit button and close modal form
                button.disabled = false
                this.modal.hide()

                // Render image preview
                this.image = URL.createObjectURL(blob)

                // Emit change event for parent component
                this.$emit('change', blob)
            }, this.fileType)
        },
        zoomImage(percent) {
            this.cropper.zoom(percent)
        },
        rotateImage(degree) {
            this.cropper.rotate(degree)
        },
        scaleXImage() {
            this.cropper.scaleX(this.cropper.getData()?.scaleX === 1 ? -1 : 1)
        },
        scaleYImage() {
            this.cropper.scaleY(this.cropper.getData()?.scaleY === 1 ? -1 : 1)
        },
        setDragMode(mode) {
            this.cropper.setDragMode(mode)
        }
    },
    computed: {
        aspectRatio: function () {
            const ratio = this.width / this.height
            return isNumber(ratio) ? ratio : 1;
        },
        uid: function () {
            return this._uid;
        }
    }
}
</script>

<style lang="scss">
    @import '~cropperjs/dist/cropper.css';
</style>
