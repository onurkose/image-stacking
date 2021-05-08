<template>
    <span>
        <jet-button @click="resetDB" :class="{ 'opacity-25': processing }"
                    :disabled="processing">Reset DB</jet-button>
    </span>
</template>

<script>
import JetButton from '../Jetstream/Button.vue';

import {ref} from 'vue'

export default {
    components: {JetButton},

    setup(props) {
        const processing = ref(false),
            error = ref(null)

        return {
            error,
            processing,

            resetDB() {
                processing.value = true

                axios.get('http://localhost/reset').then((res) => {
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
