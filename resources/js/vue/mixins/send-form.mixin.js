export default {
    data() {
        return {
            form: {}
        }
    },
    methods: {
        sendForm(event) {
            let formData = new FormData();
            for (let key in this.form) {
                if(Array.isArray(this.form[key])) {
                    for (let item of this.form[key]) {
                        formData.append( key +'[]', item)
                    }
                } else {
                    formData.append( key, this.form[key])
                }
            }
            this.$emit('sendForm', event, formData)
        },
    }
}
