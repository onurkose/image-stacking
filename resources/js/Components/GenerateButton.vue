<template>
    <span>
        <jet-button @click="generateImages" :class="{ 'opacity-25': processing }"
                    :disabled="processing">Generate</jet-button>
    </span>
</template>

<script>
import JetButton from '../Jetstream/Button.vue';

import {ref} from 'vue'

export default {
    components: {JetButton},
    emits: ['generated'],

    setup(props, context) {
        const processing = ref(false),
            error = ref(null)

        return {
            error,
            processing,

            generateImages() {
                processing.value = true

                axios.get('http://localhost/generate').then((res) => {
                    context.emit('generated', res.data)
                }).catch((err) => {
                    error.value = err?.response?.data?.message ?? err?.message
                }).then(() => {
                    processing.value = false
                })
            },
        }
    }
}
</script>
