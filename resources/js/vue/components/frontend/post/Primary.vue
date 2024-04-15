<template>
    <div class="mb-5 p-2 bg-lightblue position-relative bg-light p-5 rounded-3">
        <div class="pl-4 pr-0 h-100">
            <div class="row justify-content-between">
                <div class="col-md-6 pt-6 pb-6 align-self-center">
                    <h1 class="mb-3 font-weight-bold">{{ post.name }}</h1>
                    <p class="mb-3">
                        {{ post.description }}
                    </p>
                    <a href="#" class="btn btn-dark">Read More</a>
                </div>
                <div class="col-md-6 d-none d-md-block pr-0" v-bind:style=" { backgroundSize: 'cover', backgroundImage: 'url(' + post.image || images.noImage + ')' }"></div>
            </div>
        </div>
    </div>
</template>

<script>
import noImage from "@images/backend/no-image.jpg"

export default {
    props: {
        post: {
            type: Object,
            default: () => {},
        },
    },
    data () {
        return {
            images: { noImage }
        }
    },
}
</script>
